<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;
use auth;

class AsuhanExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
            if(Auth::user()->role == 'pengasuh'){
                $kordinator = DB::table('kordinator_pengasuhs')->where('id', auth::user()->id)->first();

                if($kordinator){
                    //jika dia adalah kordinator pengasuh maka tampilkan semua taruna yang diasuh oleh semua pengasuh di bawahnya
                    $grup_kordinasi = DB::table('grup_kordinasi_pengasuhs')->where('id_kordinator_pengasuh', $kordinator->id_kordinator_pengasuh)->get();

                    $data= DB::table('asuhans')
                        ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'asuhans.id_mahasiswa')
                        ->join('users', 'users.id', '=', 'asuhans.id_pengasuh')
                        ->where(function($q) use ($grup_kordinasi) {

                            foreach($grup_kordinasi  as $k) {
                                $q->orWhere('asuhans.id_pengasuh', $k->id);
                            }

                        })->get();

                }else{
                    //jika dia bukan kordinator pengasuh maka tampilkan hanya taruna yang diasuhnya saja
                    $data = DB::table('asuhans')
                            ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'asuhans.id_mahasiswa')
                            ->join('users', 'users.id', '=', 'asuhans.id_pengasuh')
                            ->where('asuhans.id_pengasuh', Auth::id())            
                            ->get();
                }

            }elseif(Auth::user()->role == 'admin' or auth::user()->role == 'pusbangkar'){

                $data = DB::table('asuhans')
                        ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'asuhans.id_mahasiswa')
                        ->join('users', 'users.id', '=', 'asuhans.id_pengasuh')         
                        ->get();
            }

	return view('asuhan.export')->with('data', $data);
    }
}
