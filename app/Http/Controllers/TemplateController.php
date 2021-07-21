<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Template;
use DB;
use App\Template as TemplateSurat;

class TemplateController extends Controller
{
    public function index(){

        $data = TemplateSurat::all();
        return view('/templatesurat.index')->with('data', $data);
    }

    public function store(Request $request){

        $request->validate([
            'judul_template'    => 'required',
            'kategori'          => 'required|unique:templates',
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

    public function update(Request $request){
        $request->validate([
            'id_template'       => 'required',
            'judul_template'    => 'required',
            'kategori'          => 'required',
            'keterangan'        => 'required'
        ]);

        $data = TemplateSurat::find($request->id_template);

        if(empty($request->file('template'))){

            $nama_file = $data->template;

        }else{

            $file = $request->file('template');
            $nama_file = $file->getClientOriginalName();
            $file->move('templatesurat', $nama_file);

            @$path = public_path("templatesurat/").$data->template;
            unlink(@$path);
        }

        $data->update([
            'judul_template'    => $request->judul_template,
            'kategori'          => $request->kategori,
            'template'          => $nama_file,
            'keterangan'        => $request->keterangan
        ]);

        return back()->with(['sukses' => 'Data Berhasil Diedit!']);
    }

    public function destroy($id){

        $data = TemplateSurat::find($id)->delete();
        
        return back()->with(['sukses' => 'Data Berhasil Dihapus!']);
    }
}
