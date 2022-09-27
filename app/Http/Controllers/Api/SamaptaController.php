<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\PenilaianSamapta;

class SamaptaController extends Controller
{
    public function store(Request $request){

         //cek semester taruna
         $semester    = DB::table('semesters')->where('is_semester_aktif', '1')->value('id_semester');

         //cek jenis kelamin taruna
         $taruna     = DB::table('tarunas')->where('nim', $request->no_reg)->first();

         if($taruna == NULL){
            $data = [
                'responCode'    => 0,
                'respon'        => 'Taruna tidak ditemukan'
            ];
         }else{

             //cek nilai lari sesuai jarak lari
             $nilai      = DB::table('aturan_nilai_samaptas')
                             ->where('untuk', $taruna->jenis_kelamin == 'L' ? 'Taruna' : 'Taruni')->get();
    
             if($taruna->jenis_kelamin == 'L'){
    
                 $nilai_lari = $request->jarak_lari >= 3507.00 ? 
                                100 : ($request->jarak_lari <= 1607.00 ? 
                                0 : $nilai->where('jenis_samapta', 'Lari')->where('jumlah', $request->jarak_lari)->first());
    
                $nilai_pushup = $request->jumlah_push_up >= 43.00 ?
                                100 : ( $request->jumlah_push_up <= 16.00 ? 
                                0 : $nilai->where('jenis_samapta', 'Push-up')->where('jumlah', $request->jumlah_push_up)->first());
    
                $nilai_situp  = $request->jumlah_sit_up >= 41.00 ? 
                                100 : ( $request->jumlah_sit_up <= 14.00 ? 
                                0 : $nilai->where('jenis_samapta', 'Sit-up')->where('jumlah', $request->jumlah_sit_up)->first());
    
                $nilai_shuttlerun   = $request->jumlah_shuttle_run <= 15.90 ?
                                    100 : ( $request->jumlah_shuttle_run > 25.80 ?
                                    0 : $nilai->where('jenis_samapta', 'Shuttle Run')->where('jumlah', $request->jumlah_shuttle_run)->first());
    
             }elseif($taruna->jenis_kelamin == 'P'){
    
                $nilai_lari = $request->jarak_lari >= 2630.00 ? 
                                100 : ($request->jarak_lari <= 1419.00 ? 
                                0 : $nilai->where('jenis_samapta', 'Lari')->where('jumlah', $request->jarak_lari)->first());
    
                $nilai_pushup   = $request->jumlah_push_up >= 28.00 ?
                                100 : ( $request->jumlah_push_up <= 7.00 ? 
                                0 : $nilai->where('jenis_samapta', 'Push-up')->where('jumlah', $request->jumlah_push_up)->first());
    
                $nilai_situp    = $request->jumlah_sit_up >= 42.00 ? 
                                100 : ( $request->jumlah_sit_up <= 14.00 ? 
                                0 : $nilai->where('jenis_samapta', 'Sit-up')->where('jumlah', $request->jumlah_sit_up)->first());
    
                 $nilai_shuttlerun  = $request->jumlah_shuttle_run <= 17.20 ?
                                    100 : ( $request->jumlah_shuttle_run > 27.10 ?
                                    0 : $nilai->where('jenis_samapta', 'Shuttle Run')->where('jumlah', $request->jumlah_shuttle_run)->first());
             }
    
             //cek samapta
             $samapta = PenilaianSamapta::where('id_semester', $semester)
                         ->where('id_mahasiswa', $request->id_mahasiswa)
                         ->first();
    
             //hitung nilai sampata
             $samapta_a      = $nilai_lari->nilai ?? $nilai_lari;
             $samapta_b      = (($samapta->nilai_push_up ?? 0) + ($samapta->nilai_sit_up ?? 0) + ($samapta->nilai_shuttle_run ?? 0)) / 3;
    
             //make 70%
             $nilai_samapta  = ($samapta_a + $samapta_b) / 2;
             $nilai_samapta  = $nilai_samapta / 100 * 70;
    
             //make 30%
             $nilai_bbi      = @$samapta->nilai_bbi ? ($samapta->nilai_bbi / 100 * 30) : 0;
    
             //simpan atau update data
             $data = PenilaianSamapta::updateOrCreate(
                 [
                     'id_mahasiswa'  => $taruna->id_mahasiswa, 
                     'id_semester'   => $semester 
                 ], 
                 [
                    'id_mahasiswa'  => $taruna->id_mahasiswa, 
                    'id_semester'   => $semester,
                    'jarak_lari'    => $request->jarak_lari, 
                    'nilai_lari'    => $nilai_lari->nilai ?? $nilai_lari, 
    
                    'jumlah_push_up'=> $request->jumlah_push_up, 
                    'nilai_push_up' => $nilai_pushup->nilai ?? $nilai_pushup,
    
                    'jumlah_sit_up'=> $request->jumlah_sit_up, 
                    'nilai_sit_up' => $nilai_situp->nilai ?? $nilai_situp, 
    
                    'jumlah_shuttle_run'   => $request->jumlah_shuttle_run, 
                    'nilai_shuttle_run'    => $nilai_shuttlerun->nilai ?? $nilai_shuttlerun,
    
                    'nilai_samapta' => round($nilai_samapta + $nilai_bbi, 2)
                 ]
             );
    
             //JIKA SEMUA PENILAIAN PENUH
             $data = [
                 'responCode'    => 1,
                 'respon'        => 'Data Sukses Ditambah'
             ];
         }


        return response()->json($data);
    }
}
