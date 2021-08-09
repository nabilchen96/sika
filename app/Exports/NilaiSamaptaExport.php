<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;
use Auth;

class NilaiSamaptaExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public $id_semester;

    public function __construct(int $id_semester){
    	$this->id_semester = $id_semester;
    }	

    public function view(): View
    {
        if(auth::user()->role == 'admin'){

            $data = DB::table('penilaian_samaptas')
                        ->join('semesters', 'semesters.id_semester', '=', 'penilaian_samaptas.id_semester')
                        ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'penilaian_samaptas.id_mahasiswa')
                        ->where('semesters.id_semester', $this->id_semester)
                        ->get();

        }elseif(auth::user()->role == 'taruna'){

            $data = DB::table('penilaian_samaptas')
                        ->join('semesters', 'semesters.id_semester', '=', 'penilaian_samaptas.id_semester')
                        ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'penilaian_samaptas.id_mahasiswa')
                        ->where('semesters.id_semester', $this->id_semester)
                        ->where('tarunas.nim', auth::user()->nip)
                        ->get();

        }else{

            $kordinator = DB::table('kordinator_pengasuhs')->where('id', auth::user()->id)->first();

            if($kordinator){

                $grup_kordinasi = DB::table('grup_kordinasi_pengasuhs')->where('id_kordinator_pengasuh', $kordinator->id_kordinator_pengasuh)->get();

                $data = DB::table('penilaian_samaptas')
                            ->join('semesters', 'semesters.id_semester', '=', 'penilaian_samaptas.id_semester')
                            ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'penilaian_samaptas.id_mahasiswa')
                            ->join('asuhans', 'asuhans.id_mahasiswa', '=', 'tarunas.id_mahasiswa')
                            ->join('users', 'users.id', '=', 'asuhans.id_pengasuh')
                            ->where('semesters.id_semester', $this->id_semester)
                            ->where(function($q) use ($grup_kordinasi) {
                                foreach($grup_kordinasi  as $k) {
                                    $q->orWhere('asuhans.id_pengasuh', $k->id);
                                }
                            })           
                            ->get();
            }else{
                $data = DB::table('penilaian_samaptas')
                            ->join('semesters', 'semesters.id_semester', '=', 'penilaian_samaptas.id_semester')
                            ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'penilaian_samaptas.id_mahasiswa')
                            ->join('asuhans', 'asuhans.id_mahasiswa', '=', 'tarunas.id_mahasiswa')
                            ->join('users', 'users.id', '=', 'asuhans.id_pengasuh')
                            ->where('semesters.id_semester', $this->id_semester)
                            ->where('asuhans.id_pengasuh', Auth::id())
                            ->get();
            }            
        }
	return view('nilaisamapta.export')->with('data', $data);
    }
}
