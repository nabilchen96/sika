<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DetailKuesioner;
use DB;
use App\JawabanKuesioner;

class JawabanKuesionerController extends Controller
{
    public function index(Request $request){

        $taruna = [];
        $soal   = [];
        $nim    = [];

        if($request->nim){
            
            $taruna = DB::table('alumnis')
                    ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'alumnis.id_mahasiswa')
                    ->where('tarunas.nim', $request->nim)
                    ->first();

            if($taruna != null){
                $soal = DB::table('kuesioners')
                        ->join('detail_kuesioners', 'detail_kuesioners.id_kuesioner', '=', 'kuesioners.id_kuesioner')
                        ->where('kuesioners.status', '1')
                        ->get();

                $nim = $request->nim;
            }else{
                return back()->with(['gagal' => 'Taruna belum lulus atau NIT yang dimasukkan tidak tepat!']);
            }
        }

        return view('kuesioner.isikuesioner')
                    ->with('nim', $nim)
                    ->with('soal', $soal)
                    ->with('taruna', $taruna);
    }

    public function store(Request $request){

        for($i=1; $i<count($request->all())-1; $i++){
            JawabanKuesioner::create([
                'id_alumni'             => $request->id_alumni,
                'id_detail_kuesioner'   => $request->$i['id_detail_kuesioner'],
                'jawaban'               => $request->$i['jawaban']
            ]);
        }

        return back()->with(['sukses' => 'Data berhasil dikirim!']);

    }
}
