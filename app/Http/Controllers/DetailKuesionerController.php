<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kuesioner;
use App\DetailKuesioner;

class DetailKuesionerController extends Controller
{
    public function index($id){
        $data = Kuesioner::find($id);
        $soal = DetailKuesioner::where('id_kuesioner', $data->id_kuesioner)->get();
        return view('kuesioner.detail')->with('data', $data)->with('soal', $soal);
    }


    public function store(Request $request){
        $request->validate([
            'soal'          => 'required',
            'id_kuesioner'  => 'required',
            'jenis_soal'    => 'required'
        ]);

        $jawaban = !empty($request->jawaban) ? $request->jawaban : [];

        DetailKuesioner::create([
            'soal'          => $request->soal,
            'id_kuesioner'  => $request->id_kuesioner,
            'jenis_soal'    => $request->jenis_soal,
            'jawaban'       => \serialize($jawaban)
        ]);

        return back()->with(['sukses' => 'Data berhasil disimpan!']);

    }

    public function update(Request $request){

        $request->validate([
            'id_detail_kuesioner'   => 'required',
            'soal'                  => 'required',
            'id_kuesioner'          => 'required',
            'jenis_soal'            => 'required'
        ]);

        $jawaban    = !empty($request->jawaban) ? $request->jawaban : [];
        $data       = DetailKuesioner::find($request->id_detail_kuesioner);

        $data->update([
            'soal'          => $request->soal,
            'id_kuesioner'  => $request->id_kuesioner,
            'jenis_soal'    => $request->jenis_soal,
            'jawaban'       => \serialize($jawaban) 
        ]);

        return back()->with(['sukses' => 'Data berhasil diupdate!']);
    }

    public function destroy($id){
        $data = DetailKuesioner::find($id);
        $data->delete();

        return back()->with(['sukses' => 'Data berhasil dihapus!']);
    }
}
