<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\PengajuanSurat;
use Illuminate\Support\Facades\Hash;
use App\Perizinan;
use auth;
use Symfony\Component\Process\Process;
// use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class PengajuanSuratController extends Controller
{
    public function index(){


        if(auth::user()->role == 'taruna'){
            $data = DB::table('pengajuan_surats')
                ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'pengajuan_surats.id_mahasiswa')
                ->where('tarunas.nim', auth::user()->nip)
                ->get();
        }else{
            if(auth::user()->role == 'pengasuh'){
                $data = DB::table('pengajuan_surats')
                    ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'pengajuan_surats.id_mahasiswa')
                    ->join('asuhans', 'asuhans.id_mahasiswa', '=', 'tarunas.id_mahasiswa')
                    ->where('asuhans.id_pengasuh', auth::user()->id)
                    ->get();
            }else{
                $data = DB::table('pengajuan_surats')
                ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'pengajuan_surats.id_mahasiswa')
                ->get();
            }
        }

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

        // dd($request);

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

            // dd($request->id);


            $data_keterangan = array(
                $request->tempat_tujuan,
                $request->keperluan,
                $request->berangkat_tanggal,
                $request->kembali_tanggal,
                $request->keterangan
            );


            PengajuanSurat::create([
                'id_mahasiswa'       => $request->id,
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
                'id_mahasiswa'      => $request->id,
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
                ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'pengajuan_surats.id_mahasiswa')
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
            
        $data->update([
            'status_pengajuan'  => $request->status_pengajuan,
            'alasan_tolak'      => $alasan = $request->alasan != null && $request->status_pengajuan == 2 ? $request->alasan : null
        ]);
    

        return redirect('pengajuansurat')->with(['sukses' => 'Data berhasil diperbarui']);

    }

    public function terbitkansurat(Request $request){
        
        $request->validate([
            'id_pengajuan_surat'    => 'required',
            'ttd'                   => 'required',
            'jenis_pengajuan'       => 'required'
        ]);

        //membuat ttd menjadi gambar
        $encode_image = explode(",", $request->ttd)[1];
        $decoded_image = base64_decode($encode_image);
        file_put_contents("signature.png", $decoded_image);

        //ambil data taruna pengaju surat
        $data = DB::table('pengajuan_surats')
                ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'pengajuan_surats.id_mahasiswa')
                ->where('id_pengajuan_surat', $request->id_pengajuan_surat)
                ->first();

        if($request->jenis_pengajuan == 'surat izin'){

            $template = DB::table('templates')->where('kategori', '1')->first();

            //mengambil template surat
            $document = file_get_contents("templatesurat/".$template->template);

            //pecah array
            $detail_keterangan = unserialize($data->keterangan);

            //memindahkan surat
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor("templatesurat/".$template->template);

            $templateProcessor->setValues([
                'NOMOR'             => '1',
                'JENISSURAT'        => 'IJ',
                'BULAN'             => date('m'),
                'TAHUN'             => date('Y'),
                'NAMA'              => $data->nama_mahasiswa,
                'NIT'               => $data->nim,
                'TEMPATTUJUAN'      => $detail_keterangan[0],
                'KEPERLUAN'         => $detail_keterangan[1],
                'BERANGKATTANGGAL'  => date('d-m-Y', strtotime($detail_keterangan[2])),
                'KEMBALITANGGAL'    => date('d-m-Y', strtotime($detail_keterangan[3])),
                'CATATAN'           => $detail_keterangan[4],
                'TANGGALSURAT'      => date('d-m-Y'),
            ]);

            $templateProcessor->setImageValue('TTD', array('path' => 'signature.png', 'width' => 100, 'height' => 100, 'ratio' => false));

            $nama_file = date('YmdHis').'.doc';

            //memindahkan surat
            $templateProcessor->saveAs('surat/'.$nama_file);

            //menyimpan surat ke database
            DB::table('pengajuan_surats')
            ->where('id_pengajuan_surat', $request->id_pengajuan_surat)
            ->update([
                'surat' => $nama_file
            ]);

            // kirim data ke catatan perizinan
            if($data->jenis_pengajuan == 'surat izin'){
                $keterangan = unserialize($data->keterangan);
                Perizinan::create([
                    'id_mahasiswa'      => $data->id_mahasiswa,
                    'tgl_izin_keluar'   => $detail_keterangan[2],
                    'keterangan_izin'   => 'Tujuan: '.$detail_keterangan[0].", Keperluan: ".$detail_keterangan[1].", Keterangan: ".$detail_keterangan[4],
                    'id_semester'       => $data->id_semester
                ]);
            }

            return redirect('pengajuansurat')->with(['sukses' => 'data berhasil disimpan']);

        }elseif($request->jenis_pengajuan == 'surat keterangan'){

            //mengambil template surat
            $template = DB::table('templates')->where('kategori', '2')->first();
            $document = file_get_contents("templatesurat/".$template->template);

            //memindahkan surat
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor("templatesurat/".$template->template);

            //singkatan
            if($data->nama_program_studi == 'Teknologi Rekayasa Bandar Udara'){
                $singkatan = 'TRBU';
            }elseif($data->nama_program_studi == 'Manajemen Bandar Udara'){
                $singkatan = 'MBU';
            }else{
                $singkatan = 'PPKP';
            }

            $templateProcessor->setValues([
                'nama'              => $data->nama_mahasiswa,
                'nit'               => $data->nim,
                'tempat_lahir'      => $data->tempat_lahir,
                'tgl_lahir'         => $data->tanggal_lahir,
                'jenjang_program'   => $data->nama_program_studi == 'Teknologi Rekayasa Bandar Udara' ? 'Diploma Empat' : 'Diploma Tiga',
                'prodi'             => $data->nama_program_studi,
                'singkatan'         => $singkatan,
                'alamat'            => $data->alamat,
                'tanggal'           => date('d-m-Y'),
            ]);

            $templateProcessor->setImageValue('TTD', array('path' => 'signature.png', 'width' => 100, 'height' => 100, 'ratio' => false));
            

            $nama_file = date('YmdHis').'.doc';

            //memindahkan surat
            $templateProcessor->saveAs('surat/'.$nama_file);

            $process = new Process(['libreoffice --headless --convert-to pdf /var/www/sika/public/surat/'.$nama_file.' --outdir /var/www/sika/public/surat']);
            // $process = new Process(['php artisan config:cache']);
            $process->run();

            if (!$process->isSuccessful()) {
                // throw new ProcessFailedException($process);
                return back()->with(['gagal' => 'Data gagal diubah karena template masih salah']);
            }

            //menyimpan surat ke database
            DB::table('pengajuan_surats')
            ->where('id_pengajuan_surat', $request->id_pengajuan_surat)
            ->update([
                'surat' => $nama_file
            ]);

            //kembali ke halaman pengajuan surat
            return redirect('pengajuansurat')->with(['sukses' => 'data berhasil disimpan']);
        }

    }
}
