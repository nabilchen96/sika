<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Semester;

class SemesterController extends Controller
{
    public function index(){
        $semester = Semester::where('a_periode_aktif', "1")->get();
        return view('semester.index')->with('semester', $semester);
    }

    public function updatesemesterserver(){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost/project/siakadpoltekbang-backup/public/api/semester");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, 
         array('Accept: application/json', 'Authorization: Bearer 1|KoFesST4tV889DCcWoCBLmcm0YJuXqKFLIEQnggv')
        );
      
        $result = curl_exec($ch);
        $data   = json_decode($result, true);

        // dd($data);

        foreach($data as $item){
            //jika data ada maka update
            $cek_semester   = Semester::where('id_semester_siakad', $item['id_semester'])->count();
            $update_semester= Semester::where('id_semester_siakad', $item['id_semester'])->first();

            if($cek_semester > 0){
                $update_semester->update([
                    'id_semester_siakad'    => $item['id_semester'],
                    'tahun_ajaran'          => $item['id_tahun_ajaran'],
                    'nama_semester'         => $item['nama_semester'],
                    'a_periode_aktif'       => $item['a_periode_aktif'],
                    'tanggal_mulai'         => $item['tanggal_mulai'],
                    'tanggal_selesai'       => $item['tanggal_selesai'],
                    'is_semester_aktif'     => $item['is_semester_aktif'],
                ]);
            }else{
                Semester::create([
                    'id_semester_siakad'    => $item['id_semester'],
                    'tahun_ajaran'          => $item['id_tahun_ajaran'],
                    'nama_semester'         => $item['nama_semester'],
                    'a_periode_aktif'       => $item['a_periode_aktif'],
                    'tanggal_mulai'         => $item['tanggal_mulai'],
                    'tanggal_selesai'       => $item['tanggal_selesai'],
                    'is_semester_aktif'     => $item['is_semester_aktif'],
                ]);
            }
        }

        return redirect('semester')->with(['sukses' => 'Data Berhasil Diupdate']);
    }
}
