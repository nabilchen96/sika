<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\PengajuanSurat;
use Illuminate\Support\Facades\Hash;
use App\Perizinan;

class PengajuanSuratController extends Controller
{
    public function index(){

        $data = DB::table('pengajuan_surats')
                ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'pengajuan_surats.id')
                ->get();

        return view('pengajuansurat.index')->with('data', $data);
    }

    public function create(){

        $semester = DB::table('semesters')
                    ->where('a_periode_aktif', "1")
                    ->where('is_semester_aktif', "1")
                    ->first();

        return view('pengajuansurat.create')->with('semester', $semester);
    }

    public function store(Request $request){

        if($request->jenis_pengajuan == 'surat izin'){
            $request->validate([
                'id'                => 'required',
                'id_semester'       => 'required',
                'tempat_tujuan'     => 'required',
                'keperluan'         => 'required',
                'berangkat_tanggal' => 'required',
                'kembali_tanggal'   => 'required',
                'keterangan'        => 'required',
            ]);


            $data_keterangan = array(
                $request->tempat_tujuan,
                $request->keperluan,
                $request->berangkat_tanggal,
                $request->kembali_tanggal,
                $request->keterangan
            );


            PengajuanSurat::create([
                'id'                => $request->id,
                'id_semester'       => $request->id_semester,
                'jenis_pengajuan'   => $request->jenis_pengajuan,
                'keterangan'        => \serialize($data_keterangan),
                'status_pengajuan'  => '0'
            ]);

            return redirect('pengajuansurat')->with(['sukses' => 'Data berhasil disimpan!']);

        }else{
            $request->validate([
               'id'         => 'required',
               'id_semester'=> 'required',
               'keterangan' => 'required'
            ]);

            PengajuanSurat::create([
                'id'                => $request->id,
                'id_semester'       => $request->id_semester,
                'jenis_pengajuan'   => $request->jenis_pengajuan,
                'keterangan'        => $request->keterangan,
                'status_pengajuan'  => '0'
            ]);

            return redirect('pengajuansurat')->with(['sukses' => 'Data berhasil disimpan!']);
        }


    }

    public function edit($id){

        $data = DB::table('pengajuan_surats')
                ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'pengajuan_surats.id')
                ->join('semesters', 'semesters.id_semester', '=', 'pengajuan_surats.id_semester')
                ->where('id_pengajuan_surat', $id)
                ->first();

        return view('pengajuansurat.edit')->with('data', $data);
    }

    public function update(Request $request){

        if($request->jenis_pengajuan == 'surat izin'){

            $request->validate([
                'id_pengajuan_surat'=> 'required',
                'tempat_tujuan'     => 'required',
                'keperluan'         => 'required',
                'berangkat_tanggal' => 'required',
                'kembali_tanggal'   => 'required',
                'keterangan'        => 'required',
            ]);


            $data_keterangan = array(
                $request->tempat_tujuan,
                $request->keperluan,
                $request->berangkat_tanggal,
                $request->kembali_tanggal,
                $request->keterangan
            );

            $data = PengajuanSurat::find($request->id_pengajuan_surat);
            $data->update([
                'keterangan'        => \serialize($data_keterangan),
            ]);

            return redirect('pengajuansurat')->with(['sukses' => 'Data berhasil diupdate!']);

        }else{

            $request->validate([
                'id_pengajuan_surat'    => 'required',
                'keterangan' => 'required'
             ]);
 
             $data = PengajuanSurat::find($request->id_pengajuan_surat);
             $data->update([
                 'keterangan'        => $request->keterangan,
             ]);
 
             return redirect('pengajuansurat')->with(['sukses' => 'Data berhasil disimpan!']);
        }
    }

    public function destroy($id){

        $data = PengajuanSurat::find($id);
        $data->delete();

        return back()->with(['sukses' => 'Data berhasil dihapus!']);
    }

    public function jawabpengajuan(Request $request){

        $data = PengajuanSurat::find($request->id_pengajuan_surat);

        if($request->file('surat') == null){
            $data->update([
                'status_pengajuan' => $request->status_pengajuan 
            ]);

        }else{
            
            $file = $request->file('surat');
            $nama_file = $file->getClientOriginalName();
            $file->move('surat', $nama_file);

            $data->update([
                'status_pengajuan'  => $request->status_pengajuan,
                'surat'             => $nama_file
            ]);

            // kirim data ke catatan perizinan
            if($data->jenis_pengajuan == 'surat izin'){
                $keterangan = unserialize($data->keterangan);
                Perizinan::create([
                    'id_mahasiswa'      => $data->id,
                    'tgl_izin_keluar'   => $keterangan[2],
                    'keterangan_izin'   => 'Tujuan: '.$keterangan[0].", Keperluan: ".$keterangan[1].", Keterangan: ".$keterangan[4],
                    'id_semester'       => $data->id_semester
                ]);
            }
        }

        return redirect('pengajuansurat')->with(['sukses' => 'Data berhasil diperbarui']);

    }
}
