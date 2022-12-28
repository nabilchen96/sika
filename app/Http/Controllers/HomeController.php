<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $taruna     = DB::table('tarunas')->count();
        $pengasuh   = DB::table('users')->where('role', 'pengasuh')->count();
        $semester   = DB::table('semesters')->where('is_semester_aktif', 1)->first();
        $hukuman    = DB::table('catatan_hukumen')
                        ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'catatan_hukumen.id_mahasiswa')
                        ->join('asuhans', 'asuhans.id_mahasiswa', '=', 'tarunas.id_mahasiswa')
                        ->join('users', 'users.id', '=', 'asuhans.id_pengasuh')
                        ->where('users.id', auth::id())
                        ->where('catatan_hukumen.is_dikerjakan', "0")
                        ->count();

        return view('home')
            ->with('taruna', $taruna)
            ->with('pengasuh', $pengasuh)
            ->with('semester', $semester)
            ->with('hukuman', $hukuman);
    }

    public function testcron(){
        $poin = DB::table('catatan_pelanggarans')
                ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'catatan_pelanggarans.id_mahasiswa')
                ->select(
                    DB::raw('sum(catatan_pelanggarans.poin_pelanggaran) as poin'),
                    'tarunas.nim',
                    'tarunas.nama_mahasiswa'
                )
                ->whereMonth('catatan_pelanggarans.created_at', '=', date('m'))
                ->groupBy('catatan_pelanggarans.id_mahasiswa')
                ->get();

        
    }


    public function totalTaruna(){


        $jenis_kelamin = DB::table('tarunas')
                            ->select(
                                DB::raw("count(case when jenis_kelamin = 'L' then 1 end) as laki_laki"),
                                DB::raw("count(case when jenis_kelamin = 'P' then 1 end) as perempuan")
                                
                            )
                            ->get();

        $prodi          = DB::table('tarunas')
                            ->select(
                                DB::raw("count(case when nama_program_studi = 'Teknologi Rekayasa Bandar Udara' then 1 end) as TRBU"),
                                DB::raw("count(case when nama_program_studi = 'Penyelamatan dan Pemadam Kebakaran Penerbangan' then 1 end) as PPKP"),
                                DB::raw("count(case when nama_program_studi = 'Manajemen Bandar Udara' then 1 end) as MBU"),
                                
                            )
                            ->get();

        $semester       = DB::table('tarunas')
                            ->select(
                                DB::raw("count(semester) as total_semester"),
                                'semester'
                            )
                            ->groupBy('semester')
                            ->get();


        return response()->json([
            'jenis_kelamin' => $jenis_kelamin, 
            'prodi'         => $prodi, 
            'semester'      => $semester
        ]);
    }

    Public function pelanggaranPenghargaanTerbanyak(){

        $pelanggaran = DB::table('catatan_pelanggarans')
                            ->join(
                                'pelanggarans', 'pelanggarans.id_pelanggaran', '=', 'catatan_pelanggarans.id_pelanggaran'
                            )
                            ->select(
                                DB::raw('count(catatan_pelanggarans.id_pelanggaran) as total_pelanggaran'),
                                'pelanggarans.pelanggaran'
                            )
                            ->groupBy('pelanggarans.id_pelanggaran')
                            ->limit(5)
                            ->get();

        $penghargaan = DB::table('catatan_penghargaans')
                            ->join(
                                'penghargaans', 'penghargaans.id_penghargaan', '=', 'catatan_penghargaans.id_penghargaan'
                            )
                            ->select(
                                DB::raw('count(catatan_penghargaans.id_penghargaan) as total_penghargaan'),
                                'penghargaans.penghargaan'
                            )
                            ->groupBy('penghargaans.id_penghargaan')
                            ->limit(5)
                            ->get();

        return response()->json([
            'pelanggaran'   => $pelanggaran,
            'penghargaan'   => $penghargaan,
        ]);
    }
    
}
