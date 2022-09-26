<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;

class NilaiController extends Controller
{
    public function index(){

        $data   = DB::table('tarunas')
                    ->leftjoin('penilaian_samaptas', 'penilaian_samaptas.id_mahasiswa', '=', 'tarunas.id_mahasiswa')
                    ->leftjoin('semesters', 'semesters.id_semester', '=', 'penilaian_samaptas.id_semester')
                    ->groupBy('tarunas.id_mahasiswa');

        //JIKA ID MAHASISWA DAN ID SEMESTER KOSONG
        if(!request('id_mahasiswa') && !request('id_semester') ){
            $data = $data->where('semesters.is_semester_aktif', '1')->get();

        //JIKA ID MAHASISWA SEMUANYA
        }elseif(request('id_mahasiswa') == 'all'){
            $data = $data->where('semesters.id_semester', request('id_semester'))->get();

        //JIKA LAINNYA
        }else{
            
            $data = $data->where('semesters.id_semester', request('id_semester'))
                    ->where('tarunas.id_mahasiswa', request('id_mahasiswa'))->get();
        }

        return view('mobile.nilai', [
            'data'  => $data
        ]);
    }

    public function nilaiPelanggaran(){

        $data   = DB::table('tarunas')
                    ->leftjoin('catatan_pelanggarans', 'catatan_pelanggarans.id_mahasiswa', '=', 'tarunas.id_mahasiswa')
                    ->leftjoin('semesters', 'semesters.id_semester', '=', 'catatan_pelanggarans.id_semester')
                    ->select(
                        'tarunas.nama_mahasiswa', 
                        'tarunas.nama_program_studi', 
                        'tarunas.jenis_kelamin',
                        'tarunas.nim', 
                        'tarunas.id_mahasiswa',
                        'semesters.nama_semester',
                        'tarunas.foto',
                        DB::raw('sum(catatan_pelanggarans.poin_pelanggaran) as poin_semester')
                    )
                    ->orderBy('poin_semester', 'DESC')
                    ->groupBy('tarunas.id_mahasiswa');

        //JIKA ID MAHASISWA DAN ID SEMESTER KOSONG
        if(!request('id_mahasiswa') && !request('id_semester') ){
            $data = $data->where('semesters.is_semester_aktif', '1')->get();

        //JIKA ID MAHASISWA SEMUANYA
        }elseif(request('id_mahasiswa') == 'all'){
            $data = $data->where('semesters.id_semester', request('id_semester'))->get();

        //JIKA LAINNYA
        }else{
            
            $data = $data->where('semesters.id_semester', request('id_semester'))
                    ->where('tarunas.id_mahasiswa', request('id_mahasiswa'))->get();
        }

        return view('mobile.nilai-pelanggaran', [
            'data'  => $data
        ]);
    }

    public function nilaiPenghargaan(){

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
                        'penghargaans.bidang_penghargaan', 
                        'tarunas.foto',
                        DB::raw('sum(penghargaans.poin_penghargaan) as poin_semester')
                    )->orderBy('poin_semester', 'DESC')
                    ->groupBy('tarunas.id_mahasiswa');

        //JIKA ID MAHASISWA DAN ID SEMESTER KOSONG
        if(!request('id_mahasiswa') && !request('id_semester') ){
            $data = $data->where('semesters.is_semester_aktif', '1')->get();

        //JIKA ID MAHASISWA SEMUANYA
        }elseif(request('id_mahasiswa') == 'all'){
            $data = $data->where('semesters.id_semester', request('id_semester'))->get();

        //JIKA LAINNYA
        }else{
            
            $data = $data->where('semesters.id_semester', request('id_semester'))
                    ->where('tarunas.id_mahasiswa', request('id_mahasiswa'))->get();
        }

        return view('mobile.nilai-penghargaan', [
            'data'  => $data
        ]);
    }
}
