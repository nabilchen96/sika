<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\CatatanPelanggaran;
use Illuminate\Support\Facades\Validator;
use App\Pelanggaran;
use Illuminate\Support\Facades\Hash;
use App\CatatanHukuman;
use App\Hukuman;
use App\Semester;
use App\Taruna;

class PelanggaranController extends Controller
{
    public function index(){

        $data   = DB::table('tarunas')
                    ->leftjoin('catatan_pelanggarans', 'catatan_pelanggarans.id_mahasiswa', '=', 'tarunas.id_mahasiswa')
                    ->leftjoin('semesters', 'semesters.id_semester', '=', 'catatan_pelanggarans.id_semester')
                    ->select(
                        'tarunas.nama_mahasiswa', 
                        'tarunas.nama_program_studi', 
                        'tarunas.jenis_kelamin',
                        'tarunas.nim', 
                        'tarunas.id_mahasiswa',
                        'tarunas.foto',
                        DB::raw('sum(catatan_pelanggarans.poin_pelanggaran) as poin_semester')
                    )
                    ->where('semesters.is_semester_aktif', '1')
                    ->orderBy('poin_semester', 'DESC')
                    ->groupBy('tarunas.id_mahasiswa');

        if(request('cari')){
            $data = $data->where('tarunas.nama_mahasiswa', 'like', '%'.request('cari').'%')->get();
        }else{
            $data = $data->get();
        }
        
        return view('mobile.pelanggaran', [
            'data'  => $data
        ]);

    }

    public function detail($id){

        $data = DB::table('catatan_pelanggarans')
                    ->join('pelanggarans', 'pelanggarans.id_pelanggaran', '=', 'catatan_pelanggarans.id_pelanggaran')
                    ->join('semesters', 'semesters.id_semester', '=', 'catatan_pelanggarans.id_semester')
                    ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'catatan_pelanggarans.id_mahasiswa')
                    ->select(
                        'catatan_pelanggarans.*',
                        'pelanggarans.pelanggaran',
                        'tarunas.nama_mahasiswa',
                        'tarunas.id_mahasiswa', 
                        'tarunas.jenis_kelamin', 
                        'tarunas.nim', 
                        'tarunas.nama_program_studi'
                    )
                    ->where('semesters.is_semester_aktif', '1')
                    ->where('catatan_pelanggarans.id_mahasiswa', $id)
                    ->get();

        return view('mobile.detail-pelanggaran', [
            'data'  => $data
        ]);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'id_mahasiswa'      => 'required', 
        ]);

        if ($validator->fails()) {

            $data = [
                'responCode'    => 0,
                'respon'        => $validator->errors()
            ];

        } else {

            //pelanggaran terakhir taruna
            $pelanggaran_terakhir = CatatanPelanggaran::where('id_mahasiswa', $request->input('id_mahasiswa'))->latest('created_at')->first();

            //jika bukti pelanggaran ada
            if($request->file('bukti_pelanggaran')){
                $file           = $request->file('bukti_pelanggaran');
                $nama_file      = $file->getClientOriginalName();
                $file->move('bukti_pelanggaran', $nama_file);
            }else{
                $nama_file = null;
            }

            //cek semester
            $semester       = DB::table('semesters')->where('is_semester_aktif', 1)->first();

            //cari pelanggaran
            $pelanggaran    = Pelanggaran::where('id_pelanggaran', $request->input('id_pelanggaran'))->first();
            
            //total pelanggaran
            $catatan_pelanggaran = CatatanPelanggaran::where('id_mahasiswa', $request->input('id_mahasiswa'))
                                    ->where('id_pelanggaran', $request->input('id_pelanggaran'))
                                    ->where('id_semester', $semester->id_semester)
                                    ->count();

            //buat catatan pelanggaran
            CatatanPelanggaran::create([
                'id_pencatat'       => Auth::user()->id ?? 1,
                'id_mahasiswa'      => $request->input('id_mahasiswa'),
                'bukti_pelanggaran' => $nama_file,
                'id_pelanggaran'    => $request->input('id_pelanggaran'),
                'id_semester'       => $semester->id_semester,
                'poin_pelanggaran'  => $pelanggaran->poin_pelanggaran * ($catatan_pelanggaran >= 4 ? 4 : $catatan_pelanggaran + 1)
            ]);

            $this->catat_hukuman($request, $semester, $pelanggaran);

            $data = [
                'responCode'    => 1,
                'respon'        => 'Data Sukses Ditambah'
            ];

        }

        return response()->json($data);
    }

    public function catat_hukuman($request, $semester, $pelanggaran){

        //simpan data hukuman disini
        CatatanHukuman::create([
            'id_mahasiswa'      => $request->input('id_mahasiswa'),
            'is_dikerjakan'     => "0",
            'id_semester'       => $semester->id_semester,
            'keterangan'        => $request->input('hukuman'),
            'rubah_hukuman'     => 1
        ]);

        //1. hitung poin semester
        $poin_semester   = CatatanPelanggaran::where('id_mahasiswa', $request->input('id_mahasiswa'))
                            ->where('id_semester', $semester->id_semester)
                            ->sum('poin_pelanggaran');

        //2. ambil nim mahasiswa
        $mahasiswa       = Taruna::where('id_mahasiswa', $request->input('id_mahasiswa'))->select('nim')->first();

        //3. ambil angkatan mahasiswa
        $tingkat_mhs     = substr($semester->nama_semester, 2, 2) - substr($mahasiswa->nim, 4, 2) + 1;


        if($poin_semester >= 50 && $poin_semester < 70){
            CatatanHukuman::create([
                'id_mahasiswa'      => $request->input('id_mahasiswa'),
                'is_dikerjakan'     => "0",
                'id_semester'       => $semester->id_semester,
                'keterangan'        => 'SP-1 dan sanksi Latihan Kesamaptaan Terukur, Melakukan Kerja Sosial/Kerja Bakti, Membuat Karya Tulis atau Merangkum Buku',
                'rubah_hukuman'     => 1
            ]);

        }elseif($poin_semester >= 80 && $poin_semester <= 100){
            CatatanHukuman::create([
                'id_mahasiswa'      => $request->input('id_mahasiswa'),
                'is_dikerjakan'     => "0",
                'id_semester'       => $semester->id_semester,
                'keterangan'        => `SP-1 dan sanksi Latihan Kesamaptaan Terukur, 
                                        Melakukan Kerja Sosial/Kerja Bakti, Pemanggilan Orang Tua, 
                                        Pencabutan Hak Pesiar/Bermalam Selama 3 Minggu berturut-turut,
                                        Membuat Karya Tulis atau Merangkum Buku,
                                        Tidak diijinkan untuk mengikuti kegiatan ekstrakurikuler`,
                'rubah_hukuman'     => 0
            ]);

        }elseif($poin_semester >= 100){
            CatatanHukuman::create([
                'id_mahasiswa'      => $request->input('id_mahasiswa'),
                'is_dikerjakan'     => "0",
                'id_semester'       => $semester->id_semester,
                'keterangan'        => `Pembebasan dari Jabatan Organisasi Korps Taruna,
                                        Diusulkan kepada Dewan Kehormatan Taruna untuk diberhentikan dari Politeknik Penerbangan Palembang`,
                'rubah_hukuman'     => 0
            ]);
        }
    }
}
