<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CatatanSakit;
use DB;

class CatatanSakitController extends Controller
{
    public function index(Request $request){
        if(!$request->input('id_mahasiswa')){
            $data = [];
            $taruna = null;
        }else{
            $taruna = DB::table('tarunas')->where('id_mahasiswa', $request->input('id_mahasiswa'))->first();
            $data = DB::table('catatan_sakits')
            ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'catatan_sakits.id_mahasiswa')
            ->where('catatan_sakits.id_mahasiswa', $request->input('id_mahasiswa'))
            ->select(
                'tarunas.nama_mahasiswa',
                'tarunas.nim',
                'tarunas.id_mahasiswa',
                'catatan_sakits.id_catatan_sakit',
                'catatan_sakits.tgl_sakit',
                'catatan_sakits.keterangan_sakit',
                'catatan_sakits.surat_sakit'
            )
            ->get();
        }

        return view('catatansakit.index')
                ->with('data', $data)
                ->with('taruna', $taruna);
    }

    public function store(Request $request){
        $request->validate([
            'tgl_sakit' => 'required',
            'keterangan_sakit'  => 'required',
            'surat_sakit'   => 'required|mimetypes:image/jpeg,image/png|max:2048',
            'id_mahasiswa'  => 'required',
        ]);

        $file           = $request->file('surat_sakit');
        $nama_file      = $file->getClientOriginalName();
        $file->move('surat_sakit', $nama_file);

        CatatanSakit::create([
            'tgl_sakit' => $request->input('tgl_sakit'),
            'keterangan_sakit'  => $request->input('keterangan_sakit'),
            'surat_sakit'   => $nama_file,
            'id_mahasiswa'  => $request->input('id_mahasiswa')
        ]);

        return back()->with(['sukses' => 'Data Berhasil disimpan!']);
    }

    public function update(Request $request){
        $request->validate([
            'tgl_sakit' => 'required',
            'keterangan_sakit'  => 'mimetypes:image/jpeg,image/png|max:2048',
            'id_mahasiswa'  => 'required',
            'id_catatan_sakit'  => 'required'
        ]);

        $catatansakit = CatatanSakit::find($request->input('id_catatan_sakit'));
        if(empty($request->file('surat_sakit'))){
            $nama_file = $catatansakit->surat_sakit;
        }else{
            $file           = $request->file('surat_sakit');
            $nama_file      = $file->getClientOriginalName();
            $file->move('surat_sakit', $nama_file);
        }

        $catatansakit->update([
            'tgl_sakit'         => $request->input('tgl_sakit'),
            'keterangan_sakit'  => $request->input('keterangan_sakit'),
            'surat_sakit'       => $nama_file,
            'id_mahasiswa'      => $request->input('id_mahasiswa')
        ]);

        return back()->with(['sukses' => 'Update Data Berhasil!']);
    }

    public function destroy($id){
        $data = CatatanSakit::find($id);
        $data->delete();

        return back()->with(['sukses' => 'Data Berhasil Dihapus!']);
    }

}
