<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;
use Auth;

class PenghargaanTarunaExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        
            if(auth::user()->role == 'taruna'){

                $taruna = DB::table('tarunas')->where('nim', auth::user()->nip)->value('id_mahasiswa');

                $data = DB::table('catatan_penghargaans')
                ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'catatan_penghargaans.id_mahasiswa')
                ->join('penghargaans', 'penghargaans.id_penghargaan', '=', 'catatan_penghargaans.id_penghargaan')
                ->where('catatan_penghargaans.id_mahasiswa', $taruna)
                ->select(
                    'tarunas.nama_mahasiswa',
                    'tarunas.nim',
                    'catatan_penghargaans.id_catatan_penghargaan',
                    'penghargaans.penghargaan',
                    'penghargaans.bidang_penghargaan',
                    'penghargaans.poin_penghargaan',
                    'catatan_penghargaans.created_at',
                    'tarunas.id_mahasiswa',
                    'catatan_penghargaans.tgl_penghargaan',
                    'catatan_penghargaans.sk_penghargaan',
                    'penghargaans.id_penghargaan'
                )
                ->get();
            }elseif(auth::user()->role == 'pengasuh'){

                $kordinator = DB::table('kordinator_pengasuhs')->where('id', auth::user()->id)->first();

                if($kordinator){
                    $grup_kordinasi = DB::table('grup_kordinasi_pengasuhs')->where('id_kordinator_pengasuh', $kordinator->id_kordinator_pengasuh)->get();

                    $data = DB::table('catatan_penghargaans')
                                ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'catatan_penghargaans.id_mahasiswa')
                                ->join('penghargaans', 'penghargaans.id_penghargaan', '=', 'catatan_penghargaans.id_penghargaan')
                                ->join('asuhans', 'asuhans.id_mahasiswa', '=', 'tarunas.id_mahasiswa')
                                ->join('users', 'users.id', '=', 'asuhans.id_pengasuh')
                                ->select(
                                    'tarunas.nama_mahasiswa',
                                    'tarunas.nim',
                                    'catatan_penghargaans.id_catatan_penghargaan',
                                    'penghargaans.penghargaan',
                                    'penghargaans.bidang_penghargaan',
                                    'penghargaans.poin_penghargaan',
                                    'catatan_penghargaans.created_at',
                                    'tarunas.id_mahasiswa',
                                    'catatan_penghargaans.tgl_penghargaan',
                                    'catatan_penghargaans.sk_penghargaan',
                                    'penghargaans.id_penghargaan'
                                )
                                ->where(function($q) use ($grup_kordinasi) {
                                    foreach($grup_kordinasi  as $k) {
                                        $q->orWhere('asuhans.id_pengasuh', $k->id);
                                    }
                                })   
                                ->get();

                    $taruna = null;
                }else{

                    $data = DB::table('catatan_penghargaans')
                                ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'catatan_penghargaans.id_mahasiswa')
                                ->join('penghargaans', 'penghargaans.id_penghargaan', '=', 'catatan_penghargaans.id_penghargaan')
                                ->join('asuhans', 'asuhans.id_mahasiswa', '=', 'tarunas.id_mahasiswa')
                                ->join('users', 'users.id', '=', 'asuhans.id_pengasuh')
                                ->select(
                                    'tarunas.nama_mahasiswa',
                                    'tarunas.nim',
                                    'catatan_penghargaans.id_catatan_penghargaan',
                                    'penghargaans.penghargaan',
                                    'penghargaans.bidang_penghargaan',
                                    'penghargaans.poin_penghargaan',
                                    'catatan_penghargaans.created_at',
                                    'tarunas.id_mahasiswa',
                                    'catatan_penghargaans.tgl_penghargaan',
                                    'catatan_penghargaans.sk_penghargaan',
                                    'penghargaans.id_penghargaan'
                                )
                                ->where('asuhans.id_pengasuh', Auth::id())
                                ->get();

                    $taruna = null;
                }                
            }else{
                $data = DB::table('catatan_penghargaans')
                        ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'catatan_penghargaans.id_mahasiswa')
                        ->join('penghargaans', 'penghargaans.id_penghargaan', '=', 'catatan_penghargaans.id_penghargaan')
                        ->select(
                            'tarunas.nama_mahasiswa',
                            'tarunas.nim',
                            'catatan_penghargaans.id_catatan_penghargaan',
                            'penghargaans.penghargaan',
                            'penghargaans.bidang_penghargaan',
                            'penghargaans.poin_penghargaan',
                            'catatan_penghargaans.created_at',
                            'tarunas.id_mahasiswa',
                            'catatan_penghargaans.tgl_penghargaan',
                            'catatan_penghargaans.sk_penghargaan',
                            'penghargaans.id_penghargaan'
                        )
                        ->get();

                $taruna = null;
            }


	return view('catatanpenghargaan.export')->with('data', $data);
    }
}
