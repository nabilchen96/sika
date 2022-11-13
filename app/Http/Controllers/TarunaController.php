<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\User;
use App\Taruna;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Exports\TarunaExport;
use Maatwebsite\Excel\Facades\Excel;

class TarunaController extends Controller
{
    public function updatetarunaserver(){

        $response = Http::get('https://siakad.poltekbangplg.ac.id/api/gettaruna');
        $response = json_decode($response, true);

        foreach($response['data'] as $item){
            // $cek_taruna     = Taruna::where('id_mahasiswa_siakad', $item['id_mahasiswa'])->count();
            // $update_taruna  = Taruna::where('id_mahasiswa_siakad', $item['id_mahasiswa'])->first();

            Taruna::updateOrCreate(
                [
                    'id_mahasiswa_siakad'   => $item['id_mahasiswa'],
                    // 'nim'                   => $item['nim'],
                ],
                [
                    'id_mahasiswa_siakad'   => $item['id_mahasiswa'],
                    'jenis_kelamin'         => $item['jenis_kelamin'],
                    'tempat_lahir'          => $item['tempat_lahir'],
                    'tanggal_lahir'         => $item['tanggal_lahir'],
                    'nama_mahasiswa'        => $item['nama_mahasiswa'],
                    'nim'                   => $item['nim'],
                    'id_kelas'              => $item['id_kelas'],
                    'nama_kelas'            => $item['nama_kelas'],
                    'id_prodi'              => $item['id_prodi'],
                    'nama_program_studi'    => $item['nama_program_studi'],
                    'semester'              => $item['semesteraktif'],
                    'agama'                 => $item['nama_agama'],
                    'alamat'                => $item['alamat'],
                    'foto'                  => 'https://siakad.poltekbangplg.ac.id/upload/fototaruna/'.$item['foto']
                ]);

            User::updateOrCreate(
                [
                    'email' => $item['nim'],
                ],
                [
                    'name'                  => $item['nama_mahasiswa'],
                    'email'                 => $item['nim'],
                    'password'              => Hash::make($item['nim']),
                    'jk'                    => $item['jenis_kelamin'] == 'L' ? '1' : '0',
                    'role'                  => 'taruna',
                    'alamat'                => $item['alamat'],
                    'nip'                   => $item['nim'],
                    'tempat_lahir'          => $item['tempat_lahir'],
                    'tgl_lahir'             => $item['tanggal_lahir']
                ]);

            // if($cek_taruna > 0){
            //     $update_taruna->update([
            //         'id_mahasiswa_siakad'   => $item['id_mahasiswa'],
            //         'jenis_kelamin'         => $item['jenis_kelamin'],
            //         'tempat_lahir'          => $item['tempat_lahir'],
            //         'tanggal_lahir'         => $item['tanggal_lahir'],
            //         'nama_mahasiswa'        => $item['nama_mahasiswa'],
            //         'nim'                   => $item['nim'],
            //         'id_kelas'              => $item['id_kelas'],
            //         'nama_kelas'            => $item['nama_kelas'],
            //         'id_prodi'              => $item['id_prodi'],
            //         'nama_program_studi'    => $item['nama_program_studi'],
            //         'semester'              => $item['semesteraktif'],
            //         'agama'                 => $item['nama_agama'],
            //         'alamat'                => $item['alamat'],
            //         'foto'                  => 'https://siakad.poltekbangplg.ac.id/upload/fototaruna/'.$item['foto']
            //     ]);
            // }else{
            //     Taruna::create([
            //         'id_mahasiswa_siakad'   => $item['id_mahasiswa'],
            //         'jenis_kelamin'         => $item['jenis_kelamin'],
            //         'tempat_lahir'          => $item['tempat_lahir'],
            //         'tanggal_lahir'         => $item['tanggal_lahir'],
            //         'nama_mahasiswa'        => $item['nama_mahasiswa'],
            //         'nim'                   => $item['nim'],
            //         'id_kelas'              => $item['id_kelas'],
            //         'nama_kelas'            => $item['nama_kelas'],
            //         'id_prodi'              => $item['id_prodi'],
            //         'nama_program_studi'    => $item['nama_program_studi'],
            //         'semester'              => $item['semesteraktif'],
            //         'agama'                 => $item['nama_agama'],
            //         'alamat'                => $item['alamat'],
            //         'foto'                  => 'https://siakad.poltekbangplg.ac.id/upload/fototaruna/'.$item['foto']
            //     ]);

            //     //create akun
            //     User::create([
            //         'name'                  => $item['nama_mahasiswa'],
            //         'email'                 => $item['nim'],
            //         'password'              => Hash::make($item['nim']),
            //         'jk'                    => $item['jenis_kelamin'] == 'L' ? '1' : '0',
            //         'role'                  => 'taruna',
            //         'alamat'                => $item['alamat'],
            //         'nip'                   => $item['nim'],
            //         'tempat_lahir'          => $item['tempat_lahir'],
            //         'tgl_lahir'             => $item['tanggal_lahir']
            //     ]);
            // }
        }

        return redirect('taruna')->with(['sukses' => 'Data Berhasil Diupdate']);
    }

    public function json(){
        $taruna = Taruna::all();
        return Datatables::of($taruna)->make(true);
    }

    public function index(){
        return view('taruna.index');
    }

    public function detail($id){
        $taruna = Taruna::find($id);
        return view('taruna.detail')->with('taruna', $taruna);
    }

    public function updatetaruna(Request $request){

        // dd($request->all());

        $request->validate([
            'wali_dihubungi'    => 'required',
            'no_wali_dihubungi' => 'required',
            'hubungan_wali'     => 'required'
        ]);


        $taruna = Taruna::find($request->input('id_mahasiswa'));

        $taruna->update([

            'wali_dihubungi'    => $request->input('wali_dihubungi'),
            'no_wali_dihubungi' => $request->input('no_wali_dihubungi'),
            'hubungan_wali'     => $request->input('hubungan_wali')
        ]);

        return back()->with(['sukses' => 'Update Data Berhasil']);
    }

    public function export() {
        // dd('tes');
        return Excel::download(new TarunaExport, 'Data Taruna.xlsx');
        // return dd(Taruna::all());
    }
}
