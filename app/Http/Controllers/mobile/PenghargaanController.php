<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\CatatanPenghargaan;

class PenghargaanController extends Controller
{
    public function index(){
        $data   = DB::table('tarunas')
                    ->join('catatan_penghargaans', 'catatan_penghargaans.id_mahasiswa', '=', 'tarunas.id_mahasiswa')
                    ->join('penghargaans', 'penghargaans.id_penghargaan', '=', 'catatan_penghargaans.id_penghargaan')
                    ->join('semesters', 'semesters.id_semester', '=', 'catatan_penghargaans.id_semester')
                    ->where('semesters.is_semester_aktif', '1')
                    ->select(
                        'tarunas.nama_mahasiswa', 
                        'tarunas.nama_program_studi', 
                        'tarunas.jenis_kelamin',
                        'tarunas.nim', 
                        'tarunas.id_mahasiswa',
                        'catatan_penghargaans.tgl_penghargaan',
                        'penghargaans.penghargaan', 
                        'penghargaans.poin_penghargaan', 
                        'penghargaans.bidang_penghargaan'
                    );

        if(request('cari')){
            $data = $data->where('tarunas.nama_mahasiswa', 'like', '%'.request('cari').'%')->get();
        }else{
            $data = $data->get();
        }
        
        return view('mobile.penghargaan', [
            'data'  => $data
        ]);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'id_mahasiswa'      => 'required', 
            'tgl_penghargaan'   => 'required',
            'id_penghargaan'    => 'required'
        ]);

        if($validator->fails()){

            $data = [
                'responCode'    => 0,
                'respon'        => $validator->errors()
            ];
        }else{

            CatatanPenghargaan::create([
                'id_mahasiswa'      => $request->id_mahasiswa, 
                'id_penghargaan'    => $request->id_penghargaan, 
                'tgl_penghargaan'   => $request->tgl_penghargaan, 
                'sk_penghargaan'    => $request->sk_penghargaan, 
                'id_semester'       => DB::table('semesters')->where('is_semester_aktif', '1')->value('id_semester')
            ]);

            $data = [
                'responCode'    => 1,
                'respon'        => 'Data Sukses Ditambah'
            ];
        }

        return response()->json($data);
    }
}
