<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BatasPelanggaran;

class BatasPelanggaranController extends Controller
{
    public function index(){
        $data = BatasPelanggaran::all();
        return view('bataspelanggaran.index')->with('data', $data);
    }

    public function store(Request $request){
        $request->validate([
            'tingkat'       => 'required',
            'periode'       => 'required',
            'batas_kritis'  => 'required',
            'batas_maksimal'=> 'required'
        ]);

        batasPelanggaran::create([
            'tingkat'           => $request->input('tingkat'),
            'periode'           => $request->input('periode'),
            'batas_kritis'      => $request->input('batas_kritis'),
            'batas_maksimal'    => $request->input('batas_maksimal')
        ]);

        return back()->with(['sukses' => 'Data Berhasil Disimpan!']);
    }

    public function update(Request $request){
        $request->validate([
            'tingkat'               => 'required',
            'periode'               => 'required',
            'batas_kritis'          => 'required',
            'batas_maksimal'        => 'required',
            'id_batas_pelanggaran'  => 'required'
        ]);

        $batas = BatasPelanggaran::find($request->input('id_batas_pelanggaran'));
        $batas->update([
            'tingkat'               => $request->input('tingkat'),
            'periode'               => $request->input('periode'),
            'batas_kritis'          => $request->input('batas_kritis'),
            'batas_maksimal'        => $request->input('batas_maksimal'),
        ]);

        return back()->with(['sukses' => 'Data Berhasil Diupdate!']);

    }

    public function destroy($id){
        $data = BatasPelanggaran::find($id);
        $data->delete();

        return back()->with(['sukses' => 'Data Berhasil Dihapus!']);
    }
}
