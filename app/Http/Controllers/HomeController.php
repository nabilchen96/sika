<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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
}
