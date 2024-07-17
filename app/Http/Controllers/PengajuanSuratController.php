<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use DB;
use App\PengajuanSurat;
use Illuminate\Support\Facades\Hash;
use App\Perizinan;
use auth;
use Symfony\Component\Process\Process;
use NcJoes\OfficeConverter\OfficeConverter;
// use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class PengajuanSuratController extends Controller
{
    public function index()
    {
        if (auth::user()->role == 'taruna') {
            $data = DB::table('pengajuan_surats')
                ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'pengajuan_surats.id_mahasiswa')
                ->where('tarunas.nim', auth::user()->nip)
                ->select(
                    'pengajuan_surats.*',
                    'tarunas.nama_mahasiswa',
                    'tarunas.id_mahasiswa'
                )
                ->orderBy('pengajuan_surats.created_at', 'DESC')
                ->get();
        } else {
            if (auth::user()->role == 'pengasuh') {

                // $kordinator = DB::table('kordinator_pengasuhs')->where('id', auth::user()->id)->first();

                // if ($kordinator) {
                //     $grup_kordinasi = DB::table('grup_kordinasi_pengasuhs')->where('id_kordinator_pengasuh', $kordinator->id_kordinator_pengasuh)->get();

                //     $data = DB::table('pengajuan_surats')
                //         ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'pengajuan_surats.id_mahasiswa')
                //         ->join('asuhans', 'asuhans.id_mahasiswa', '=', 'tarunas.id_mahasiswa')
                //         ->join('users', 'users.id', '=', 'asuhans.id_pengasuh')
                //         ->where(function ($q) use ($grup_kordinasi) {

                //             foreach ($grup_kordinasi as $k) {
                //                 $q->orWhere('asuhans.id_pengasuh', $k->id);
                //             }

                //         })
                //         ->select(
                //             'pengajuan_surats.*',
                //             'tarunas.nama_mahasiswa',
                //             'tarunas.id_mahasiswa'
                //         )
                //         ->orderBy('pengajuan_surats.created_at', 'DESC')
                //         ->get();

                // } else {
                //     $data = DB::table('pengajuan_surats')
                //         ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'pengajuan_surats.id_mahasiswa')
                //         ->join('asuhans', 'asuhans.id_mahasiswa', '=', 'tarunas.id_mahasiswa')
                //         ->where('asuhans.id_pengasuh', auth::user()->id)
                //         ->select(
                //             'pengajuan_surats.*',
                //             'tarunas.nama_mahasiswa',
                //             'tarunas.id_mahasiswa'
                //         )
                //         ->orderBy('pengajuan_surats.created_at', 'DESC')
                //         ->get();
                // }

                $data = DB::table('pengajuan_surats')
                        ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'pengajuan_surats.id_mahasiswa')
                        ->join('asuhans', 'asuhans.id_mahasiswa', '=', 'tarunas.id_mahasiswa')
                        ->where('asuhans.id_pengasuh', auth::user()->id)
                        ->select(
                            'pengajuan_surats.*',
                            'tarunas.nama_mahasiswa',
                            'tarunas.id_mahasiswa'
                        )
                        ->orderBy('pengajuan_surats.created_at', 'DESC')
                        ->get();

            } else {
                $data = DB::table('pengajuan_surats')
                    ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'pengajuan_surats.id_mahasiswa')
                    ->select(
                        'pengajuan_surats.*',
                        'tarunas.nama_mahasiswa',
                        'tarunas.id_mahasiswa'
                    )
                    ->orderBy('pengajuan_surats.created_at', 'DESC')
                    ->get();
            }
        }

        return view('pengajuansurat.index')->with('data', $data);
    }

    public function create()
    {

        $semester = DB::table('semesters')
            ->where('a_periode_aktif', "1")
            ->where('is_semester_aktif', "1")
            ->first();

        return view('pengajuansurat.create')->with('semester', $semester);
    }

    public function store(Request $request)
    {

        // dd($request);

        if ($request->jenis_pengajuan == 'surat izin') {
            $request->validate([
                'id' => 'required',
                'id_semester' => 'required',
                'tempat_tujuan' => 'required',
                'keperluan' => 'required',
                'berangkat_tanggal' => 'required',
                'kembali_tanggal' => 'required',
                'keterangan' => 'required',
            ]);

            $nama_lampiran = '';

            //JIKA ADA LAMPIRAN
            if ($request->lampiran) {
                $lampiran = $request->lampiran;
                $nama_lampiran = '1' . date('YmdHis.') . $lampiran->extension();
                $lampiran->move('lampiran', $nama_lampiran);
            }

            $data_keterangan = array(
                $request->tempat_tujuan,
                $request->keperluan,
                $request->berangkat_tanggal,
                $request->kembali_tanggal,
                $request->keterangan,
                $request->waktu_izin,
                $nama_lampiran,
                $request->transportasi
            );


            PengajuanSurat::create([
                'id_mahasiswa' => $request->id,
                'id_semester' => $request->id_semester,
                'jenis_pengajuan' => $request->jenis_pengajuan,
                'keterangan' => \serialize($data_keterangan),
                'status_pengajuan' => '0'
            ]);

            //CEK DATA TARUNA
            $taruna = DB::table('tarunas')->where('id_mahasiswa', $request->id)->first();

            //CEK NAMA PENGASUH
            $asuhan = DB::table('asuhans as a')
                        ->join('users as u', 'u.id', '=', 'a.id_pengasuh')
                        ->where('a.id_mahasiswa', $request->id)
                        ->first();

            $pesan = 'Taruna atas nama '.$taruna->nama_mahasiswa.' dari prodi '.$taruna->nama_program_studi.' mengajukan izin pesiar dengan keterangan
                
NIM: '.$taruna->nim.'
Course: '.$taruna->nama_kelas.'
Tempat Tujuan: '.@$request->tempat_tujuan.'
Keperluan: '.@$request->keperluan.'
Berangkat: '.date('d-m-Y H:i', strtotime(@$request->berangkat_tanggal)).'
Kembali: '.date('d-m-Y H:i', strtotime(@$request->kembali_tanggal)).'
Moda Transportasi: '.@$request->transportasi.'
Waktu Izin: '.@$request->waktu_izin.'
keterangan: '.@$request->keterangan.'

Kepada Pengasuh yang bersangkutan untuk dapat menindak lanjuti izin dari taruna tersebut melalui website sikap di 
https://sikap.poltekbangplg.ac.id
            ';
    
            // $response = Http::withHeaders([
            //     'Authorization' => '-t8BRBytMIWY1ucemoVb', // change TOKEN to your actual token
            // ])->post('https://api.fonnte.com/send', [
            //     'target' => $asuhan->no_telp,
            //     'message' => $pesan,
            //     'countryCode' => '62', // optional
            // ]);

            return redirect('pengajuansurat')->with(['sukses' => 'Data berhasil disimpan!']);

        } else {
            $request->validate([
                'id' => 'required',
                'id_semester' => 'required',
                'keterangan' => 'required'
            ]);

            PengajuanSurat::create([
                'id_mahasiswa' => $request->id,
                'id_semester' => $request->id_semester,
                'jenis_pengajuan' => $request->jenis_pengajuan,
                'keterangan' => $request->keterangan,
                'status_pengajuan' => '0'
            ]);

            return redirect('pengajuansurat')->with(['sukses' => 'Data berhasil disimpan!']);
        }


    }

    public function edit($id)
    {

        $data = DB::table('pengajuan_surats')
            ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'pengajuan_surats.id_mahasiswa')
            ->join('semesters', 'semesters.id_semester', '=', 'pengajuan_surats.id_semester')
            ->where('id_pengajuan_surat', $id)
            ->first();

        return view('pengajuansurat.edit')->with('data', $data);
    }

    public function update(Request $request)
    {

        if ($request->jenis_pengajuan == 'surat izin') {

            $request->validate([
                'id_pengajuan_surat' => 'required',
                'tempat_tujuan' => 'required',
                'keperluan' => 'required',
                'berangkat_tanggal' => 'required',
                'kembali_tanggal' => 'required',
                'keterangan' => 'required',
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
                'keterangan' => \serialize($data_keterangan),
            ]);

            return redirect('pengajuansurat')->with(['sukses' => 'Data berhasil diupdate!']);

        } else {

            $request->validate([
                'id_pengajuan_surat' => 'required',
                'keterangan' => 'required'
            ]);

            $data = PengajuanSurat::find($request->id_pengajuan_surat);
            $data->update([
                'keterangan' => $request->keterangan,
            ]);

            return redirect('pengajuansurat')->with(['sukses' => 'Data berhasil disimpan!']);
        }
    }

    public function destroy($id)
    {

        $data = PengajuanSurat::find($id);
        $data->delete();

        return back()->with(['sukses' => 'Data berhasil dihapus!']);
    }

    public function jawabpengajuan(Request $request)
    {

        $data = PengajuanSurat::find($request->id_pengajuan_surat);

        $data->update([
            'status_pengajuan' => $request->status_pengajuan,
            'alasan_tolak' => $alasan = $request->alasan != null && $request->status_pengajuan == 2 ? $request->alasan : null
        ]);


        return redirect('pengajuansurat')->with(['sukses' => 'Data berhasil diperbarui']);

    }

    public function terbitkansurat(Request $request)
    {

        $request->validate([
            'id_pengajuan_surat' => 'required',
            'ttd' => 'required',
            'jenis_pengajuan' => 'required'
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

        if ($request->jenis_pengajuan == 'surat izin') {

            $template = DB::table('templates')->where('kategori', '1')->first();

            //mengambil template surat
            $document = file_get_contents("templatesurat/" . $template->template);

            //pecah array
            $detail_keterangan = unserialize($data->keterangan);

            //memindahkan surat
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor("templatesurat/" . $template->template);

            $surat_terakhir = DB::table('pengajuan_surats')
                                ->where('jenis_pengajuan', 'surat izin')
                                ->whereNotNull('nomor_surat')
                                ->latest('created_at')
                                ->value('nomor_surat');

            // dd($surat_terakhir);

            $nomor = $surat_terakhir == null ? 1 : $surat_terakhir + 1;

            $templateProcessor->setValues([
                'NOMOR' => $nomor,
                'JENISSURAT' => 'IJ',
                'BULAN' => date('m'),
                'TAHUN' => date('Y'),
                'NAMA' => $data->nama_mahasiswa,
                'NIT' => $data->nim,
                'TRANSPORTASI' => @$detail_keterangan[7],
                'TEMPATTUJUAN' => $detail_keterangan[0],
                'KEPERLUAN' => $detail_keterangan[1],
                'BERANGKATTANGGAL' => date('d-m-Y H:i', strtotime(@$detail_keterangan[2])),
                'KEMBALITANGGAL' => date('d-m-Y H:i', strtotime(@$detail_keterangan[3])),
                'CATATAN' => $detail_keterangan[4],
                'TANGGALSURAT' => date('d-m-Y'),
                'PRODI' => $data->nama_program_studi,
                'KELAS' => $data->nama_kelas,
                'TANGGAL_HARI_INI' => date('d-m-Y')
            ]);

            $templateProcessor->setImageValue('TTD', array('path' => 'signature.png', 'width' => 100, 'height' => 100, 'ratio' => false));

            $nama_file = date('YmdHis');

            //memindahkan surat
            $templateProcessor->saveAs('surat/' . $nama_file . ".docx");

            $surat = public_path('surat/' . $nama_file . ".docx");

            $converter = new OfficeConverter($surat);
            $converter->convertTo('pdf/' . $nama_file . '.pdf');

            //menyimpan surat ke database
            DB::table('pengajuan_surats')
                ->where('id_pengajuan_surat', $request->id_pengajuan_surat)
                ->update([
                    'surat' => $nama_file . '.pdf',
                    'nomor_surat' => $nomor
                ]);

            // kirim data ke catatan perizinan
            if ($data->jenis_pengajuan == 'surat izin') {
                $keterangan = unserialize($data->keterangan);
                Perizinan::create([
                    'id_mahasiswa' => $data->id_mahasiswa,
                    'tgl_izin_keluar' => $detail_keterangan[2],
                    'keterangan_izin' => 'Tujuan: ' . $detail_keterangan[0] . ", Keperluan: " . $detail_keterangan[1] . ", Keterangan: " . $detail_keterangan[4],
                    'id_semester' => $data->id_semester
                ]);
            }

            return redirect('pengajuansurat')->with(['sukses' => 'data berhasil disimpan']);

        } elseif ($request->jenis_pengajuan == 'surat keterangan') {

            //mengambil template surat
            $template = DB::table('templates')->where('kategori', '2')->first();
            $document = file_get_contents("templatesurat/" . $template->template);

            //memindahkan surat
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor("templatesurat/" . $template->template);

            //singkatan
            if ($data->nama_program_studi == 'Teknologi Rekayasa Bandar Udara') {
                $singkatan = 'TRBU';
            } elseif ($data->nama_program_studi == 'Manajemen Bandar Udara') {
                $singkatan = 'MBU';
            } else {
                $singkatan = 'PPKP';
            }

            $templateProcessor->setValues([
                'nama' => $data->nama_mahasiswa,
                'jk' => $data->jenis_kelamin == 'L' ? 'Taruna' : 'Taruni',
                'nit' => $data->nim,
                'tempat_lahir' => $data->tempat_lahir,
                'tgl_lahir' => date('d-m-Y', strtotime($data->tanggal_lahir)),
                'jenjang_program' => $data->nama_program_studi == 'Teknologi Rekayasa Bandar Udara' ? 'Diploma Empat' : 'Diploma Tiga',
                'prodi' => $data->nama_program_studi,
                'singkatan' => $singkatan,
                'alamat' => $data->alamat,
                'tanggal' => date('d-m-Y'),
                'nomor_surat' => $request->nomor_surat,
            ]);

            $templateProcessor->setImageValue('TTD', array('path' => 'signature.png', 'width' => 100, 'height' => 100, 'ratio' => false));


            $nama_file = date('YmdHis');

            //memindahkan surat
            $templateProcessor->saveAs('surat/' . $nama_file . ".docx");

            $surat = public_path('surat/' . $nama_file . ".docx");

            $converter = new OfficeConverter($surat);
            $converter->convertTo('pdf/' . $nama_file . '.pdf');

            //menyimpan surat ke database
            DB::table('pengajuan_surats')
                ->where('id_pengajuan_surat', $request->id_pengajuan_surat)
                ->update([
                    'surat' => $nama_file . '.pdf',
                    'nomor_surat' => $request->nomor_surat
                ]);

            //kembali ke halaman pengajuan surat
            return redirect('pengajuansurat')->with(['sukses' => 'data berhasil disimpan']);
        }

    }

    public function tesWa(Request $request)
    {

        $taruna = DB::table('tarunas')->where('id_mahasiswa', 241)->first();

        $pesan = 'Taruna atas nama '.$taruna->nama_mahasiswa.' dari prodi '.$taruna->nama_program_studi.' mengajukan izin pesiar dengan keterangan
            
NIM: '.$taruna->nim.'
Course: '.$taruna->nama_kelas.'
Tempat Tujuan: '.@$request->tempat_tujuan.'
Keperluan: '.@$request->keperluan.'
Berangkat: '.@$request->berangkat_tanggal.'
Kembali: '.@$request->kembali_tanggal.'
Waktu Izin: '.@$request->waktu_izin.'
keterangan: '.@$request->keterangan.'

Kepada Pengasuh yang bersangkutan untuk dapat menindak lanjuti izin dari taruna tersebut melalui website sikap di 
https://sikap.poltekbangplg.ac.id
        ';

        $response = Http::withHeaders([
            'Authorization' => '-t8BRBytMIWY1ucemoVb', // change TOKEN to your actual token
        ])->post('https://api.fonnte.com/send', [
            'target' => '081271449921',
            'message' => $pesan,
            'countryCode' => '62', // optional
        ]);

        // Mendapatkan status kode dari respons
        $status = $response->status();

        // Mendapatkan body dari respons
        $body = $response->body();

        // Menangani error jika ada
        if ($status !== 200) {
            $error_msg = "HTTP request failed with status code: $status\nResponse body: $body";
            echo $error_msg;
        } else {
            echo $body;
        }
    }
}
