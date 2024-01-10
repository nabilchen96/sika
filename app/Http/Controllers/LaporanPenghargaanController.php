<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;   

class LaporanPenghargaanController extends Controller
{
    public function index(){


        $semester = Request('id_semester');

        $taruna = DB::table('catatan_penghargaans')
                    ->join(
                        'penghargaans', 'penghargaans.id_penghargaan', '=', 'catatan_penghargaans.id_penghargaan'
                    )
                    ->join(
                        'tarunas', 'tarunas.id_mahasiswa', '=', 'catatan_penghargaans.id_mahasiswa'
                    )
                    ->select(
                        // DB::raw("count(case when tarunas.nama_program_studi = 'Teknologi Rekayasa Bandar Udara' then 1 end) as TRBU"),
                        // DB::raw("count(case when tarunas.nama_program_studi = 'Penyelamatan dan Pemadam Kebakaran Penerbangan' then 1 end) as PPKP"),
                        // DB::raw("count(case when tarunas.nama_program_studi = 'Manajemen Bandar Udara' then 1 end) as MBU"),
                        'tarunas.nama_mahasiswa',
                        'tarunas.nim',
                        'tarunas.foto',
                        'tarunas.nama_program_studi',
                        'tarunas.semester',
                        DB::raw('sum(penghargaans.poin_penghargaan) as total_poin')
                    )
                    ->limit(10)
                    ->orderBy('total_poin', 'DESC')
                    ->groupBy('tarunas.id_mahasiswa');

                    
        if($semester != null){

            $taruna = $taruna->where('catatan_penghargaans.id_semester', $semester)->get();
            $taruna = $taruna->sortBy(['total_poin', 'DESC']);

        }else{

            $taruna = $taruna->get();
            $taruna = $taruna->sortBy(['total_poin', 'DESC']);
        }

        // dd($taruna);

        return view('laporan_penghargaan.index', [
            'taruna'    => $taruna
        ]);
    }

    public function data(){

        $semester = Request('id_semester');

        $penghargaan = DB::table('catatan_penghargaans')
                            ->join(
                                'penghargaans', 'penghargaans.id_penghargaan', '=', 'catatan_penghargaans.id_penghargaan'
                            )
                            ->select(
                                DB::raw('count(catatan_penghargaans.id_penghargaan) as total_penghargaan'),
                                'penghargaans.penghargaan'
                            )
                            ->groupBy('penghargaans.id_penghargaan')
                            ->limit(10);

        $penghargaan_prodi = DB::table('catatan_penghargaans')
                            ->join(
                                'penghargaans', 'penghargaans.id_penghargaan', '=', 'catatan_penghargaans.id_penghargaan'
                            )
                            ->join(
                                'tarunas', 'tarunas.id_mahasiswa', '=', 'catatan_penghargaans.id_mahasiswa'
                            )
                            ->select(
                                DB::raw("count(case when tarunas.nama_program_studi = 'Teknologi Rekayasa Bandar Udara' then 1 end) as TRBU"),
                                DB::raw("count(case when tarunas.nama_program_studi = 'Penyelamatan dan Pemadam Kebakaran Penerbangan' then 1 end) as PPKP"),
                                DB::raw("count(case when tarunas.nama_program_studi = 'Manajemen Bandar Udara' then 1 end) as MBU"),
                            );

        $penghargaan_jk = DB::table('catatan_penghargaans')
                            ->join(
                                'penghargaans', 'penghargaans.id_penghargaan', '=', 'catatan_penghargaans.id_penghargaan'
                            )
                            ->join(
                                'tarunas', 'tarunas.id_mahasiswa', '=', 'catatan_penghargaans.id_mahasiswa'
                            )
                            ->select(
                                DB::raw("count(case when jenis_kelamin = 'L' then 1 end) as laki_laki"),
                                DB::raw("count(case when jenis_kelamin = 'P' then 1 end) as perempuan")
                            );

        if($semester != null){

            $penghargaan = $penghargaan->where('catatan_penghargaans.id_semester', $semester)->get();
            $penghargaan_prodi = $penghargaan_prodi->where('catatan_penghargaans.id_semester', $semester)->get();
            $penghargaan_jk = $penghargaan_jk->where('catatan_penghargaans.id_semester', $semester)->get();

        }else{

            $penghargaan = $penghargaan->get();
            $penghargaan = $penghargaan->sortBy(['total_penghargaan', 'DESC'])->values();
            $penghargaan_prodi = $penghargaan_prodi->get();
            $penghargaan_jk = $penghargaan_jk->get();
        }


        return response()->json([
            'penghargaan'       => $penghargaan,
            'penghargaan_prodi' => $penghargaan_prodi,
            'penghargaan_jk'    => $penghargaan_jk
        ]);
    }
}
