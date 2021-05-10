<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\User;
use App\Taruna;


class TarunaController extends Controller
{
    public function updatetarunaserver(){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost/project/siakadpoltekbang-backup/public/api/taruna");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, 
         array('Accept: application/json', 'Authorization: Bearer 1|KoFesST4tV889DCcWoCBLmcm0YJuXqKFLIEQnggv')
        );
      
        $result = curl_exec($ch);
        $data   = json_decode($result, true);

        foreach($data as $item){
            //jika data ada maka update
            $cek_taruna     = Taruna::where('id_mahasiswa_siakad', $item['id_mahasiswa'])->count();
            $update_taruna  = Taruna::where('id_mahasiswa_siakad', $item['id_mahasiswa'])->first();

            if($cek_taruna > 0){
                $update_taruna->update([
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
                ]);
            }else{
                Taruna::create([
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
                ]);
            }
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
        $request->validate([
            'foto'              => 'required',
            'wali_dihubungi'    => 'required',
            'no_wali_dihubungi' => 'required',
            'hubungan_wali'     => 'required'
        ]);


        $taruna = Taruna::find($request->input('id_mahasiswa'));

        if(empty($request->file('foto'))){
            $foto       = $taruna->foto;
        }else{
            $foto       = $request->file('foto');
            $nama_foto  = $foto->getClientOriginalName();
            $foto->move('file_upload', $foto->getClientOriginalName());

            // $path       = public_path() . "/file_upload/" . $taruna->foto;
            // unlink($path);
        }

        $taruna->update([
            'foto'              => $nama_foto,
            'wali_dihubungi'    => $request->input('wali_dihubungi'),
            'no_wali_dihubungi' => $request->input('no_wali_dihubungi'),
            'hubungan_wali'     => $request->input('hubungan_wali')
        ]);

        return back()->with(['sukses' => 'Update Data Berhasil']);
    }
}
