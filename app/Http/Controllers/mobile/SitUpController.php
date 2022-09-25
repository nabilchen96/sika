<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;

class SitUpController extends Controller
{
    public function index(){
    
        $taruna = DB::table('tarunas')->get();

        $data = DB::table('penilaian_samaptas')
                    ->join('semesters', 'semesters.id_semester', '=', 'penilaian_samaptas.id_semester')
                    ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'penilaian_samaptas.id_mahasiswa')
                    ->where('semesters.is_semester_aktif', '1')
                    ->whereNotNull('penilaian_samaptas.jumlah_sit_up')
                    ->whereNotNull('penilaian_samaptas.nilai_sit_up');
                    
        if(request('cari')){
            $data = $data->where('tarunas.nama_mahasiswa', 'like', '%'.request('cari').'%')->get();
        }else{
            $data = $data->get();
        }

        return view('mobile.situp', [
            'data'  => $data
        ]);

    }
}
