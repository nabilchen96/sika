<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Template;
use DB;
use App\Template as TemplateSurat;

class TemplateController extends Controller
{
    public function index(){

        $data = DB::table('templates')->get();
        return view('/templatesurat.index')->with('data', $data);
    }

    public function store(Request $request){

        $request->validate([
            'judul_template'    => 'required',
            'kategori'          => 'required',
            'template'          => 'required',
            'keterangan'        => 'required'
        ]);

        $file = $request->file('template');
        $nama_file = $file->getClientOriginalName();
        $file->move('templatesurat', $nama_file);

        TemplateSurat::create([
            'judul_template'    => $request->judul_template,
            'kategori'          => $request->kategori,
            'template'          => $nama_file,
            'keterangan'        => $request->keterangan
        ]);

        return back()->with(['sukses' => 'Data Berhasil Disimpan!']);

    }

    public function destroy($id){

        $data = TemplateSurat::find($id)->delete();
        
        return back()->with(['sukses' => 'Data Berhasil Dihapus!']);
    }
}
