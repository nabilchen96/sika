<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\CatatanPelanggaran;
use App\Pelanggaran;
use Illuminate\Support\Facades\Hash;
use App\CatatanHukuman;
use App\Hukuman;
use App\Semester;
use App\Taruna;
use Auth;

class CatatanPelanggaranController extends Controller
{
    public function index(Request $request){
        if(!empty($request->input('id_mahasiswa'))){
            $data               = DB::table('catatan_pelanggarans')
                                ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'catatan_pelanggarans.id_mahasiswa')
                                ->join('users', 'users.id', '=', 'catatan_pelanggarans.id_pencatat')
                                ->join('pelanggarans', 'pelanggarans.id_pelanggaran', '=', 'catatan_pelanggarans.id_pelanggaran')
                                ->where('tarunas.id_mahasiswa', $request->input('id_mahasiswa'))
                                ->select(
                                    'catatan_pelanggarans.id_catatan_pelanggaran',
                                    'pelanggarans.id_pelanggaran',
                                    'catatan_pelanggarans.created_at', 
                                    'pelanggarans.pelanggaran', 
                                    'catatan_pelanggarans.poin_pelanggaran', 
                                    'users.name', 
                                    'catatan_pelanggarans.bukti_pelanggaran'
                                )
                                ->get();

            $taruna             = DB::table('tarunas')->where('id_mahasiswa', $request->input('id_mahasiswa'))->first();

            $poin_bulanan       = DB::table('catatan_pelanggarans')
                                ->join('pelanggarans', 'pelanggarans.id_pelanggaran', '=', 'catatan_pelanggarans.id_pelanggaran')
                                ->where('id_mahasiswa', $request->input('id_mahasiswa'))
                                ->whereMonth('catatan_pelanggarans.created_at', date('m'))
                                ->sum('catatan_pelanggarans.poin_pelanggaran');

            $poin_semester      = DB::table('catatan_pelanggarans')
                                    ->join('semesters', 'semesters.id_semester', '=', 'catatan_pelanggarans.id_semester')
                                    ->join('pelanggarans', 'pelanggarans.id_pelanggaran', '=', 'catatan_pelanggarans.id_pelanggaran')
                                    ->where('id_mahasiswa', $request->input('id_mahasiswa'))
                                    ->where('semesters.is_semester_aktif', 1)
                                    ->sum('catatan_pelanggarans.poin_pelanggaran');
            $poin_penghargaan   = null;
        }else{
            $data               = [];
            $taruna             = null;
            $poin_bulanan       = null;
            $poin_semester      = null;
            $poin_penghargaan   = null;

        }

        $pelanggaran = Pelanggaran::all();

        return view('catatanpelanggaran.index')
                ->with('pelanggaran', $pelanggaran)
                ->with('taruna', $taruna)
                ->with('poin_bulanan', $poin_bulanan)
                ->with('poin_semester', $poin_semester)
                ->with('poin_penghargaan', $poin_penghargaan)
                ->with('data', $data);
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

    public function create($id){

        $mahasiswa      = Taruna::find($id);
        $pelanggaran    = Pelanggaran::all();
        return view('catatanpelanggaran.create')
                ->with('pelanggaran', $pelanggaran)
                ->with('mahasiswa', $mahasiswa);
    }

    public function store(Request $request){

        $request->validate([
            'id_pencatat'           => 'required',
            'id_mahasiswa'          => 'required',
            'id_pelanggaran'        => 'required',
            'bukti_pelanggaran'     => 'required|mimetypes:image/jpeg,image/png|max:2048'
        ]);

        
        $pelanggaran_terakhir = CatatanPelanggaran::where('id_mahasiswa', $request->input('id_mahasiswa'))->latest('created_at')->first();

        if($pelanggaran_terakhir != null){
            $waktu_terakhir = date("H", strtotime(@$pelanggaran_terakhir->created_at));

            if($waktu_terakhir == date("H") && date('d-m-Y', strtotime($pelanggaran_terakhir->created_at)) == date('d-m-Y')){
                return back()->with(['gagal' => 'Pelanggaran Tidak Bisa Diinput, Minimal 1 Jam untuk input pealanggaran yang sama']);   
            }
        }

        $file           = $request->file('bukti_pelanggaran');
        $nama_file      = $file->getClientOriginalName();
        $file->move('bukti_pelanggaran', $nama_file);
        $semester       = DB::table('semesters')->where('is_semester_aktif', 1)->first();
        $pelanggaran    = Pelanggaran::where('id_pelanggaran', $request->input('id_pelanggaran'))->first();
        
        $catatan_pelanggaran = CatatanPelanggaran::where('id_mahasiswa', $request->input('id_mahasiswa'))
                                ->where('id_pelanggaran', $request->input('id_pelanggaran'))
                                ->where('id_semester', $semester->id_semester)
                                ->count();


        CatatanPelanggaran::create([
            'id_pencatat'       => $request->input('id_pencatat'),
            'id_mahasiswa'      => $request->input('id_mahasiswa'),
            'bukti_pelanggaran' => $nama_file,
            'id_pelanggaran'    => $request->input('id_pelanggaran'),
            'id_semester'       => $semester->id_semester,
            'poin_pelanggaran'  => $pelanggaran->poin_pelanggaran * ($catatan_pelanggaran >= 4 ? 4 : $catatan_pelanggaran + 1)
        ]);

        $this->catat_hukuman($request, $semester, $pelanggaran);

        return back()->with(['sukses' => 'Catatan Pelanggaran dan Hukuman Berhasil Disimpan, Silahkan Cek di Menu Catatan Hukuman Untuk Melihat Detail Hukuman']);
    }

    public function destroy($id){
        $data = CatatanPelanggaran::find($id);
        $data->delete();

        return back()->with(['sukses' => 'Data Berhasil Dihapus']);
    }

    public function update(Request $request){
        $request->validate([
            'id_pencatat'           => 'required',
            'id_mahasiswa'          => 'required',
            'id_pelanggaran'        => 'required',
            'id_catatan_pelanggaran'=> 'required',
        ]);

        $catatan_pelanggaran = CatatanPelanggaran::find($request->input('id_catatan_pelanggaran'));
        $semester = DB::table('semesters')->where('is_semester_aktif', 1)->first();

        if($request->file('bukti_pelanggaran')){
            $file       = $request->file('bukti_pelanggaran');
            $nama_file  = $file->getClientOriginalName();
            $file->move('bukti_pelanggaran', $nama_file);
        }else{
            $nama_file  = $catatan_pelanggaran->bukti_pelanggaran;
        }

        $catatan_pelanggaran->update([
            'id_pencatat'       => $request->input('id_pencatat'),
            'id_mahasiswa'      => $request->input('id_mahasiswa'),
            'bukti_pelanggaran' => $nama_file,
            'id_pelanggaran'    => $request->input('id_pelanggaran'),
            'id_semester'       => $semester->id_semester
        ]);

        //simpan data hukuman disini

        return back()->with(['sukses' => 'Data Berhasil Diupdate']);
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



        //4. jika mahasiswa melebihi poin 50 - 70
        if($poin_semester >= 50 ){
            CatatanHukuman::create([
                'id_mahasiswa'      => $request->input('id_mahasiswa'),
                'is_dikerjakan'     => "0",
                'id_semester'       => $semester->id_semester,
                'keterangan'        => 'SP-1 dan sanksi Latihan Kesamaptaan Terukur, Melakukan Kerja Sosial/Kerja Bakti, Membuat Karya Tulis atau Merangkum Buku',
                'rubah_hukuman'     => 1
            ]);
        }

        //5. jika mahasiswa melebihi poin 80 - 90
        if($poin_semester >= 80 ){
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
        }

        //6. jika mahasiswa melebihi poin atau sama dengan 100
        if($poin_semester >= 100){
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
