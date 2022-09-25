<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\PenilaianSamapta;
use App\AturanNilaibbi;
use Illuminate\Support\Facades\Validator;

class BBIController extends Controller
{
    public function index(){

        $taruna = DB::table('tarunas')->get();

        $data = DB::table('penilaian_samaptas')
                    ->join('semesters', 'semesters.id_semester', '=', 'penilaian_samaptas.id_semester')
                    ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'penilaian_samaptas.id_mahasiswa')
                    ->where('semesters.is_semester_aktif', '1')
                    ->whereNotNull('penilaian_samaptas.tinggi_badan')
                    ->whereNotNull('penilaian_samaptas.berat_badan');

        if(request('cari')){
            $data = $data->where('tarunas.nama_mahasiswa', 'like', '%'.request('cari').'%')->get();
        }else{
            $data = $data->get();
        }

        return view('mobile.bbi', [
            'data'  => $data
        ]);
    }

    public function store(Request $request){

        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'id_mahasiswa'  => 'required', 
            'tinggi_badan'  => 'required',
            'berat_badan'   => 'required'
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

            //NILAI BMI
            $bmi        = $request->berat_badan / pow(($request->tinggi_badan / 100), 2);

            //NILAI BBI
            $bbi        = AturanNilaibbi::where('untuk', $taruna == 'L' ? 'Taruna' : 'Taruni')
                            ->where('bmi', 'like', round($bmi, 2))
                            ->first();

            // dd($bbi->nilai, round($bmi, 2));

            // $nilai_bbi  = $bbi->nilai / 100 * 30;

            //simpan atau update data
            $data = PenilaianSamapta::updateOrCreate(
                [
                    'id_mahasiswa'  => $request->id_mahasiswa, 
                    'id_semester'   => $semester 
                ], 
                [
                    'id_mahasiswa'  => $request->id_mahasiswa, 
                    'id_semester'   => $semester,
                    'tinggi_badan'  => $request->tinggi_badan, 
                    'berat_badan'   => $request->berat_badan,
                    'stakes'        => $bbi->stakes,
                    'nilai_bbi'     => $bbi->nilai
                ]
            );

            $data = [
                'responCode'    => 1,
                'respon'        => 'Data Sukses Ditambah'
            ];
        }

        return response()->json($data);
    }
}
