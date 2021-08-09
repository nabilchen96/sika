<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\PenilaianSoftSkill;
use auth;
use App\Exports\NilaiSoftSkillExport;
use Maatwebsite\Excel\Facades\Excel;

class PenilaianSoftSkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(auth::user()->role == 'pengasuh'){

            $kordinator = DB::table('kordinator_pengasuhs')->where('id', auth::user()->id)->first();

                if($kordinator){

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

                    $data = DB::table('asuhans')
                            ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'asuhans.id_mahasiswa')
                            ->join('users', 'users.id', '=', 'asuhans.id_pengasuh')
                            ->where('asuhans.id_pengasuh', Auth::id())            
                            ->get();

                }

        }else{
            $data = DB::table('tarunas')->get();
        }


        if($request->id_mahasiswa){
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
                        ->where('tarunas.id_mahasiswa', $request->id_mahasiswa)
                        ->get();
        }else{
            if(auth::user()->role == 'taruna'){
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
                        ->where('tarunas.nim', auth::user()->nip)
                        ->where('semesters.id_semester', $request->id_semester)
                        ->get();
            }else{
                $taruna = [];
            }
        }

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

        return view('nilaisoftskill.index')
                    ->with('total_soal', $total_soal)
                    ->with('taruna', $taruna)
                    ->with('data', $data)
                    ->with('komponen_nilai', $komponen_nilai);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('nilaisoftskill.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $jenis_softskill)
    {
        $soal   = DB::table('komponen_softskills')->where('jenis_softskill', $jenis_softskill)->get();

        $taruna = DB::table('tarunas')->where('tarunas.id_mahasiswa', $id)->first(); 

        return view('nilaisoftskill.edit')->with('soal', $soal)->with('taruna', $taruna);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // dd($_GET['id_mahasiswa']);

        for ($i=0; $i < count($request->nilai); $i++) { 
            PenilaianSoftskill::updateOrCreate(
                [
                    'id_mahasiswa'          => $request->id_mahasiswa,
                    'id_komponen_softskill' => $request->id_komponen_softskill[$i],
                    'id_semester'           => DB::table('semesters')->where('is_semester_aktif', 1)->value('id_semester'),
                ],
                [
                    'nilai' => $request->nilai[$i]
                ]
            );   
        }

        return back()->with(['sukses' => 'Data berhasil disimpan']);
    }   

    public function export($id_mahasiswa){

        return Excel::download(new NilaiSoftSkillExport($id_mahasiswa), 'Nilai Softskill Taruna.xlsx');
    }
}
