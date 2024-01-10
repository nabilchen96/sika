<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\PenilaianSoftSkill;
use auth;
use App\Exports\NilaiSoftSkillExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class PenilaianSoftSkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if(auth::user()->role == 'admin' || Auth::user()->role == 'pusbangkar'){

            $data = DB::table('tarunas')->get();

        }elseif(auth::user()->role == 'taruna'){

            $data = DB::table('tarunas')->where('tarunas.nim', auth::user()->nip)->get();

        }else{

            $kordinator = DB::table('kordinator_pengasuhs')->where('id', auth::user()->id)->first();

            if($kordinator){
                $grup_kordinasi = DB::table('grup_kordinasi_pengasuhs')->where('id_kordinator_pengasuh', $kordinator->id_kordinator_pengasuh)->get();

                $data = DB::table('tarunas')
                            ->join('asuhans', 'asuhans.id_mahasiswa', '=', 'tarunas.id_mahasiswa')
                            ->join('users', 'users.id', '=', 'asuhans.id_pengasuh')
                            ->where(function($q) use ($grup_kordinasi) {
                                foreach($grup_kordinasi  as $k) {
                                    $q->orWhere('asuhans.id_pengasuh', $k->id);
                                }
                            })           
                            ->get();
            }else{

                $data = DB::table('tarunas')
                            ->join('asuhans', 'asuhans.id_mahasiswa', '=', 'tarunas.id_mahasiswa')
                            ->join('users', 'users.id', '=', 'asuhans.id_pengasuh')
                            ->where('asuhans.id_pengasuh', Auth::id())
                            ->get();
            }

        }

        $komponen_nilai = DB::table('komponen_softskills')->groupBy('jenis_softskill')->get();
        
        $nilai = [];

        foreach ($data as $key => $value) {

            
            $nilai_evaluasi = [];

            foreach ($komponen_nilai as $key => $k) {

                $total_soal     = 0;
                $total_nilai    = 0;

                $perevaluasi = DB::table('penilaian_soft_skills')
                                ->join('komponen_softskills','komponen_softskills.id_komponen_softskill','=','penilaian_soft_skills.id_komponen_softskill')
                                ->join('semesters', 'semesters.id_semester', '=', 'penilaian_soft_skills.id_semester')
                                ->where('semesters.id_semester', @$_GET['id_semester'])
                                ->where('penilaian_soft_skills.id_mahasiswa', $value->id_mahasiswa)
                                ->where('komponen_softskills.jenis_softskill', $k->jenis_softskill)
                                ->get();
                
                $total_nilai    = $perevaluasi->sum('nilai');
                $total_soal     = count($perevaluasi);

                $nilai_evaluasi[] = array(
                    'jenis_softskill'   => $k->jenis_softskill,
                    'nilai'             => $total_nilai != 0 ? $total_nilai / @$total_soal : 0
                );
            }
                
            if(@$_GET['id_semester']){
                $nilai[] = array(
                    'nama_mahasiswa'    => $value->nama_mahasiswa,
                    'id_mahasiswa'      => $value->id_mahasiswa,
                    'nim'               => $value->nim,
                    'perevaluasi'       => $nilai_evaluasi
                );
            }

        }


        return view('nilaisoftskill.index',[
            'nilai' => $nilai
        ]);
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
        $soal   = DB::table('komponen_softskills')
                    ->where('jenis_softskill', $jenis_softskill)
                    ->get();

        $taruna = DB::table('tarunas')->where('tarunas.id_mahasiswa', $id)->first(); 

        return view('nilaisoftskill.edit')
            ->with('soal', $soal)
            ->with('id_semester', @$_GET['id_semester'])
            ->with('taruna', $taruna);
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

    public function exportpdf($id_mahasiswa, $id_semester){

        $data = [
            'data' => DB::table('penilaian_soft_skills as psk')
                    ->join('komponen_softskills as ks', 'ks.id_komponen_softskill', '=', 'psk.id_komponen_softskill')
                    ->join('semesters as s', 's.id_semester', '=', 'psk.id_semester')
                    ->join('tarunas as t', 't.id_mahasiswa', '=', 'psk.id_mahasiswa')
                    ->where('psk.id_semester', $id_semester)
                    ->where('psk.id_mahasiswa', $id_mahasiswa)
                    ->get()
        ];


        // dd($data);

        $pdf = PDF::loadView('nilaisoftskill.exportpdf', $data);
        return $pdf->download('nilai softskill taruna.pdf');
    }
}
