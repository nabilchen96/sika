<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kamar;
use Illuminate\Support\Facades\Validator;
use DB;

class KamarController extends Controller
{
    public function index(){
        $kamar  = DB::table('kamars')->get();
        return view('kamar.index')->with('kamar', $kamar);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'nama_kamar'    => 'required',
            'nama_asrama'   => 'required',
            'batas_kamar'   => 'required',
            'submit'        => 'required',
        ]);

        if($validator->fails()){
            return back()
                ->with(['submit' => $request->input('submit')])
                ->withErrors($validator, 'data');
        }

        Kamar::create([
            'nama_kamar'    => $request->input('nama_kamar'),
            'nama_asrama'   => $request->input('nama_asrama'),
            'batas_kamar'   => $request->input('batas_kamar')
        ]);

        return back()->with(['sukses' => 'Data Berhasil Ditambahkan']);
    }

    public function update(Request $request){

        $validator = Validator::make($request->all(), [
            'nama_kamar'    => 'required',
            'nama_asrama'   => 'required',
            'submit'        => 'required',
            'id_kamar'      => 'required',
            'batas_kamar'   => 'required'
        ]);

        if($validator->fails()){
            return back()
                ->with(['submit' => $request->input('submit')])
                ->withErrors($validator, 'data');
        }

        $kamar = Kamar::find($request->input('id_kamar'));
        $kamar->update([
            'nama_kamar'    => $request->input('nama_kamar'),
            'nama_asrama'   => $request->input('nama_asrama'),
            'batas_kamar'   => $request->input('batas_kamar')
        ]);

        return back()->with(['sukses' => 'Data Berhasil Diupdate']);
    }

    public function destroy($id){
        $kamar = Kamar::find($id);
        $kamar->delete();

        return back()->with(['sukses' => 'Data Berhasil Dihapus']);
    }
}
