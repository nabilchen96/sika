<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;
use Auth;

class RekapNilaiExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        if (auth::user()->role == 'admin' && auth::user()->role == 'pusbangkar'){

            $data = DB::table('rekap_nilais')
                        ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'rekap_nilais.id_mahasiswa')
                        ->join('semesters', 'semesters.id_semester', '=', 'rekap_nilais.id_semester')
                        ->where('semesters.is_semester_aktif', '1')
                        ->get();
            
        }elseif(auth::user()->role == 'pengasuh'){

            $kordinator = DB::table('kordinator_pengasuhs')->where('id', auth::user()->id)->first();

            if($kordinator){
                $grup_kordinasi = DB::table('grup_kordinasi_pengasuhs')->where('id_kordinator_pengasuh', $kordinator->id_kordinator_pengasuh)->get();

                $data = DB::table('rekap_nilais')
                        ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'rekap_nilais.id_mahasiswa')
                        ->join('semesters', 'semesters.id_semester', '=', 'rekap_nilais.id_semester')
                        ->join('asuhans', 'asuhans.id_mahasiswa', '=', 'tarunas.id_mahasiswa')
                        ->join('users', 'users.id', '=', 'asuhans.id_pengasuh')
                        ->where(function($q) use ($grup_kordinasi) {
                            foreach($grup_kordinasi  as $k) {
                                $q->orWhere('asuhans.id_pengasuh', $k->id);
                            }

                        })
                        ->where('semesters.is_semester_aktif', '1')
                        ->get();

            }else{

                $data = DB::table('rekap_nilais')
                        ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'rekap_nilais.id_mahasiswa')
                        ->join('semesters', 'semesters.id_semester', '=', 'rekap_nilais.id_semester')
                        ->join('asuhans', 'asuhans.id_mahasiswa', '=', 'tarunas.id_mahasiswa')
                        ->join('users', 'users.id', '=', 'asuhans.id_pengasuh')
                        ->where('asuhans.id_pengasuh', Auth::id())
                        ->where('semesters.is_semester_aktif', '1')
                        ->get();
            }
        }


        return view('rekapnilai.export')->with('data', $data);
    }
}
