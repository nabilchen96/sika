<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\AturanNilaiSamapta;

class AturanNilaiSamaptaController extends Controller
{
    public function index(){

        $data = AturanNilaiSamapta::all();

        return view('aturannilaisamapta.index')
            ->with('data', $data);
    }

    public function store(Request $request){

        $request->validate([
            'jenis_samapta' => 'required',
            'untuk'         => 'required',
            'ukuran_menit'  => 'required',
            'jumlah'        => 'required',
            'nilai'         => 'required',
        ]);

        AturanNilaiSamapta::create([
            'jenis_samapta' => $request->jenis_samapta,
            'untuk'         => $request->untuk,
            'ukuran_menit'  => $request->ukuran_menit,
            'jumlah'        => $request->jumlah,
            'nilai'         => $request->nilai
        ]);

        return back()->with(['sukses' => 'Data Berhasil Disimpan!']);
    }

    public function update(Request $request){

        $request->validate([
            'id_nilai_samapta' => 'required',
            'jenis_samapta' => 'required',
            'untuk'         => 'required',
            'ukuran_menit'  => 'required',
            'jumlah'        => 'required',
            'nilai'         => 'required',
        ]);

        $data = AturanNilaiSamapta::find($request->id_nilai_samapta);
        $data->update([
            'jenis_samapta' => $request->jenis_samapta,
            'untuk'         => $request->untuk,
            'ukuran_menit'  => $request->ukuran_menit,
            'jumlah'        => $request->jumlah,
            'nilai'         => $request->nilai
        ]);

        return back()->with(['sukses' => 'Data Berhasil disimpan!']);
    }

    public function destroy($id){

        $data = AturanNilaiSamapta::find($id);
        $data->delete();

        return back()->with(['sukses' => 'Data Berhasil Dihapus!']);
    }
}
