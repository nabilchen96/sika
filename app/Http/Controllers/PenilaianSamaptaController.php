<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use auth;
use App\PenilaianSamapta;
use App\AturanNilaibbi;
use App\Exports\NilaiSamaptaExport;
use Maatwebsite\Excel\Facades\Excel;

class PenilaianSamaptaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(auth::user()->role == 'admin'){

            $taruna = DB::table('tarunas')->get();

            $data = DB::table('penilaian_samaptas')
                        ->join('semesters', 'semesters.id_semester', '=', 'penilaian_samaptas.id_semester')
                        ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'penilaian_samaptas.id_mahasiswa')
                        ->where('semesters.id_semester', $request->id_semester)
                        ->get();

        }elseif(auth::user()->role == 'taruna'){
            $taruna = [];
            $data = DB::table('penilaian_samaptas')
                        ->join('semesters', 'semesters.id_semester', '=', 'penilaian_samaptas.id_semester')
                        ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'penilaian_samaptas.id_mahasiswa')
                        ->where('semesters.id_semester', $request->id_semester)
                        ->where('tarunas.nim', auth::user()->nip)
                        ->get();

        }else{

            $kordinator = DB::table('kordinator_pengasuhs')->where('id', auth::user()->id)->first();

            if($kordinator){

                $grup_kordinasi = DB::table('grup_kordinasi_pengasuhs')->where('id_kordinator_pengasuh', $kordinator->id_kordinator_pengasuh)->get();

                $data = DB::table('penilaian_samaptas')
                            ->join('semesters', 'semesters.id_semester', '=', 'penilaian_samaptas.id_semester')
                            ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'penilaian_samaptas.id_mahasiswa')
                            ->join('asuhans', 'asuhans.id_mahasiswa', '=', 'tarunas.id_mahasiswa')
                            ->join('users', 'users.id', '=', 'asuhans.id_pengasuh')
                            ->where('semesters.id_semester', $request->id_semester)
                            ->where(function($q) use ($grup_kordinasi) {
                                foreach($grup_kordinasi  as $k) {
                                    $q->orWhere('asuhans.id_pengasuh', $k->id);
                                }
                            })           
                            ->get();

                $taruna = DB::table('asuhans')
                            ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'asuhans.id_mahasiswa')
                            ->join('users', 'users.id', '=', 'asuhans.id_pengasuh')
                            ->where(function($q) use ($grup_kordinasi) {
                                foreach($grup_kordinasi  as $k) {
                                    $q->orWhere('asuhans.id_pengasuh', $k->id);
                                }
                            })                       
                            ->get();
            }else{
                $data = DB::table('penilaian_samaptas')
                            ->join('semesters', 'semesters.id_semester', '=', 'penilaian_samaptas.id_semester')
                            ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'penilaian_samaptas.id_mahasiswa')
                            ->join('asuhans', 'asuhans.id_mahasiswa', '=', 'tarunas.id_mahasiswa')
                            ->join('users', 'users.id', '=', 'asuhans.id_pengasuh')
                            ->where('semesters.id_semester', $request->id_semester)
                            ->where('asuhans.id_pengasuh', Auth::id())
                            ->get();

                $taruna = DB::table('asuhans')
                            ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'asuhans.id_mahasiswa')
                            ->join('users', 'users.id', '=', 'asuhans.id_pengasuh')
                            ->where('asuhans.id_pengasuh', Auth::id())            
                            ->get();
            }            
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

        $cekdata = DB::table('penilaian_samaptas')
                        ->join('semesters', 'semesters.id_semester', '=', 'penilaian_samaptas.id_semester')
                        ->where('semesters.is_semester_aktif', 1)
                        ->where('penilaian_samaptas.id_mahasiswa', $request->id_mahasiswa)
                        ->first();

        // dd($cekdata);

        if(@$cekdata){
            return back()->with(['gagal' => 'Gagal insert data karena data sudah ada pada semester ini']);
        }

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


        if(@$nilai_lari         == null)  return back()->with(['gagal' => 'nilai lari tidak ditemukan, silahkan lihat aturan nilai lari di pedoman']);
        if(@$nilai_situp        == null)  return back()->with(['gagal' => 'nilai Sit Up tidak ditemukan, silahkan lihat aturan nilai situp di pedoman']); 
        if(@$nilai_pushup       == null)  return back()->with(['gagal' => 'nilai Push Up tidak ditemukan, silahkan lihat aturan nilai pushup di pedoman']); 
        if(@$nilai_shuttlerun   == null)  return back()->with(['gagal' => 'nilai Shuttle Run tidak ditemukan, silahkan lihat aturan nilai shuttle run di pedoman']); 

        $nilai_samapta  = ($nilai_lari->nilai + (($nilai_pushup->nilai + $nilai_situp->nilai + $nilai_shuttlerun->nilai) / 3)) / 2;

        $nilai_samapta  = $nilai_samapta / 100 * 70;

        $bmi = $request->beratbadan / pow(($request->tinggibadan/100), 2);

        // dd(round($bmi, 2));
        
        $bbi = AturanNilaibbi::where('untuk', 'Taruna')
                ->where('bmi', '=', round($bmi, 2))
                ->first();

                // dd($bbi->nilai);

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
            'nilai_samapta' => round($nilai_samapta + $nilai_bbi, 2),
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

    public function export($id_semester){
    
        return Excel::download(new NilaiSamaptaExport($id_semester), 'Nilai Samapta Taruna.xlsx');
    }
}
