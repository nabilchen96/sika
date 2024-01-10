<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Validator;
use App\LamaranKerja;

class LamaranKerjaController extends Controller
{
    public function index(){

        $data = DB::table('lamaran_kerjas as lk')
                ->leftjoin('beritas as b', 'b.id_berita', '=', 'lk.id_berita')
                ->select(
                    'lk.*', 
                    'b.judul_berita',
                )
                ->get();

                // dd($data);

        return view('lamaran_kerja.index', [
            'data'  => $data
        ]);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'upload_lamaran'            => 'required|mimes:pdf|max:1024',
        ]);

        if($validator->fails()){
            
            $data = [
                'responCode'    => 0,
                'respon'        => $validator->errors()
            ];
            
        }else{
            
            $upload_lamaran = time().'.'.$request->upload_lamaran->extension();  
            $request->upload_lamaran->move(public_path('lamaran'), $upload_lamaran);
    
            LamaranKerja::create([
    
                'nama_pelamar'  => $request->nama_pelamar, 
                'jenis_kelamin' => $request->jenis_kelamin, 
                'nomor_telpon'  => $request->nomor_telpon,
                'email'         => $request->email,
                'alamat'        => $request->alamat, 
                'pengalaman'    => $request->pengalaman, 
                'upload_lamaran'=> $upload_lamaran,
                'id_berita'     => $request->id_berita
            ]);
    
            $data = [
                'responCode'    => 1,
                'respon'        => 'Data Sukses Ditambah'
            ];
        }
        

        return response()->json($data);

    }
}
