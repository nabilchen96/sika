<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\AturanNilaibbi;


class AturanNilaibbiController extends Controller
{
    public function index(){

        $data = AturanNilaibbi::all();

        return view('aturannilaibbi.index')
                ->with('data', $data);
    }

    public function store(Request $request){

        // dd($request);

        $request->validate([
            'bmi'       => 'required',
            'untuk'     => 'required',
            'stakes'    => 'required',
            'nilai'     => 'required'
        ]);

        AturanNilaibbi::create([
            'bmi'   => $request->bmi,
            'untuk' => $request->untuk,
            'stakes'=> $request->stakes,
            'nilai' => $request->nilai
        ]);

        return back()->with(['sukses' => 'Data Berhasil Disimpan!']);
    }

    public function update(Request $request){

        $request->validate([
            'id_nilai_bbi' => 'required',
            'bmi'       => 'required',
            'untuk'     => 'required',
            'stakes'    => 'required',
            'nilai'     => 'required'
        ]);

        $data = AturanNilaibbi::find($request->id_nilai_bbi);
        $data->update([
            'bmi'   => $request->bmi,
            'untuk' => $request->untuk,
            'stakes'=> $request->stakes,
            'nilai' => $request->nilai
        ]);

        return back()->with(['sukses' => 'Data Berhasil Diupdate!']);
    }

    public function destroy($id){

        $data = AturanNilaibbi::find($id);
        $data->delete();

        return back()->with(['sukses' => 'Data berhasil dihapus!']);
    }
}
