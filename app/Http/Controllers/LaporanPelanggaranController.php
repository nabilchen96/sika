<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class LaporanPelanggaranController extends Controller
{
    public function index(){

        $semester = Request('id_semester');

        $taruna = DB::table('catatan_pelanggarans')
                    ->join(
                        'pelanggarans', 'pelanggarans.id_pelanggaran', '=', 'catatan_pelanggarans.id_pelanggaran'
                    )
                    ->join(
                        'tarunas', 'tarunas.id_mahasiswa', '=', 'catatan_pelanggarans.id_mahasiswa'
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
                        DB::raw('sum(pelanggarans.poin_pelanggaran) as total_poin')
                    )
                    ->limit(10)
                    ->orderBy('total_poin', 'DESC')
                    ->groupBy('tarunas.id_mahasiswa');

                    
        if($semester != null){

            $taruna = $taruna->where('catatan_pelanggarans.id_semester', $semester)->get();
            $taruna = $taruna->sortBy(['total_poin', 'DESC']);

        }else{

            $taruna = $taruna->get();
            $taruna = $taruna->sortBy(['total_poin', 'DESC']);
        }

        // dd($taruna);

        return view('laporan_pelanggaran.index', [
            'taruna'    => $taruna
        ]);
    }

    public function data(){

        $semester = Request('id_semester');

        $pelanggaran = DB::table('catatan_pelanggarans')
                            ->join(
                                'pelanggarans', 'pelanggarans.id_pelanggaran', '=', 'catatan_pelanggarans.id_pelanggaran'
                            )
                            ->select(
                                DB::raw('count(catatan_pelanggarans.id_pelanggaran) as total_pelanggaran'),
                                'pelanggarans.pelanggaran'
                            )
                            ->groupBy('pelanggarans.id_pelanggaran')
                            ->limit(10);

        $pelanggaran_prodi = DB::table('catatan_pelanggarans')
                            ->join(
                                'pelanggarans', 'pelanggarans.id_pelanggaran', '=', 'catatan_pelanggarans.id_pelanggaran'
                            )
                            ->join(
                                'tarunas', 'tarunas.id_mahasiswa', '=', 'catatan_pelanggarans.id_mahasiswa'
                            )
                            ->select(
                                DB::raw("count(case when tarunas.nama_program_studi = 'Teknologi Rekayasa Bandar Udara' then 1 end) as TRBU"),
                                DB::raw("count(case when tarunas.nama_program_studi = 'Penyelamatan dan Pemadam Kebakaran Penerbangan' then 1 end) as PPKP"),
                                DB::raw("count(case when tarunas.nama_program_studi = 'Manajemen Bandar Udara' then 1 end) as MBU"),
                            );

        $pelanggaran_jk = DB::table('catatan_pelanggarans')
                            ->join(
                                'pelanggarans', 'pelanggarans.id_pelanggaran', '=', 'catatan_pelanggarans.id_pelanggaran'
                            )
                            ->join(
                                'tarunas', 'tarunas.id_mahasiswa', '=', 'catatan_pelanggarans.id_mahasiswa'
                            )
                            ->select(
                                DB::raw("count(case when jenis_kelamin = 'L' then 1 end) as laki_laki"),
                                DB::raw("count(case when jenis_kelamin = 'P' then 1 end) as perempuan")
                            );

        if($semester != null){

            $pelanggaran = $pelanggaran->where('catatan_pelanggarans.id_semester', $semester)->get();
            $pelanggaran_prodi = $pelanggaran_prodi->where('catatan_pelanggarans.id_semester', $semester)->get();
            $pelanggaran_jk = $pelanggaran_jk->where('catatan_pelanggarans.id_semester', $semester)->get();

        }else{

            $pelanggaran = $pelanggaran->get();
            $pelanggaran = $pelanggaran->sortBy(['total_pelanggaran', 'DESC'])->values();
            $pelanggaran_prodi = $pelanggaran_prodi->get();
            $pelanggaran_jk = $pelanggaran_jk->get();
        }


        return response()->json([
            'pelanggaran'       => $pelanggaran,
            'pelanggaran_prodi' => $pelanggaran_prodi,
            'pelanggaran_jk'    => $pelanggaran_jk
        ]);
    }
}
