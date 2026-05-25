<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TestimoniController extends Controller
{
    public function index(){

        $data = DB::table('testimonis')
                ->leftjoin('tarunas', 'tarunas.id_mahasiswa', '=', 'testimonis.id_mahasiswa')
                ->select(
                    'testimonis.*',
                    'tarunas.nama_mahasiswa',
                    'tarunas.nim'
                )
                ->get();

        return view('testimoni.index', [
            'data'  => $data
        ]);
    }

    public function destroy($id){

        $data   = DB::table('testimonis')->where('id', $id);
        $data->delete();

        return back()->with(['sukses' => 'Data Berhasil Dihapus']);
    }

    public function ubahStatus($id){

            DB::table('testimonis')
            ->where('id', $id)
            ->update([
                'status' => DB::raw("
                    CASE
                        WHEN status IS NULL
                            OR status = ''
                            OR status = 'Tidak Aktif'
                        THEN 'Aktif'
                        ELSE 'Tidak Aktif'
                    END
                ")
            ]);

        return back()->with('success', 'Status berhasil diubah');
    }
}
