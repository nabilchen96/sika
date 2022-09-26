<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\PenilaianSamapta;
use Illuminate\Support\Facades\Validator;

class LariController extends Controller
{
    public function index(){

        $taruna = DB::table('tarunas')->get();

        $data = DB::table('penilaian_samaptas')
                    ->join('semesters', 'semesters.id_semester', '=', 'penilaian_samaptas.id_semester')
                    ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'penilaian_samaptas.id_mahasiswa')
                    ->where('semesters.is_semester_aktif', '1')
                    ->whereNotNull('penilaian_samaptas.jarak_lari')
                    ->whereNotNull('penilaian_samaptas.nilai_lari');

        if(request('cari')){
            $data = $data->where('tarunas.nama_mahasiswa', 'like', '%'.request('cari').'%')->get();
        }else{
            $data = $data->get();
        }

        return view('mobile.lari', [
            'data'  => $data
        ]);
    }

    public function store(Request $request){


        $validator = Validator::make($request->all(), [
            'id_mahasiswa'  => 'required', 
            'jarak_lari'    => 'required'
        ]);

        if ($validator->fails()) {

            $data = [
                'responCode'    => 0,
                'respon'        => $validator->errors()
            ];

        } else {

            //cek semester taruna
            $semester    = DB::table('semesters')->where('is_semester_aktif', '1')->value('id_semester');

            //cek jenis kelamin taruna
            $taruna     = DB::table('tarunas')->where('id_mahasiswa', $request->id_mahasiswa)->value('jenis_kelamin');

            //cek nilai lari sesuai jarak lari
            $nilai      = DB::table('aturan_nilai_samaptas')
                            ->where('untuk', $taruna == 'L' ? 'Taruna' : 'Taruni')->get();

            if($taruna == 'L'){

                $nilai_lari = $request->jarak_lari >= 3507.00 ? 
                                100 : ($request->jarak_lari <= 1607.00 ? 
                                0 : $nilai->where('jenis_samapta', 'Lari')->where('jumlah', $request->jarak_lari)->first());
            }elseif($taruna == 'P'){

                $nilai_lari = $request->jarak_lari >= 2630.00 ? 
                                100 : ($request->jarak_lari <= 1419.00 ? 
                                0 : $nilai->where('jenis_samapta', 'Lari')->where('jumlah', $request->jarak_lari)->first());
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
                    'id_mahasiswa'  => $request->id_mahasiswa, 
                    'id_semester'   => $semester 
                ], 
                [
                    'id_mahasiswa'  => $request->id_mahasiswa, 
                    'id_semester'   => $semester,
                    'jarak_lari'    => $request->jarak_lari, 
                    'nilai_lari'    => $nilai_lari->nilai ?? $nilai_lari, 
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
