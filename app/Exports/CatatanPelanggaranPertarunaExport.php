<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;
use auth;

class CatatanPelanggaranPertarunaExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public $id;

    public function __construct(int $id)
    {
	$this->id = $id;
    }
	
    public function view(): View
    {
        $data = DB::table('catatan_pelanggarans')
                    ->join('pelanggarans', 'pelanggarans.id_pelanggaran', '=', 'catatan_pelanggarans.id_pelanggaran')
                    ->join('semesters', 'semesters.id_semester', '=', 'catatan_pelanggarans.id_semester')
                    ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'catatan_pelanggarans.id_mahasiswa')
                    ->select(
                        'catatan_pelanggarans.*',
                        'pelanggarans.pelanggaran',
                        'tarunas.nama_mahasiswa',
                        'tarunas.id_mahasiswa'
                    )
                    ->where('semesters.is_semester_aktif', '1')
                    ->where('catatan_pelanggarans.id_mahasiswa', $this->id)
                    ->get();

	return view('catatanpelanggaran.exportperson')->with('data', $data);
    }
}
