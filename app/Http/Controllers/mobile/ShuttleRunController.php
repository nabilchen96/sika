<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\PenilaianSamapta;
use Illuminate\Support\Facades\Validator;

class ShuttleRunController extends Controller
{
    public function index(){
    
        $taruna = DB::table('tarunas')->get();

        $data = DB::table('penilaian_samaptas')
                    ->join('semesters', 'semesters.id_semester', '=', 'penilaian_samaptas.id_semester')
                    ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'penilaian_samaptas.id_mahasiswa')
                    ->where('semesters.is_semester_aktif', '1')
                    ->whereNotNull('penilaian_samaptas.jumlah_shuttle_run')
                    ->whereNotNull('penilaian_samaptas.nilai_shuttle_run');

        if(request('cari')){
            $data = $data->where('tarunas.nama_mahasiswa', 'like', '%'.request('cari').'%')->get();
        }else{
            $data = $data->get();
        }

        return view('mobile.shuttlerun', [
            'data'  => $data
        ]);

    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'id_mahasiswa'  => 'required', 
            'jumlah_shuttle_run'    => 'required'
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

                $nilai_shuttlerun   = $request->jumlah_shuttle_run <= 15.90 ?
                                    100 : ( $request->jumlah_shuttle_run > 25.80 ?
                                    0 : $nilai->where('jenis_samapta', 'Shuttle Run')->where('jumlah', $request->jumlah_shuttle_run)->first());
                
            }elseif($taruna == 'P'){

                $nilai_shuttlerun   = $request->jumlah_shuttle_run <= 17.20 ?
                                    100 : ( $request->jumlah_shuttle_run > 27.10 ?
                                    0 : $nilai->where('jenis_samapta', 'Shuttle Run')->where('jumlah', $request->jumlah_shuttle_run)->first());
            }

            //simpan atau update data
            $data = PenilaianSamapta::updateOrCreate(
                [
                    'id_mahasiswa'  => $request->id_mahasiswa, 
                    'id_semester'   => $semester 
                ], 
                [
                    'id_mahasiswa'  => $request->id_mahasiswa, 
                    'id_semester'   => $semester,
                    'jumlah_shuttle_run'    => $request->jumlah_shuttle_run, 
                    'nilai_shuttle_run'     => $nilai_shuttlerun->nilai ?? $nilai_shuttlerun
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
