<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\RekapNilai;

class RekapNilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $data = DB::table('tarunas')->get();

        if($request->id_mahasiswa){

            $data_nilai = DB::table('rekap_nilais')
                            ->join('semesters', 'semesters.id_semester', '=', 'rekap_nilais.id_semester')
                            ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'rekap_nilais.id_mahasiswa')
                            ->where('semesters.is_semester_aktif', "1")
                            ->where('rekap_nilais.id_mahasiswa', $request->id_mahasiswa)
                            ->first();

            if($data_nilai == null){

                $taruna = DB::table('tarunas')->where('id_mahasiswa', $request->id_mahasiswa)->first();

                //nilai jasmani
                $nilai_jasmani = DB::table('penilaian_samaptas')
                                ->leftjoin('semesters', 'semesters.id_semester', '=', 'penilaian_samaptas.id_semester')
                                ->where('semesters.is_semester_aktif', "1")
                                ->where('penilaian_samaptas.id_mahasiswa', $request->id_mahasiswa)
                                ->first();

                $soal           = DB::table('komponen_softskills')
                                    ->select(
                                        'jenis_softskill',
                                        db::raw(
                                            'count(id_komponen_softskill) as nilai'
                                        )
                                    )
                                    ->groupBy('jenis_softskill')
                                    ->get();

                $nilai = 0;
                foreach ($soal as $key => $value) {
                    
                    $perevaluasi = DB::table('penilaian_soft_skills')
                                    ->join('komponen_softskills','komponen_softskills.id_komponen_softskill','=','penilaian_soft_skills.id_komponen_softskill')
                                    ->join('semesters', 'semesters.id_semester', '=', 'penilaian_soft_skills.id_semester')
                                    ->where('semesters.is_semester_aktif', '1')
                                    ->where('penilaian_soft_skills.id_mahasiswa', $request->id_mahasiswa)
                                    ->where('komponen_softskills.jenis_softskill', $value->jenis_softskill)
                                    ->sum('nilai');

                    $nilai = $nilai + ($perevaluasi/$value->nilai);
                }
                
                $nilai_softskill =  $nilai / $soal->count('nilai');

                //nilai pelanggaran
                $nilai_pelanggaran = DB::table('catatan_pelanggarans')
                                    ->join('semesters', 'semesters.id_semester', '=', 'catatan_pelanggarans.id_semester')
                                    ->where('catatan_pelanggarans.id_mahasiswa', $request->id_mahasiswa)
                                    ->where('semesters.is_semester_aktif', "1")
                                    ->sum('poin_pelanggaran');
                
                // dd($nilai_pelanggaran);
                $nilai_pelanggaran = $nilai_pelanggaran != null ? 100 - $nilai_pelanggaran : 0;

                //nilai penghargaan
                $nilai_penghargaan = DB::table('catatan_penghargaans')
                                    ->join('semesters', 'semesters.id_semester', '=', 'catatan_penghargaans.id_semester')
                                    ->join('penghargaans', 'penghargaans.id_penghargaan', '=', 'catatan_penghargaans.id_penghargaan')
                                    ->where('catatan_penghargaans.id_mahasiswa', $request->id_mahasiswa)
                                    ->where('semesters.is_semester_aktif', "1")
                                    ->sum('poin_penghargaan');
                $nilai_penghargaan == 100 ? $nilai_penghargaan = 100 : $nilai_penghargaan;

                $data_nilai[] = array(
                    'nama_mahasiswa'    => @$taruna->nama_mahasiswa,
                    'nim'               => @$taruna->nim,
                    'id_mahasiswa'      => @$taruna->id_mahasiswa,
                    'id_semester'       => @$nilai_jasmani->id_semester,
                    'nilai_jasmani'     => @$nilai_jasmani->nilai_samapta ? $nilai_jasmani->nilai_samapta : 0,
                    'nilai_softskill'   => @$nilai_softskill ? $nilai_softskill : 0,
                    'nilai_pelanggaran' => @$nilai_pelanggaran,
                    'nilai_penghargaan' => @$nilai_penghargaan,
                );

                // dd($data_nilai);
            }else{  
                $data_nilai;
            }

        }else{
            $data_nilai = [];
        }

        // dd($data_nilai->nama_mahasiswa);

        
        return view('rekapnilai.index')
                ->with('data_nilai', $data_nilai)
                ->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_mahasiswa'      => 'required',
            'id_semester'       => 'required',
            'nilai_samapta'     => 'required',
            'nilai_softskill'   => 'required',
            'nilai_pelanggaran' => 'required',
            'nilai_penghargaan' => 'required',
        ]);


        RekapNilai::create([
            'id_mahasiswa'  => $request->id_mahasiswa,
            'id_semester'   => $request->id_semester,
            'nilai_samapta' => $request->nilai_samapta,
            'nilai_softskill'   => $request->nilai_softskill,
            'nilai_pelanggaran' => $request->nilai_pelanggaran,
            'nilai_penghargaan' => $request->nilai_penghargaan
        ]);

        return back()->with(['sukses' => 'Data berhasil disimpan!']);
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
