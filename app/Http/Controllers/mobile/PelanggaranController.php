<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;

class PelanggaranController extends Controller
{
    public function index(){

        $data   = DB::table('tarunas')
                    ->leftjoin('catatan_pelanggarans', 'catatan_pelanggarans.id_mahasiswa', '=', 'tarunas.id_mahasiswa')
                    ->leftjoin('semesters', 'semesters.id_semester', '=', 'catatan_pelanggarans.id_semester')
                    ->where('semesters.is_semester_aktif', '1')
                    ->select(
                        'tarunas.nama_mahasiswa', 
                        'tarunas.nama_program_studi', 
                        'tarunas.jenis_kelamin',
                        'tarunas.nim', 
                        'tarunas.id_mahasiswa',
                        DB::raw('sum(catatan_pelanggarans.poin_pelanggaran) as poin_semester')
                    )
                    ->orderBy('poin_semester', 'DESC')
                    ->groupBy('tarunas.id_mahasiswa');

        if(request('cari')){
            $data = $data->where('tarunas.nama_mahasiswa', 'like', '%'.request('cari').'%')->get();
        }else{
            $data = $data->get();
        }
        
        return view('mobile.pelanggaran', [
            'data'  => $data
        ]);

    }

    public function detail($id){

        $data = DB::table('catatan_pelanggarans')
                    ->join('pelanggarans', 'pelanggarans.id_pelanggaran', '=', 'catatan_pelanggarans.id_pelanggaran')
                    ->join('semesters', 'semesters.id_semester', '=', 'catatan_pelanggarans.id_semester')
                    ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'catatan_pelanggarans.id_mahasiswa')
                    ->select(
                        'catatan_pelanggarans.*',
                        'pelanggarans.pelanggaran',
                        'tarunas.nama_mahasiswa',
                        'tarunas.id_mahasiswa', 
                        'tarunas.jenis_kelamin', 
                        'tarunas.nim', 
                        'tarunas.nama_program_studi'
                    )
                    ->where('semesters.is_semester_aktif', '1')
                    ->where('catatan_pelanggarans.id_mahasiswa', $id)
                    ->get();

        return view('mobile.detail-pelanggaran', [
            'data'  => $data
        ]);
    }
}
