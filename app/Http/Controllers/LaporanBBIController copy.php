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

                // $nilai_prodi = DB::table('penilaian_samaptas')
        //                 ->join(
        //                     'tarunas', 'tarunas.id_mahasiswa', '=', 'penilaian_samaptas.id_mahasiswa'
        //                 )->select(

        //                     'tarunas.nama_program_studi',
        //                     // DB::raw('sum(penilaian_samaptas.tinggi_badan) / count(tarunas.id_mahasiswa) as tinggi_badan'),

        //                     // DB::raw("case when tarunas.jenis_kelamin = 'L' then sum(penilaian_samaptas.tinggi_badan) end / count(tarunas.id_mahasiswa) as taruna"),
                            
        //                     DB::raw("case when tarunas.jenis_kelamin = 'P' then sum(penilaian_samaptas.tinggi_badan) end as taruni"),

        //                     // DB::raw("sum(case penilaian_samaptas.tinggi_badan when tarunas.jenis_kelamin = 'P' then 1 end) as taruni"),

        //                     // DB::raw('count(tarunas.id_mahasiswa) as total_taruna')

        //                 )->where('tarunas.nama_program_studi', 'Teknologi Rekayasa Bandar Udara');
        
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


        if($semester != null){

            // $nilai_prodi = $nilai_prodi->where('penilaian_samaptas.id_semester', $semester)->get();
            $nilai_jk = $nilai_jk->where('penilaian_samaptas.id_semester', $semester)->get();

        }else{

            // $nilai_prodi = $nilai_prodi->get();
            $nilai_jk = $nilai_jk->get();
        }


        return response()->json([
            // 'nilai_prodi' => $nilai_prodi,
            'nilai_jk' => $nilai_jk
        ]);
    }
}
