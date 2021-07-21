<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use auth;
use App\PenilaianSamapta;

class PenilaianSamaptaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth::user()->role == 'admin'){

            $taruna = DB::table('tarunas')->get();

            $data = DB::table('penilaian_samaptas')
                    ->join('semesters', 'semesters.id_semester', '=', 'penilaian_samaptas.id_semester')
                    ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'penilaian_samaptas.id_mahasiswa')
                    ->where('semesters.is_semester_aktif', 1)
                    ->get();

        }else{
            $taruna = DB::table('asuhans')
            ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'asuhans.id_mahasiswa')
            ->join('users', 'users.id', '=', 'asuhans.id_pengasuh')
            ->where('asuhans.id_pengasuh', Auth::id())            
            ->get();

            $data = [];
        }

        return view('nilaisamapta.index')->with('taruna', $taruna)->with('data', $data);
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
            'lari'          => 'required',
            'pushup'        => 'required',
            'situp'         => 'required',
            'shuttlerun'    => 'required',
            'tinggibadan'   => 'required',
            'beratbadan'    => 'required',
            'id_mahasiswa'  => 'required',
        ]);

        $taruna = DB::table('tarunas')
                    ->where('id_mahasiswa', $request->id_mahasiswa)
                    ->value('jenis_kelamin');

        $nilai = DB::table('aturan_nilai_samaptas')
                    ->where('untuk', $taruna == 'L' ? 'Taruna' : 'Taruni')
                    ->get();

        
        $nilai_lari         = $nilai->where('jenis_samapta', 'Lari')->where('jumlah', $request->lari)->first();
        $nilai_pushup       = $nilai->where('jenis_samapta', 'Push-up')->where('jumlah', $request->pushup)->first();
        $nilai_situp        = $nilai->where('jenis_samapta', 'Sit-up')->where('jumlah', $request->situp)->first();
        $nilai_shuttlerun   = $nilai->where('jenis_samapta', 'Shuttle Run')->where('jumlah', $request->shuttlerun)->first();


        if(@$nilai_lari         == null)  return back()->with(['gagal' => 'nilai lari tidak ditemukan']);
        if(@$nilai_situp        == null)  return back()->with(['gagal' => 'nilai Sit Up tidak ditemukan']); 
        if(@$nilai_pushup       == null)  return back()->with(['gagal' => 'nilai Push Up tidak ditemukan']); 
        if(@$nilai_shuttlerun   == null)  return back()->with(['gagal' => 'nilai Shuttle Run tidak ditemukan']); 

        $nilai_samapta  = ($nilai_lari->nilai + (($nilai_pushup->nilai + $nilai_situp->nilai + $nilai_shuttlerun->nilai) / 3)) / 2;

        $nilai_samapta  = $nilai_samapta / 100 * 70;

        $bmi = $request->beratbadan / pow(($request->tinggibadan/100), 2);
        
        $bbi = DB::table('aturan_nilaibbis')
                ->where('untuk', $taruna == 'L' ? 'Taruna' : 'Taruni')
                ->where('bmi', '=', round($bmi))
                ->first();

        $nilai_bbi = $bbi->nilai / 100 * 30;

        PenilaianSamapta::create([
            'id_mahasiswa'  => $request->id_mahasiswa,
            'id_semester'   => DB::table('semesters')->where('is_semester_aktif', 1)->value('id_semester'),
            'jarak_lari'    => $request->lari,
            'nilai_lari'    => $nilai_lari->nilai,
            'jumlah_push_up'=> $request->pushup,
            'nilai_push_up' => $nilai_pushup->nilai,
            'jumlah_sit_up' => $request->situp,
            'nilai_sit_up'  => $nilai_situp->nilai,
            'jumlah_shuttle_run'    => $request->shuttlerun,
            'nilai_shuttle_run'     => $nilai_shuttlerun->nilai,
            'tinggi_badan'  => $request->tinggibadan,
            'berat_badan'   => $request->beratbadan,
            'nilai_samapta' => $nilai_samapta + $nilai_bbi,
            'stakes'        => $bbi->stakes,
            'nilai_bbi'     => $bbi->nilai
        ]);

        return back()->with(['sukses' => 'Data Berhasil Disimpan']);
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
    public function update(Request $request)
    {
        $request->validate([
            'lari'          => 'required',
            'pushup'        => 'required',
            'situp'         => 'required',
            'shuttlerun'    => 'required',
            'tinggibadan'   => 'required',
            'beratbadan'    => 'required',
            'id_mahasiswa'  => 'required',
            'id_nilai_samapta'  => 'required'
        ]);

        $taruna = DB::table('tarunas')
                    ->where('id_mahasiswa', $request->id_mahasiswa)
                    ->value('jenis_kelamin');

        $nilai = DB::table('aturan_nilai_samaptas')
                    ->where('untuk', $taruna == 'L' ? 'Taruna' : 'Taruni')
                    ->get();

        
        $nilai_lari         = $nilai->where('jenis_samapta', 'Lari')->where('jumlah', $request->lari)->first();
        $nilai_pushup       = $nilai->where('jenis_samapta', 'Push-up')->where('jumlah', $request->pushup)->first();
        $nilai_situp        = $nilai->where('jenis_samapta', 'Sit-up')->where('jumlah', $request->situp)->first();
        $nilai_shuttlerun   = $nilai->where('jenis_samapta', 'Shuttle Run')->where('jumlah', $request->shuttlerun)->first();


        if(@$nilai_lari         == null)  return back()->with(['gagal' => 'nilai lari tidak ditemukan']);
        if(@$nilai_situp        == null)  return back()->with(['gagal' => 'nilai Sit Up tidak ditemukan']); 
        if(@$nilai_pushup       == null)  return back()->with(['gagal' => 'nilai Push Up tidak ditemukan']); 
        if(@$nilai_shuttlerun   == null)  return back()->with(['gagal' => 'nilai Shuttle Run tidak ditemukan']); 

        $nilai_samapta  = ($nilai_lari->nilai + (($nilai_pushup->nilai + $nilai_situp->nilai + $nilai_shuttlerun->nilai) / 3)) / 2;

        $nilai_samapta  = $nilai_samapta / 100 * 70;

        $bmi = $request->beratbadan / pow(($request->tinggibadan/100), 2);
        
        $bbi = DB::table('aturan_nilaibbis')
                ->where('untuk', $taruna == 'L' ? 'Taruna' : 'Taruni')
                ->where('bmi', '=', round($bmi))
                ->first();

        if(@$bbi == null)  return back()->with(['gagal' => 'nilai bbi tidak ditemukan']);        

        $nilai_bbi = $bbi->nilai / 100 * 30;

        $data_nilai = PenilaianSamapta::find($request->id_nilai_samapta);
        $data_nilai->update([
            'id_mahasiswa'  => $request->id_mahasiswa,
            'jarak_lari'    => $request->lari,
            'nilai_lari'    => $nilai_lari->nilai,
            'jumlah_push_up'=> $request->pushup,
            'nilai_push_up' => $nilai_pushup->nilai,
            'jumlah_sit_up' => $request->situp,
            'nilai_sit_up'  => $nilai_situp->nilai,
            'jumlah_shuttle_run'    => $request->shuttlerun,
            'nilai_shuttle_run'     => $nilai_shuttlerun->nilai,
            'tinggi_badan'  => $request->tinggibadan,
            'berat_badan'   => $request->beratbadan,
            'nilai_samapta' => $nilai_samapta + $nilai_bbi,
            'stakes'        => $bbi->stakes,
            'nilai_bbi'     => $bbi->nilai
        ]);

        return back()->with(['sukses' => 'Data Berhasil Disimpan']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = PenilaianSamapta::find($id);
        $data->delete();

        return back()->with(['sukses' => 'Data berhasil dihapus']);
    }
}