<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;
use Auth;

class RekapNilaiExport implements FromView
{

    public $id_semester;

    public function __construct(int $id_semester){
    	$this->id_semester = $id_semester;
    }	

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {

        $data = [];
        $data_nilai = [];

        if(auth::user()->role == 'admin' || auth::user()->role == 'pusbangkar'){

            $data = DB::table('rekap_nilais')
                            ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'rekap_nilais.id_mahasiswa')
                            ->where('rekap_nilais.id_semester', $this->id_semester)
                            ->get();

        }elseif(auth::user()->role == 'taruna'){

            $data = DB::table('rekap_nilais')
                            ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'rekap_nilais.id_mahasiswa')
                            ->where('tarunas.nim', auth::user()->nip)
                            ->where('rekap_nilais.id_semester', $this->id_semester)
                            ->get();

        }else{

            $kordinator = DB::table('kordinator_pengasuhs')->where('id', auth::user()->id)->first();

            if($kordinator){

                $grup_kordinasi = DB::table('grup_kordinasi_pengasuhs')->where('id_kordinator_pengasuh', $kordinator->id_kordinator_pengasuh)->get();

                if(count($grup_kordinasi) != null){

                    $data = DB::table('rekap_nilais')
                                    ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'rekap_nilais.id_mahasiswa')
                                    ->join('asuhans', 'asuhans.id_mahasiswa', '=', 'rekap_nilais.id_mahasiswa')
                                    ->join('users', 'users.id', '=', 'asuhans.id_pengasuh')
                                    ->where('rekap_nilais.id_semester', $this->id_semester)
                                    ->where(function($q) use ($grup_kordinasi) {
                                        foreach($grup_kordinasi  as $k) {
                                            $q->orWhere('asuhans.id_pengasuh', $k->id);
                                        }
                                    })     
                                    ->get();
                }else{

                    $data = []; 

                }

            }else{
                
                $data = DB::table('rekap_nilais')
                                ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'rekap_nilais.id_mahasiswa')
                                ->join('asuhans', 'asuhans.id_mahasiswa', '=', 'rekap_nilais.id_mahasiswa')
                                ->join('users', 'users.id', '=', 'asuhans.id_pengasuh')
                                ->where('rekap_nilais.id_semester', $this->id_semester)
                                ->where('asuhans.id_pengasuh', Auth::id())
                                ->get();
            }

        }

        return view('rekapnilai.export')->with('data', $data);
    }
}
