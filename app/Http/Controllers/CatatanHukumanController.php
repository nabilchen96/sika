<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\CatatanHukuman;

class CatatanHukumanController extends Controller
{
    public function index(Request $request){

        if(!$request->input('id_mahasiswa')){
            $data = [];
        }else{
            $data = DB::table('catatan_hukumen')
            ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'catatan_hukumen.id_mahasiswa')
            ->where('catatan_hukumen.id_mahasiswa', $request->input('id_mahasiswa'))
            ->select(
                'tarunas.nama_mahasiswa',
                'tarunas.nim',
                'catatan_hukumen.id_catatan_hukuman',
                'catatan_hukumen.created_at',
                'catatan_hukumen.keterangan',
                'catatan_hukumen.is_dikerjakan'
            )
            ->get();
        }

        return view('catatanhukuman.index')->with('data', $data);
    }

    public function updatestatus($id){
        $data = CatatanHukuman::find($id);
        $data->update([
            'is_dikerjakan' => '1'
        ]);
        return back()->with(['sukses' => 'Tugas Berhasil Diupdate!']);
    }

    public function updatehukuman(Request $request){
        $request->validate([
            'keterangan'            => 'required',
            'id_catatan_hukuman'    => 'required'
        ]);

        $data = CatatanHukuman::find($request->input('id_catatan_hukuman'));
        $data->update([
            'keterangan'    => $request->input('keterangan')
        ]);

        return back()->with(['sukses' => 'Hukuman Berhasil Diupdate!']);
    }
}
