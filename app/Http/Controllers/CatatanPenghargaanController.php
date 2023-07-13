<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\CatatanPenghargaan;
use auth;
use App\Exports\PenghargaanTarunaExport;
use Maatwebsite\Excel\Facades\Excel;
use DOMDocument;
use \PhpOffice\PhpWord\TemplateProcessor,
    \PhpOffice\PhpWord\Shared\Html,
    \PhpOffice\PhpWord\PhpWord,
    \PhpOffice\PhpWord\Element\Table;

class CatatanPenghargaanController extends Controller
{
    public function index(Request $request){

            $data = DB::table('catatan_penghargaans')
                        ->leftjoin('tarunas', 'tarunas.id_mahasiswa', '=', 'catatan_penghargaans.id_mahasiswa')
                        ->leftjoin('penghargaans', 'penghargaans.id_penghargaan', '=', 'catatan_penghargaans.id_penghargaan')
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
                            'penghargaans.id_penghargaan', 
                            'catatan_penghargaans.template_penghargaan', 
                            'catatan_penghargaans.keterangan'
                        )
                        ->where('catatan_penghargaans.id_semester', $request->id_semester)
                        ->get();

                $taruna = null;

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
                $data = DB::table('tarunas')
                ->select('id_mahasiswa', 'nama_mahasiswa')->where('nama_mahasiswa', 'LIKE', '%'.$cari.'%')
                ->get();
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
            'id_mahasiswa'          => $request->input('id_mahasiswa'),
            'id_penghargaan'        => $request->input('id_penghargaan'),
            'tgl_penghargaan'       => $request->input('tgl_penghargaan'),
            'sk_penghargaan'        => $request->input('sk_penghargaan'),
            'id_semester'           => $semester->id_semester,
            'template_penghargaan'  => $request->template_penghargaan,
            'keterangan'            => $request->keterangan
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
            'id_catatan_penghargaan'    => $request->input('id_catatan_penghargaan'),
            'template_penghargaan'  => $request->template_penghargaan, 
            'keterangan'        => $request->keterangan
        ]);

        return back()->with(['sukses' => 'Data Berhasil Diupdate!']);
    }

    public function destroy($id){
        $data = CatatanPenghargaan::find($id);
        $data->delete();

        return back()->with(['sukses' => 'Data Berhasil Dihapus!']);
    }

    public function export(){

        return Excel::download(new PenghargaanTarunaExport, 'Catatan Penghargaan Taruna.xlsx');
    }

    public function sertifikatPenghargaan($id){

        ini_set('max_execution_time', 300);

        $data = DB::table('catatan_penghargaans as cp')
                ->join('tarunas as t', 't.id_mahasiswa', '=', 'cp.id_mahasiswa')
                ->join('penghargaans as p', 'p.id_penghargaan', '=', 'cp.id_penghargaan')
                ->join('templates as tmp', 'tmp.id_template', '=', 'cp.template_penghargaan')
                ->select(
                    'cp.*', 
                    't.nama_mahasiswa', 
                    't.nama_program_studi', 
                    't.nim',
                    't.nama_kelas',
                    'p.penghargaan',
                    'p.bidang_penghargaan',
                    'p.poin_penghargaan',
                    'tmp.template'
                )
                ->where('cp.id_catatan_penghargaan', $id)
                ->first();

        $semester = DB::table('semesters')->where('is_semester_aktif', '1')->first();


        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor("templatesurat/".$data->template);
        \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(false);

        // Mengganti variabel pada template
        $templateProcessor->setValues([
            'nama_taruna'           => $data->nama_mahasiswa, 
            'nit'                   => $data->nim, 
            'prodi'                 => $data->nama_program_studi, 
            'kelas'                 => $data->nama_kelas, 
            'penghargaan'           => $data->penghargaan, 
            'bidang_penghargaan'    => $data->bidang_penghargaan, 
            'poin_penghargaan'      => $data->poin_penghargaan, 
            'semester'              => $semester->nama_semester, 
            'tanggal_penghargaan'   => date('d-m-Y', strtotime($data->tgl_penghargaan)), 
            'sk_penghargaan'        => $data->sk_penghargaan, 
            'keterangan'            => $data->keterangan
        ]);

        $outputFilePath = 'catatan_penghargaan/output.docx';
        $templateProcessor->saveAs($outputFilePath);

        // Set header untuk membuka file di browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: inline; filename=Sertifikat Penghargaan.docx');

        // Baca file Docx yang telah disimpan dan kirimkan ke output browser
        readfile('catatan_penghargaan/output.docx');
    }
}
