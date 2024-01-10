<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;

class PembinaanController extends Controller
{
    public function index(){

        $data = DB::table('catatan_hukumen')
                ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'catatan_hukumen.id_mahasiswa')
                ->join('semesters', 'semesters.id_semester', '=', 'catatan_hukumen.id_semester')
                ->where('semesters.is_semester_aktif', '1')
                ->select(
                    'tarunas.nama_mahasiswa',
                    'tarunas.jenis_kelamin',
                    'tarunas.nama_program_studi',
                    'tarunas.nim',
                    'catatan_hukumen.id_catatan_hukuman',
                    'catatan_hukumen.created_at',
                    'catatan_hukumen.keterangan',
                    'catatan_hukumen.is_dikerjakan', 
                    'tarunas.foto',
                )
                ->orderBy('catatan_hukumen.is_dikerjakan', 'ASC');

        if(request('cari')){
            $data = $data->where('tarunas.nama_mahasiswa', 'like', '%'.request('cari').'%')->get();
        }else{
            $data = $data->get();
        }
        
        return view('mobile.pembinaan', [
            'data'  => $data
        ]);

    }
}
