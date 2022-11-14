<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class LaporanPenilaianController extends Controller
{
    public function index(){

        return view('laporan_penilaian.index');
    }

    public function data(){

        $semester = Request('id_semester');

        $nilai_prodi = DB::table('rekap_nilais')
                        ->join(
                            'tarunas', 'tarunas.id_mahasiswa', '=', 'rekap_nilais.id_mahasiswa'
                        )->select(

                            'tarunas.nama_program_studi',
                            DB::raw('sum(rekap_nilais.nilai_samapta) / count(tarunas.id_mahasiswa) as nilai_samapta'),
                            DB::raw('sum(rekap_nilais.nilai_softskill) / count(tarunas.id_mahasiswa) as nilai_softskill'),
                            DB::raw('sum(rekap_nilais.nilai_pelanggaran) / count(tarunas.id_mahasiswa) as nilai_pelanggaran'),
                            DB::raw('sum(rekap_nilais.nilai_penghargaan) / count(tarunas.id_mahasiswa) as nilai_penghargaan'),

                            DB::raw('

                                (sum(rekap_nilais.nilai_samapta) / count(tarunas.id_mahasiswa) / 100 * 40) +

                                (((sum(rekap_nilais.nilai_softskill) / count(tarunas.id_mahasiswa) / 100 * 50) +
                                (sum(rekap_nilais.nilai_pelanggaran) / count(tarunas.id_mahasiswa) / 100 * 25) +
                                (sum(rekap_nilais.nilai_penghargaan) / count(tarunas.id_mahasiswa) / 100 * 25)) / 100 * 60)

                                as total_nilai
                            '),
                            DB::raw('count(tarunas.id_mahasiswa) as total_taruna')

                        )->groupBy(
                            'tarunas.nama_program_studi'
                        );


        $nilai_jk = DB::table('rekap_nilais')
                        ->join(
                            'tarunas', 'tarunas.id_mahasiswa', '=', 'rekap_nilais.id_mahasiswa'
                        )->select(

                            'tarunas.jenis_kelamin',
                            DB::raw('sum(rekap_nilais.nilai_samapta) / count(tarunas.id_mahasiswa) as nilai_samapta'),
                            DB::raw('sum(rekap_nilais.nilai_softskill) / count(tarunas.id_mahasiswa) as nilai_softskill'),
                            DB::raw('sum(rekap_nilais.nilai_pelanggaran) / count(tarunas.id_mahasiswa) as nilai_pelanggaran'),
                            DB::raw('sum(rekap_nilais.nilai_penghargaan) / count(tarunas.id_mahasiswa) as nilai_penghargaan'),

                            DB::raw('

                                (sum(rekap_nilais.nilai_samapta) / count(tarunas.id_mahasiswa) / 100 * 40) +

                                (((sum(rekap_nilais.nilai_softskill) / count(tarunas.id_mahasiswa) / 100 * 50) +
                                (sum(rekap_nilais.nilai_pelanggaran) / count(tarunas.id_mahasiswa) / 100 * 25) +
                                (sum(rekap_nilais.nilai_penghargaan) / count(tarunas.id_mahasiswa) / 100 * 25)) / 100 * 60)

                                as total_nilai
                            '),
                            DB::raw('count(tarunas.id_mahasiswa) as total_taruna')

                        )->groupBy(
                            'tarunas.jenis_kelamin'
                        );

        

        if($semester != null){

            $nilai_prodi = $nilai_prodi->where('rekap_nilais.id_semester', $semester)->get();
            $nilai_jk = $nilai_jk->where('rekap_nilais.id_semester', $semester)->get();

        }else{

            $nilai_prodi = $nilai_prodi->get();
            $nilai_jk = $nilai_jk->get();
        }


        return response()->json([
            'nilai_prodi' => $nilai_prodi,
            'nilai_jk' => $nilai_jk
        ]);
    }

    function dataJasmani(){
        $semester = Request('id_semester');

        $nilai_prodi = DB::table('penilaian_samaptas')
                        ->join(
                            'tarunas', 'tarunas.id_mahasiswa', '=', 'penilaian_samaptas.id_mahasiswa'
                        )->select(

                            'tarunas.nama_program_studi',
                            DB::raw('sum(penilaian_samaptas.nilai_lari) / count(tarunas.id_mahasiswa) as nilai_lari'),
                            DB::raw('sum(penilaian_samaptas.nilai_push_up) / count(tarunas.id_mahasiswa) as nilai_push_up'),
                            DB::raw('sum(penilaian_samaptas.nilai_sit_up) / count(tarunas.id_mahasiswa) as nilai_sit_up'),
                            DB::raw('sum(penilaian_samaptas.nilai_shuttle_run) / count(tarunas.id_mahasiswa) as nilai_shuttle_run'),
                            DB::raw('count(tarunas.id_mahasiswa) as total_taruna')

                        )->groupBy(
                            'tarunas.nama_program_studi'
                        );

        $nilai_jk = DB::table('penilaian_samaptas')
                        ->join(
                            'tarunas', 'tarunas.id_mahasiswa', '=', 'penilaian_samaptas.id_mahasiswa'
                        )->select(

                            'tarunas.jenis_kelamin',
                            DB::raw('sum(penilaian_samaptas.nilai_lari) / count(tarunas.id_mahasiswa) as nilai_lari'),
                            DB::raw('sum(penilaian_samaptas.nilai_push_up) / count(tarunas.id_mahasiswa) as nilai_push_up'),
                            DB::raw('sum(penilaian_samaptas.nilai_sit_up) / count(tarunas.id_mahasiswa) as nilai_sit_up'),
                            DB::raw('sum(penilaian_samaptas.nilai_shuttle_run) / count(tarunas.id_mahasiswa) as nilai_shuttle_run'),
                            DB::raw('count(tarunas.id_mahasiswa) as total_taruna')

                        )->groupBy(
                            'tarunas.jenis_kelamin'
                        );


        if($semester != null){

            $nilai_prodi = $nilai_prodi->where('penilaian_samaptas.id_semester', $semester)->get();
            $nilai_jk = $nilai_jk->where('penilaian_samaptas.id_semester', $semester)->get();

        }else{

            $nilai_prodi = $nilai_prodi->get();
            $nilai_jk = $nilai_jk->get();
        }


        return response()->json([
            'nilai_prodi' => $nilai_prodi,
            'nilai_jk' => $nilai_jk
        ]);
    }
}
