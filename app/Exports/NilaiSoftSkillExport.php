<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;
use Auth;

class NilaiSoftSkillExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public $id_mahasiswa;


    public function __construct(int $id_mahasiswa){
    	$this->id_mahasiswa = $id_mahasiswa;
    }


    public function view(): View
    {
        $taruna = DB::table('tarunas')
                    ->leftjoin('penilaian_soft_skills', 'penilaian_soft_skills.id_mahasiswa', '=', 'tarunas.id_mahasiswa')
                    ->leftjoin('semesters', 'semesters.id_semester', '=', 'penilaian_soft_skills.id_semester')
                    ->leftjoin('komponen_softskills', 'komponen_softskills.id_komponen_softskill', '=', 'penilaian_soft_skills.id_komponen_softskill')
                    ->select(
                        'tarunas.id_mahasiswa', 
                        'tarunas.nim', 
                        'tarunas.nama_mahasiswa',
                        'penilaian_soft_skills.id_komponen_softskill',
                        'semesters.id_semester',
                        db::raw(
                            'group_concat(penilaian_soft_skills.id_nilai_softskill) as id_nilai_softskill',
                        ),
                        db::raw(
                            'group_concat(penilaian_soft_skills.id_komponen_softskill, komponen_softskills.jenis_softskill) as id_komponen_softskill',
                        ),
                        db::raw(
                            'group_concat(komponen_softskills.jenis_softskill) as jenis_softskill',
                        ),
                        db::raw(
                            'group_concat(penilaian_soft_skills.nilai) as nilai'
                        ),
                        db::raw(
                            'sum(penilaian_soft_skills.nilai) as nilai_softskill'
                        )
                    )
                    ->where('tarunas.id_mahasiswa', $this->id_mahasiswa)
                    ->get();

        $komponen_nilai = DB::table('komponen_softskills')
                        ->select(
                            'jenis_softskill',
                            db::raw(
                                'count(id_komponen_softskill) as nilai'
                            )
                        )
                        ->groupBy('jenis_softskill')
                        ->get();

        $nilai = DB::table('komponen_softskills')->get();
                  
        $total_soal = $nilai->count();

        return view('nilaisoftskill.export')
        ->with('total_soal', $total_soal)
        ->with('taruna', $taruna)
        ->with('komponen_nilai', $komponen_nilai);
    }
}
