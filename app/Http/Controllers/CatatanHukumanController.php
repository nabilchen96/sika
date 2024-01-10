<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\CatatanHukuman;
use auth;
use App\Exports\CatatanHukumanExport;
use Maatwebsite\Excel\Facades\Excel;

class CatatanHukumanController extends Controller
{
    public function index(){

            if(auth::user()->role == 'taruna'){
                $taruna = DB::table('tarunas')->where('nim', auth::user()->nip)->value('id_mahasiswa');

                $data = DB::table('catatan_hukumen')
                ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'catatan_hukumen.id_mahasiswa')
                ->where('catatan_hukumen.id_mahasiswa', $taruna)
                ->select(
                    'tarunas.nama_mahasiswa',
                    'tarunas.nim',
                    'catatan_hukumen.id_catatan_hukuman',
                    'catatan_hukumen.created_at',
                    'catatan_hukumen.keterangan',
                    'catatan_hukumen.is_dikerjakan'
                )
                ->orderBy('catatan_hukumen.is_dikerjakan', 'ASC')
                ->get();
            }elseif(auth::user()->role == 'pengasuh'){

                $kordinator = DB::table('kordinator_pengasuhs')->where('id', auth::user()->id)->first();

                if($kordinator){
                    //jika dia adalah kordinator pengasuh maka tampilkan semua taruna yang diasuh oleh semua pengasuh di bawahnya
                    $grup_kordinasi = DB::table('grup_kordinasi_pengasuhs')->where('id_kordinator_pengasuh', $kordinator->id_kordinator_pengasuh)->get();

                    $data = DB::table('catatan_hukumen')
                            ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'catatan_hukumen.id_mahasiswa')
                            ->join('asuhans', 'asuhans.id_mahasiswa', '=', 'tarunas.id_mahasiswa')
                            ->join('users', 'users.id', '=', 'asuhans.id_pengasuh')
                            ->select(
                                'tarunas.nama_mahasiswa',
                                'tarunas.nim',
                                'catatan_hukumen.id_catatan_hukuman',
                                'catatan_hukumen.created_at',
                                'catatan_hukumen.keterangan',
                                'catatan_hukumen.is_dikerjakan'
                            )
                            ->where(function($q) use ($grup_kordinasi) {
                                foreach($grup_kordinasi  as $k) {
                                    $q->orWhere('asuhans.id_pengasuh', $k->id);
                                }
                            })
                            ->orderBy('catatan_hukumen.is_dikerjakan', 'ASC')
                            ->get();
                }else{

                    $data = DB::table('catatan_hukumen')
                                ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'catatan_hukumen.id_mahasiswa')
                                ->join('asuhans', 'asuhans.id_mahasiswa', '=', 'tarunas.id_mahasiswa')
                                ->select(
                                    'tarunas.nama_mahasiswa',
                                    'tarunas.nim',
                                    'catatan_hukumen.id_catatan_hukuman',
                                    'catatan_hukumen.created_at',
                                    'catatan_hukumen.keterangan',
                                    'catatan_hukumen.is_dikerjakan'
                                )
                                ->where('asuhans.id_pengasuh', Auth::id())
                                ->orderBy('catatan_hukumen.is_dikerjakan', 'ASC')
                                ->get();

                }

            }else{
                $data = DB::table('catatan_hukumen')
                ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'catatan_hukumen.id_mahasiswa')
                ->select(
                    'tarunas.nama_mahasiswa',
                    'tarunas.nim',
                    'catatan_hukumen.id_catatan_hukuman',
                    'catatan_hukumen.created_at',
                    'catatan_hukumen.keterangan',
                    'catatan_hukumen.is_dikerjakan'
                )
                ->orderBy('catatan_hukumen.is_dikerjakan', 'ASC')
                ->get();
            }

        return view('catatanhukuman.index')->with('data', $data);
    }

    public function updatestatus($id){
        $data = CatatanHukuman::find($id);
        $data->update([
            'is_dikerjakan' => '1'
        ]);
        return back()->with(['sukses' => 'Tugas Berhasil Diupdate!']);
    }

    public function updatehukuman(Request $request){
        $request->validate([
            'keterangan'            => 'required',
            'id_catatan_hukuman'    => 'required'
        ]);

        $data = CatatanHukuman::find($request->input('id_catatan_hukuman'));
        $data->update([
            'keterangan'    => $request->input('keterangan')
        ]);

        return back()->with(['sukses' => 'Hukuman Berhasil Diupdate!']);
    }

    public function export(){
        return Excel::download(new CatatanHukumanExport, 'Catatan Hukuman Taruna.xlsx');
    }
}
