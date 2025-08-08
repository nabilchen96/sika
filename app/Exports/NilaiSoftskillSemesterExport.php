<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;
use Auth;

class NilaiSoftskillSemesterExport implements FromView
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

        if (Auth::user()->role == 'admin' || Auth::user()->role == 'pusbangkar') {
        $data = DB::table('tarunas')->get();
    } elseif (Auth::user()->role == 'taruna') {
        $data = DB::table('tarunas')->where('tarunas.nim', Auth::user()->nip)->get();
    } else {
        $kordinator = DB::table('kordinator_pengasuhs')->where('id', Auth::user()->id)->first();

        if ($kordinator) {
            $grup_kordinasi = DB::table('grup_kordinasi_pengasuhs')->where('id_kordinator_pengasuh', $kordinator->id_kordinator_pengasuh)->get();

            $data = DB::table('tarunas')
                ->join('asuhans', 'asuhans.id_mahasiswa', '=', 'tarunas.id_mahasiswa')
                ->join('users', 'users.id', '=', 'asuhans.id_pengasuh')
                ->where(function ($q) use ($grup_kordinasi) {
                    foreach ($grup_kordinasi as $k) {
                        $q->orWhere('asuhans.id_pengasuh', $k->id);
                    }
                })
                ->get();
        } else {
            $data = DB::table('tarunas')
                ->join('asuhans', 'asuhans.id_mahasiswa', '=', 'tarunas.id_mahasiswa')
                ->join('users', 'users.id', '=', 'asuhans.id_pengasuh')
                ->where('asuhans.id_pengasuh', Auth::id())
                ->get();
        }
    }

    $nilai = [];

    foreach ($data as $taruna) {
        // Ambil semua nilai softskill mahasiswa ini pada semester terkait
        $penilaian = DB::table('penilaian_soft_skills')
            ->join('komponen_softskills', 'komponen_softskills.id_komponen_softskill', '=', 'penilaian_soft_skills.id_komponen_softskill')
            ->where('penilaian_soft_skills.id_mahasiswa', $taruna->id_mahasiswa)
            ->where('penilaian_soft_skills.id_semester', $this->id_semester)
            ->pluck('penilaian_soft_skills.nilai');

        $total_nilai = $penilaian->sum();
        $jumlah_nilai = $penilaian->count();
        $rata_rata = $jumlah_nilai > 0 ? round($total_nilai / $jumlah_nilai, 2) : 0;

        $nilai[] = [
            'nama_mahasiswa' => $taruna->nama_mahasiswa,
            'nim' => $taruna->nim,
            'nilai_softskill' => $rata_rata,
        ];
    }

    // dd($nilai); // Debug bila perlu

        return view('nilaisoftskill.semesterexport')
            ->with('nilai',  $nilai);
    }
}
