<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DewanKehormatan;
use Illuminate\Support\Facades\Validator;
use DB;

class DewanKehormatanController extends Controller
{
    public function index(){
        $dewan  = DB::table('dewan_kehormatans')->get();
        return view('dewan.index')->with('dewan', $dewan);
    }

    public function store(Request $request){

       
        DewanKehormatan::create([
            'nama_pejabat'          => $request->input('nama_pejabat'),
            'jabatan'               => $request->input('jabatan'),
            'jabatan_kepanitiaan'   => $request->input('jabatan_kepanitiaan')
        ]);

        return back()->with(['sukses' => 'Data Berhasil Ditambahkan']);
    }

    public function update(Request $request){

       
        $dewan = DewanKehormatan::find($request->input('id'));

        $dewan->update([
            'nama_pejabat'          => $request->input('nama_pejabat'),
            'jabatan'               => $request->input('jabatan'),
            'jabatan_kepanitiaan'   => $request->input('jabatan_kepanitiaan')
        ]);

        return back()->with(['sukses' => 'Data Berhasil Diupdate']);
    }

    public function destroy($id){
        $kamar = DewanKehormatan::find($id);
        $kamar->delete();

        return back()->with(['sukses' => 'Data Berhasil Dihapus']);
    }
    
}
