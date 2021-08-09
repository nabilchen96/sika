<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;
use auth;

class CatatanPelanggaranExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
	if(auth::user()->role == 'taruna'){

            $taruna = DB::table('tarunas')->where('nim', auth::user()->nip)->get();

        }elseif(auth::user()->role == 'pengasuh'){

            $taruna = DB::table('asuhans')
                    ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'asuhans.id_mahasiswa')
                    ->join('users', 'users.id', '=', 'asuhans.id_pengasuh')
                    ->where('asuhans.id_pengasuh', Auth::id())            
                    ->get();
        }else{
            $taruna = DB::table('tarunas')->get();
        }

        $data = [];

            foreach ($taruna as $value) {
            
                $poin_semester_ini = DB::table('catatan_pelanggarans')
                                        ->join('semesters', 'semesters.id_semester', '=', 'catatan_pelanggarans.id_semester')
                                        ->where('semesters.is_semester_aktif', '1')
                                        ->where('catatan_pelanggarans.id_mahasiswa', $value->id_mahasiswa)
                                        ->sum('catatan_pelanggarans.poin_pelanggaran');
    
                $poin_bulan_ini = DB::table('catatan_pelanggarans')
                                        ->join('semesters', 'semesters.id_semester', '=', 'catatan_pelanggarans.id_semester')
                                        ->whereMonth('catatan_pelanggarans.created_at', date('m'))
                                        ->where('catatan_pelanggarans.id_mahasiswa', $value->id_mahasiswa)
                                        ->sum('catatan_pelanggarans.poin_pelanggaran');            
    
                $data[] = array(
                    'nim'                   => $value->nim,
                    'id_mahasiswa'          => $value->id_mahasiswa,
                    'nama_mahasiswa'        => $value->nama_mahasiswa,
                    'poin_semester_ini'     => $poin_semester_ini,
                    'poin_bulan_ini'        => $poin_bulan_ini,
                    'nama_program_studi'    => $value->nama_program_studi,
                    'jenis_kelamin'         => $value->jenis_kelamin
                );
            }
        return view('catatanpelanggaran.exportall')->with('data', $data);
    }
}
