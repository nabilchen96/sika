<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\KomponenSoftskill;

class KomponenSoftskillController extends Controller
{
    public function index(){

        $data = KomponenSoftskill::all();
        return view('komponensoftskill.index')->with('data', $data);
    }

    public function store(Request $request){

        $request->validate([
            'jenis_softskill' => 'required',
            'keterangan_softskill' => 'required'
        ]);

        KomponenSoftskill::create([
            'jenis_softskill'   => $request->jenis_softskill,
            'keterangan_softskill'  => $request->keterangan_softskill
        ]);

        return back()->with(['sukses' => 'Data Berhasil disimpan!']);
    }

    public function update(Request $request){

        $request->validate([
            'id_komponen_softskill' => 'required',
            'jenis_softskill'       => 'required',
            'keterangan_softskill'  => 'required'
        ]);

        $data = KomponenSoftskill::find($request->id_komponen_softskill);
        $data->update([
            'jenis_softskill'   => $request->jenis_softskill,
            'keterangan_softskill'  => $request->keterangan_softskill
        ]);

        return back()->with(['sukses' => 'Data Berhasil diperbarui']);
    }

    public function destroy($id){

        $data = KomponenSoftskill::find($id);
        $data->delete();

        return back()->with(['sukses' => 'Data berhasil dihapus!']);
    }
}
