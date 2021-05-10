<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\CatatanPenghargaan;
use auth;

class CatatanPenghargaanController extends Controller
{
    public function index(Request $request){
        if(!$request->input('id_mahasiswa')){
            $data = [];
            $taruna = null;
        }else{
            $taruna = DB::table('tarunas')->where('id_mahasiswa', $request->input('id_mahasiswa'))->first();
            $data = DB::table('catatan_penghargaans')
            ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'catatan_penghargaans.id_mahasiswa')
            ->join('penghargaans', 'penghargaans.id_penghargaan', '=', 'catatan_penghargaans.id_penghargaan')
            ->where('catatan_penghargaans.id_mahasiswa', $request->input('id_mahasiswa'))
            ->select(
                'tarunas.nama_mahasiswa',
                'tarunas.nim',
                'catatan_penghargaans.id_catatan_penghargaan',
                'penghargaans.penghargaan',
                'penghargaans.bidang_penghargaan',
                'penghargaans.poin_penghargaan',
                'catatan_penghargaans.created_at',
                'tarunas.id_mahasiswa',
                'catatan_penghargaans.tgl_penghargaan',
                'catatan_penghargaans.sk_penghargaan',
                'penghargaans.id_penghargaan'
            )
            ->get();
        }

        $pengharagaan = DB::table('penghargaans')->get();

        return view('catatanpenghargaan.index')
                ->with('data', $data)
                ->with('penghargaan', $pengharagaan)
                ->with('taruna', $taruna);
    }

    public function tarunajson(Request $request){
        if ($request->has('q')) {
    		$cari = $request->q;
            if($cari != ''){
                if(auth::user()->role == 'admin'){
                    $data = DB::table('tarunas')
                    ->select('id_mahasiswa', 'nama_mahasiswa')->where('nama_mahasiswa', 'LIKE', '%'.$cari.'%')
                    ->get();
                }else{
                    $data = DB::table('asuhans')
                    ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'asuhans.id_mahasiswa')
                    ->join('users', 'users.id', '=', 'asuhans.id_pengasuh')
                    ->where('asuhans.id_pengasuh', Auth::id())
                    ->where('nama_mahasiswa', 'LIKE', '%'.$cari.'%')            
                    ->get();
                }
                return response()->json($data);
            }
        }
    }

    public function store(Request $request){
        $request->validate([
            'id_mahasiswa'      => 'required',
            'id_penghargaan'    => 'required',
            'tgl_penghargaan'   => 'required',
            'sk_penghargaan'    => 'required'
        ]);

        $semester       = DB::table('semesters')->where('is_semester_aktif', 1)->first();

        CatatanPenghargaan::create([
            'id_mahasiswa'      => $request->input('id_mahasiswa'),
            'id_penghargaan'    => $request->input('id_penghargaan'),
            'tgl_penghargaan'   => $request->input('tgl_penghargaan'),
            'sk_penghargaan'    => $request->input('sk_penghargaan'),
            'id_semester'       => $semester->id_semester
        ]);

        return back()->with(['sukses' => 'Data Berhasil Disimpan!']);
    }

    public function update(Request $request){
        $request->validate([
            'id_mahasiswa'  => 'required',
            'id_penghargaan'    => 'required',
            'tgl_penghargaan'   => 'required',
            'sk_penghargaan'    => 'required',
            'id_catatan_penghargaan'    => 'required'
        ]);

        $catatan_penghargaan = CatatanPenghargaan::find($request->input('id_catatan_penghargaan'));
        $catatan_penghargaan->update([
            'id_mahasiswa'      => $request->input('id_mahasiswa'),
            'id_penghargaan'    => $request->input('id_penghargaan'),
            'tgl_penghargaan'   => $request->input('tgl_penghargaan'),
            'sk_penghargaan'    => $request->input('sk_penghargaan'),
            'id_catatan_penghargaan'    => $request->input('id_catatan_penghargaan')
        ]);

        return back()->with(['sukses' => 'Data Berhasil Diupdate!']);
    }

    public function destroy($id){
        $data = CatatanPenghargaan::find($id);
        $data->delete();

        return back()->with(['sukses' => 'Data Berhasil Dihapus!']);
    }
}
