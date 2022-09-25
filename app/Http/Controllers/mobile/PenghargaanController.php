<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;

class PenghargaanController extends Controller
{
    public function index(){
        $data   = DB::table('tarunas')
                    ->join('catatan_penghargaans', 'catatan_penghargaans.id_mahasiswa', '=', 'tarunas.id_mahasiswa')
                    ->join('penghargaans', 'penghargaans.id_penghargaan', '=', 'catatan_penghargaans.id_penghargaan')
                    ->join('semesters', 'semesters.id_semester', '=', 'catatan_penghargaans.id_semester')
                    ->where('semesters.is_semester_aktif', '1')
                    ->select(
                        'tarunas.nama_mahasiswa', 
                        'tarunas.nama_program_studi', 
                        'tarunas.jenis_kelamin',
                        'tarunas.nim', 
                        'tarunas.id_mahasiswa',
                        'catatan_penghargaans.tgl_penghargaan',
                        'penghargaans.penghargaan', 
                        'penghargaans.poin_penghargaan', 
                        'penghargaans.bidang_penghargaan'
                    );

        if(request('cari')){
            $data = $data->where('tarunas.nama_mahasiswa', 'like', '%'.request('cari').'%')->get();
        }else{
            $data = $data->get();
        }
        
        return view('mobile.penghargaan', [
            'data'  => $data
        ]);
    }
}
