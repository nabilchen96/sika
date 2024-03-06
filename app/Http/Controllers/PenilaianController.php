<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class PenilaianController extends Controller
{
    public function rekapnilai(Request $request){

        $semester = DB::table('semesters')->get();


        $data = [];

        // dd('cok');

        if($request->id_semester != null){
            $data = DB::table('tarunas')
                    ->leftjoin('catatan_pelanggarans', 'catatan_pelanggarans.id_mahasiswa', '=', 'tarunas.id_mahasiswa')
                    ->leftjoin('catatan_penghargaans', 'catatan_penghargaans.id_mahasiswa', '=', 'tarunas.id_mahasiswa')
                    ->leftjoin('penghargaans', 'penghargaans.id_penghargaan', '=', 'catatan_penghargaans.id_penghargaan')
                    ->where('catatan_pelanggarans.id_semester', $request->id_semester)
                    ->select(
                        'tarunas.id_mahasiswa',
                        'tarunas.nama_mahasiswa',
                        'tarunas.nim',
                        db::raw('sum(catatan_pelanggarans.poin_pelanggaran) as poin_pelanggaran'),
                        db::raw('sum(penghargaans.poin_penghargaan) as poin_penghargaan')
                    )   
                    ->groupBy('tarunas.id_mahasiswa')
                    ->get();
        }

        return view('penilaian.rekapnilai')
                ->with('data', $data)
                ->with('semester', $semester);
    }


    public function laporannilai(){

        return view('penilaian.laporannilai');
    }
}
