<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\PenilaianSoftSkill;
use Illuminate\Support\Facades\Validator;

class SoftskillController extends Controller
{
    public function detail($id){

        $data = DB::table('penilaian_soft_skills')
                    ->leftjoin('komponen_softskills', 'komponen_softskills.id_komponen_softskill', '=', 'penilaian_soft_skills.id_komponen_softskill')
                    ->leftjoin('semesters', 'semesters.id_semester', '=', 'penilaian_soft_skills.id_semester')
                    ->leftjoin('tarunas', 'tarunas.id_mahasiswa', '=', 'penilaian_soft_skills.id_mahasiswa')
                    ->where('semesters.is_semester_aktif', '1')
                    ->where('komponen_softskills.jenis_softskill', $id)
                    ->select(
                        'tarunas.nama_mahasiswa', 
                        'tarunas.nama_program_studi', 
                        'tarunas.jenis_kelamin', 
                        'tarunas.nim', 
                        'tarunas.foto',
                        'tarunas.id_mahasiswa',
                        'komponen_softskills.jenis_softskill',
                        DB::raw('count(keterangan_softskill) as jumlah_keterangan'),
                        DB::raw('sum(penilaian_soft_skills.nilai) as total_nilai')
                    )
                    ->groupBy('tarunas.id_mahasiswa');

                    if(request('cari')){
                        $data = $data->where('tarunas.nama_mahasiswa', 'like', '%'.request('cari').'%')->get();
                    }else{
                        $data = $data->get();
                    }
        
        return view('mobile.softskill', [
            'data'              => $data,
            'jenis_softskill'   => $id
        ]);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'id_mahasiswa'      => 'required', 
        ]);

        if($validator->fails()){

            $data = [
                'responCode'    => 0,
                'respon'        => $validator->errors()
            ];
        }else{

            // dd($request->all());

            for ($i=0; $i < count($request->nilai); $i++) { 
                
                PenilaianSoftSkill::updateOrCreate(
                [
                    'id_mahasiswa'          => $request->id_mahasiswa,
                    'id_semester'           => DB::table('semesters')->where('is_semester_aktif', '1')->value('id_semester'),
                    'id_komponen_softskill' => $request->id_komponen_softskill[$i],
                ],
                [
                    'id_mahasiswa'          => $request->id_mahasiswa, 
                    'id_komponen_softskill' => $request->id_komponen_softskill[$i],
                    'nilai'                 => $request->nilai[$i],
                    'id_semester'           => DB::table('semesters')->where('is_semester_aktif', '1')->value('id_semester')
                ]);
            }


            $data = [
                'responCode'    => 1,
                'respon'        => 'Data Sukses Ditambah'
            ];
        }

        return response()->json($data);
    }

    public function detailSoftskillTaruna($id_mahasiswa, $jenis_softskill){

        $data = DB::table('komponen_softskills')
                    ->leftjoin('penilaian_soft_skills', 'penilaian_soft_skills.id_komponen_softskill', '=', 'komponen_softskills.id_komponen_softskill')
                    ->leftjoin('semesters', 'semesters.id_semester', '=', 'penilaian_soft_skills.id_semester')
                    ->leftjoin('tarunas', 'tarunas.id_mahasiswa', '=', 'penilaian_soft_skills.id_mahasiswa')
                    ->where('semesters.is_semester_aktif', '1')
                    ->where('komponen_softskills.jenis_softskill', $jenis_softskill)
                    ->where('tarunas.id_mahasiswa', $id_mahasiswa)
                    ->select(
                        'tarunas.nama_mahasiswa', 
                        'tarunas.nama_program_studi', 
                        'tarunas.jenis_kelamin', 
                        'tarunas.nim', 
                        'tarunas.id_mahasiswa',
                        'komponen_softskills.jenis_softskill',
                        'komponen_softskills.keterangan_softskill',
                        'penilaian_soft_skills.*'
                    )
                    ->get();
                
                // dd(count($data));

        return view('mobile.detail-softskill', [
            'data'            => $data,
            'jenis_softskill' => $jenis_softskill,
            'id_mahasiswa'      => $id_mahasiswa
        ]);
    }

    public function nilai(){

        $data = DB::table('penilaian_soft_skills')
        ->leftjoin('komponen_softskills', 'komponen_softskills.id_komponen_softskill', '=', 'penilaian_soft_skills.id_komponen_softskill')
        ->leftjoin('semesters', 'semesters.id_semester', '=', 'penilaian_soft_skills.id_semester')
        ->leftjoin('tarunas', 'tarunas.id_mahasiswa', '=', 'penilaian_soft_skills.id_mahasiswa')
        ->where('semesters.is_semester_aktif', '1')
        ->select(
            'tarunas.nama_mahasiswa', 
            'tarunas.nama_program_studi', 
            'tarunas.jenis_kelamin', 
            'tarunas.nim', 
            'tarunas.foto',
            'tarunas.id_mahasiswa',
            'komponen_softskills.jenis_softskill',
            'semesters.nama_semester',
            DB::raw('count(keterangan_softskill) as jumlah_keterangan'),
            DB::raw('sum(penilaian_soft_skills.nilai) as total_nilai')
        )
        ->groupBy('komponen_softskills.jenis_softskill')
        ->groupBy('tarunas.id_mahasiswa')
        ->orderBy('tarunas.id_mahasiswa', 'ASC');

        //JIKA ID MAHASISWA DAN ID SEMESTER KOSONG
        if(!request('id_mahasiswa') && !request('id_semester') ){
            $data = $data->where('semesters.is_semester_aktif', '1')->get();

        //JIKA ID MAHASISWA SEMUANYA
        }elseif(request('id_mahasiswa') == 'all'){
            $data = $data->where('semesters.id_semester', request('id_semester'))->get();

        //JIKA LAINNYA
        }else{
            
            $data = $data->where('semesters.id_semester', request('id_semester'))
                    ->where('tarunas.id_mahasiswa', request('id_mahasiswa'))->get();
        }

        return view('mobile.nilai-softskill',[
            'data'  => $data
        ]);
    }
}
