<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class LaporanBBIController extends Controller
{
    public function index(){

        return view('laporan_bbi.index');
    }

    public function data(){

        $semester = Request('id_semester');

        $nilai_jk = DB::table('penilaian_samaptas')
                        ->join(
                            'tarunas', 'tarunas.id_mahasiswa', '=', 'penilaian_samaptas.id_mahasiswa'
                        )->select(

                            'tarunas.jenis_kelamin',
                            DB::raw('sum(penilaian_samaptas.tinggi_badan) / count(tarunas.id_mahasiswa) as tinggi_badan'),
                            DB::raw('count(tarunas.id_mahasiswa) as total_taruna')

                        )->groupBy(
                            'tarunas.jenis_kelamin'
                        );
        
        $jk_berat = DB::table('penilaian_samaptas')
                        ->join(
                            'tarunas', 'tarunas.id_mahasiswa', '=', 'penilaian_samaptas.id_mahasiswa'
                        )->select(

                            'tarunas.jenis_kelamin',
                            DB::raw('sum(penilaian_samaptas.berat_badan) / count(tarunas.id_mahasiswa) as berat_badan'),
                            DB::raw('count(tarunas.id_mahasiswa) as total_taruna')

                        )->groupBy(
                            'tarunas.jenis_kelamin'
                        );

        if($semester != null){

            $nilai_jk = $nilai_jk->where('penilaian_samaptas.id_semester', $semester)->get();
            $jk_berat = $jk_berat->where('penilaian_samaptas.id_semester', $semester)->get();

        }else{

            $nilai_jk = $nilai_jk->get();
            $jk_berat = $jk_berat->get();
        }


        return response()->json([
            'nilai_jk' => $nilai_jk,
            'jk_berat' => $jk_berat
        ]);
    }

    public function data2(){

        $semester = Request('id_semester');

        $stakes = DB::table('penilaian_samaptas')
                        ->select(

                            'penilaian_samaptas.stakes',
                            DB::raw('count(penilaian_samaptas.stakes) as total_stakes'),

                        )->groupBy(
                            'penilaian_samaptas.stakes'
                        );

        if($semester != null){

            $stakes = $stakes->where('penilaian_samaptas.id_semester', $semester)->get();

        }else{

            $stakes = $stakes->get();
        }


        return response()->json([
            'stakes' => $stakes,
        ]);
    }
}
