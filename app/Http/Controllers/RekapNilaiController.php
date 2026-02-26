<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\RekapNilai;
use auth;
use App\Exports\RekapNilaiExport;
// use App\Exports\NilaiSoftSkillExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class RekapNilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // dd('cok');

        $data = [];
        $data_nilai = [];

        if(auth::user()->role == 'admin' || auth::user()->role == 'pusbangkar'){

            $data = DB::table('tarunas')
                        ->whereNotIn(
                            'id_mahasiswa', function($query){
                                $query->select('id_mahasiswa')->from('rekap_nilais')->where('id_semester', @$_GET['id_semester']);
                            }
                        )
                        ->get();

            $nilai_sah = DB::table('rekap_nilais')
                            ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'rekap_nilais.id_mahasiswa')
                            ->where('rekap_nilais.id_semester', @$_GET['id_semester'])
                            ->get();
            
            // dd($nilai_sah);

        }elseif(auth::user()->role == 'taruna'){

            $data = DB::table('tarunas')->where('tarunas.nim', auth::user()->nip)
                        ->whereNotIn(
                            'id_mahasiswa', function($query){
                                $query->select('id_mahasiswa')->from('rekap_nilais')->where('id_semester', @$_GET['id_semester']);
                            }
                        )
                        ->get();

            $nilai_sah = DB::table('rekap_nilais')
                            ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'rekap_nilais.id_mahasiswa')
                            ->where('tarunas.nim', auth::user()->nip)
                            ->where('rekap_nilais.id_semester', @$_GET['id_semester'])
                            ->get();

        }else{

            $kordinator = DB::table('kordinator_pengasuhs')->where('id', auth::user()->id)->first();

            if($kordinator){

                $grup_kordinasi = DB::table('grup_kordinasi_pengasuhs')->where('id_kordinator_pengasuh', $kordinator->id_kordinator_pengasuh)->get();

                if(count($grup_kordinasi) != null){

                    $data = DB::table('tarunas')
                                    ->join('asuhans', 'asuhans.id_mahasiswa', '=', 'tarunas.id_mahasiswa')
                                    ->join('users', 'users.id', '=', 'asuhans.id_pengasuh')
                                    ->whereNotIn(
                                        'tarunas.id_mahasiswa', function($query){
                                            $query->select('id_mahasiswa')->from('rekap_nilais')->where('id_semester', @$_GET['id_semester']);
                                        }
                                    )
                                    ->where(function($q) use ($grup_kordinasi) {
                                        foreach($grup_kordinasi  as $k) {
                                            $q->orWhere('asuhans.id_pengasuh', $k->id);
                                        }
                                    })           
                                    ->get();
    
    
                    $nilai_sah = DB::table('rekap_nilais')
                                    ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'rekap_nilais.id_mahasiswa')
                                    ->join('asuhans', 'asuhans.id_mahasiswa', '=', 'rekap_nilais.id_mahasiswa')
                                    ->join('users', 'users.id', '=', 'asuhans.id_pengasuh')
                                    ->where('rekap_nilais.id_semester', @$_GET['id_semester'])
                                    ->where(function($q) use ($grup_kordinasi) {
                                        foreach($grup_kordinasi  as $k) {
                                            $q->orWhere('asuhans.id_pengasuh', $k->id);
                                        }
                                    })     
                                    ->get();
                }else{

                    $data = []; 
                    $nilai_sah = [];

                }

            }else{

                $data = DB::table('tarunas')
                            ->join('asuhans', 'asuhans.id_mahasiswa', '=', 'tarunas.id_mahasiswa')
                            ->join('users', 'users.id', '=', 'asuhans.id_pengasuh')
                            ->whereNotIn(
                                'tarunas.id_mahasiswa', function($query){
                                    $query->select('id_mahasiswa')->from('rekap_nilais')->where('id_semester', @$_GET['id_semester']);
                                }
                            )
                            ->where('asuhans.id_pengasuh', Auth::id())
                            ->get();

                
                $nilai_sah = DB::table('rekap_nilais')
                                ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'rekap_nilais.id_mahasiswa')
                                ->join('asuhans', 'asuhans.id_mahasiswa', '=', 'rekap_nilais.id_mahasiswa')
                                ->join('users', 'users.id', '=', 'asuhans.id_pengasuh')
                                ->where('rekap_nilais.id_semester', @$_GET['id_semester'])
                                ->where('asuhans.id_pengasuh', Auth::id())
                                ->get();
            }

        }

        $soal = DB::table('komponen_softskills')
                            ->groupBy('jenis_softskill')
                            ->orderBy('jenis_softskill', 'ASC')
                            ->where('status', 'AKTIF')
                            ->get();

        foreach ($data as $key => $value) {

            $nilai_jasmani = DB::table('penilaian_samaptas')
                                ->where('id_mahasiswa', $value->id_mahasiswa)
                                ->where('id_semester', @$_GET['id_semester'])
                                ->first();

            // $nilai = 0;    
            $nilai_evaluasi = [];                
            foreach ($soal as $key => $s) {

                $total_nilai     = 0;
                $total_soal    = 0;

                $perevaluasi = DB::table('penilaian_soft_skills')
                                ->join('komponen_softskills','komponen_softskills.id_komponen_softskill','=','penilaian_soft_skills.id_komponen_softskill')
                                ->join('semesters', 'semesters.id_semester', '=', 'penilaian_soft_skills.id_semester')
                                ->where('semesters.id_semester', @$_GET['id_semester'])
                                ->where('penilaian_soft_skills.id_mahasiswa', $value->id_mahasiswa)
                                ->where('komponen_softskills.jenis_softskill', $s->jenis_softskill)
                                // ->sum('nilai');
                                ->get();
                $total_nilai = $perevaluasi->sum('nilai');
                $total_soal  = count($perevaluasi);
                // $nilai = $nilai + ($perevaluasi/$s->nilai);

                $nilai_evaluasi[] = array(
                    // 'jenis_softskill'   => $k->jenis_softskill,
                    'nilai'             => $total_nilai != 0 ? $total_nilai / @$total_soal : 0
                );
            }

            // dd($nilai_evaluasi);
            
            // $nilai_softskill = $grand_total_soal != 0 
            //         ? $grand_total_nilai / $grand_total_soal 
            //         : 0;

            //nilai pelanggaran
            $nilai_pelanggaran = DB::table('catatan_pelanggarans')
                                ->join('semesters', 'semesters.id_semester', '=', 'catatan_pelanggarans.id_semester')
                                ->where('catatan_pelanggarans.id_mahasiswa', $value->id_mahasiswa)
                                ->where('semesters.id_semester', @$_GET['id_semester'])
                                ->sum('poin_pelanggaran');

            // dd($nilai_pelanggaran);

            // dd($nilai_pelanggaran);
            $nilai_pelanggaran = $nilai_pelanggaran != null ? 100 - $nilai_pelanggaran : 100;

            //nilai penghargaan
            $nilai_penghargaan = DB::table('catatan_penghargaans')
                                    ->join('semesters', 'semesters.id_semester', '=', 'catatan_penghargaans.id_semester')
                                    ->join('penghargaans', 'penghargaans.id_penghargaan', '=', 'catatan_penghargaans.id_penghargaan')
                                    ->where('catatan_penghargaans.id_mahasiswa', $value->id_mahasiswa)
                                    ->where('semesters.id_semester', @$_GET['id_semester'])
                                    ->sum('poin_penghargaan');

            $nilai_penghargaan > 100 ? $nilai_penghargaan = 100 : $nilai_penghargaan;

            // if(empty($nilai_penghargaan)){
            //     $nilai_penghargaan = 75;
            // }else{
            //     if($nilai_penghargaan > 100){
            //         $nilai_penghargaan = 100;
            //     }elseif($nilai_penghargaan < 100){
            //         $nilai_penghargaan = $nilai_penghargaan + 75;
            //     }
            // }

            if(@$_GET['id_semester']){
                $data_nilai[] = array(
                    'id_mahasiswa'      => $value->id_mahasiswa,
                    'nama_mahasiswa'    => $value->nama_mahasiswa,
                    'nim'               => $value->nim,
                    'nilai_jasmani'     => @$nilai_jasmani->nilai_samapta,
                    // 'nilai_softskill'   => @$nilai_softskill ? $nilai_softskill : 0,
                    'perevaluasi'       => count($nilai_evaluasi),
                    'nilai_pelanggaran' => @$nilai_pelanggaran,
                    'nilai_penghargaan' => @$nilai_penghargaan
                );
            }
            
        }

        // dd($data_nilai);

        return view('rekapnilai.index')
                ->with('nilai_sah', $nilai_sah)
                ->with('data_nilai', $data_nilai);
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
        // dd($request);

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

    public function rapot($id){

        $datas = [  
                        'data' =>
                        $data = DB::table('rekap_nilais')
                        ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'rekap_nilais.id_mahasiswa')
                        ->join('semesters', 'semesters.id_semester', '=', 'rekap_nilais.id_semester')
                        ->where('rekap_nilais.id_mahasiswa', $id)
                        ->first(),

                        'nilai_jasmani' => 
                        $nilai_jasmani = DB::table('penilaian_samaptas')
                                    ->where('id_semester', $data->id_semester)
                                    ->where('id_mahasiswa', $id)
                                    ->first()
                ];


        $pdf = PDF::loadView('rekapnilai.rapot', $datas);  
        return $pdf->download('rapot non akademik taruna.pdf'); 
    }

    public function export($id){
        return Excel::download(new RekapNilaiExport($id), 'Rekap Nilai Taruna.xlsx');
    }
}
