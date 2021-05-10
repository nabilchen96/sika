<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Perizinan;
use DB;

class CatatanPerizinanController extends Controller
{
    public function index(Request $request){
        if(!$request->input('id_mahasiswa')){
            $data = [];
            $taruna = null;
        }else{
            $taruna = DB::table('tarunas')->where('id_mahasiswa', $request->input('id_mahasiswa'))->first();
            $data = DB::table('perizinans')
            ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'perizinans.id_mahasiswa')
            ->where('perizinans.id_mahasiswa', $request->input('id_mahasiswa'))
            ->select(
                'tarunas.nama_mahasiswa',
                'tarunas.nim',
                'tarunas.id_mahasiswa',
                'perizinans.id_catatan_perizinan',
                'perizinans.tgl_izin_keluar',
                'perizinans.tgl_izin_kembali',
                'perizinans.keterangan_izin'
            )
            ->get();
        }

        return view('catatanperizinan.index')
                ->with('data', $data)
                ->with('taruna', $taruna);
    }

    public function store(Request $request){
        $request->validate([
            'id_mahasiswa'      => 'required',
            'tgl_izin_keluar'   => 'required',
            'keterangan_izin'   => 'required'
        ]);

        $semester = DB::table('semesters')->where('is_semester_aktif', 1)->first();
        Perizinan::create([
            'id_mahasiswa'      => $request->input('id_mahasiswa'),
            'tgl_izin_keluar'   => $request->input('tgl_izin_keluar'),
            'keterangan_izin'   => $request->input('keterangan_izin'),
            'id_semester'       => $semester->id_semester
        ]);
        return back()->with(['sukses' => 'Data Berhasil Disimpan']);
    }

    public function update(Request $request){
        $request->validate([
            'id_mahasiswa'          => 'required',
            'tgl_izin_keluar'       => 'required',
            'keterangan_izin'       => 'required',
            'id_catatan_perizinan'  => 'required'
        ]);

        $semester = DB::table('semesters')->where('is_semester_aktif', 1)->first();
        $perizinan = Perizinan::find($request->input('id_catatan_perizinan'));
        $perizinan->update([
            'id_mahasiswa'      => $request->input('id_mahasiswa'),
            'tgl_izin_keluar'   => $request->input('tgl_izin_keluar'),
            'tgl_izin_kembali'  => $request->input('tgl_izin_kembali'),
            'keterangan_izin'   => $request->input('keterangan_izin'),
            'id_semester'       => $semester->id_semester
        ]);
        return back()->with(['sukses' => 'Data Berhasil Diupdate!']);
    }

    public function destroy($id){
        $data = Perizinan::find($id);
        $data->delete();

        return back()->with(['sukses' => 'Data Berhasil Dihapus!']);
    }
}
