<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Penghargaan;
use Illuminate\Support\Facades\Validator;

class PenghargaanController extends Controller
{
    public function index(){
        $penghargaan = Penghargaan::all();
        return view('penghargaan.index')->with('penghargaan', $penghargaan);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'penghargaan'       => 'required',
            'poin_penghargaan'  => 'required',
            'submit'            => 'required',
            'bidang_penghargaan'=> 'required'
        ]);

        if($validator->fails()){
            return back()
                ->with(['submit' => $request->input('submit')])
                ->withErrors($validator, 'data');
        }

        Penghargaan::create([
            'penghargaan'       => $request->input('penghargaan'),
            'poin_penghargaan'  => $request->input('poin_penghargaan'),
            'bidang_penghargaan'=> $request->input('bidang_penghargaan')
        ]);

        return back()->with(['sukses' => 'Data Berhasil Diupdate']);
    }

    public function update(Request $request){

        $validator = Validator::make($request->all(), [
            'penghargaan'       => 'required',
            'poin_penghargaan'  => 'required',
            'submit'            => 'required',
            'bidang_penghargaan'=> 'required',
            'id_penghargaan'    => 'required'
        ]);

        if($validator->fails()){
            return back()
                ->with(['submit' => $request->input('submit')])
                ->withErrors($validator, 'data');
        }

        $penghargaan = Penghargaan::find($request->input('id_penghargaan'));
        $penghargaan->update([
            'penghargaan'       => $request->input('penghargaan'),
            'poin_penghargaan'  => $request->input('poin_penghargaan'),
            'bidang_penghargaan'=> $request->input('bidang_penghargaan')
        ]);

        return back()->with(['sukses' => 'Data Berhasil Diupdate']);
    }

    public function destroy($id){
        $penghargaan = Penghargaan::find($id);
        $penghargaan->delete();

        return back()->with(['sukses' => 'Data Berhasil Dihapus']);
    }
}
