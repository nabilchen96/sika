<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use auth;
use App\Berita;
use DB;
use File;

class BeritaController extends Controller
{
    public function index(){

        if(Auth::user()->role == 'admin' || Auth::user()->role == 'pusbangkar'){
            $data = DB::table('beritas')
                    ->join('users', 'users.id', '=', 'beritas.id')
                    ->get();
        }else{
            $data = DB::table('beritas')
                    ->join('users', 'users.id', '=', 'beritas.id')
                    ->where('beritas.id', Auth::user()->id)
                    ->get();
        }

        return view('berita.index')
                ->with('data', $data);
    }

    public function create(){
        return view('berita.create');
    }

    public function store(Request $request){

        $request->validate([
            'judul_berita'  => 'required',
            'isi_berita'    => 'required',
            'kategori'      => 'required',
            'gambar_utama'  => 'required|max:512|mimes:jpg,png'
        ]);

        $file = $request->file('gambar_utama');
        $nama_file = $file->getClientOriginalName();
        $file->move('gambar_berita', $nama_file);

        Berita::create([
            'id'            => auth::user()->id,
            'judul_berita'  => $request->judul_berita,
            'isi_berita'    => $request->isi_berita,
            'gambar_utama'  => $nama_file,
            'kategori'      => $request->kategori
        ]);

        return redirect('berita')->with(['sukses' => 'Data berhasil disimpan!']);
    }

    public function edit($id){
        $data = Berita::find($id);
        return view('berita.edit')->with('data', $data);
    }

    public function update(Request $request){
        
        $request->validate([
            'judul_berita'  => 'required',
            'isi_berita'    => 'required',
            'kategori'      => 'required',
            'gambar_utama'  => 'max:512|mimes:jpg,png',
        ]);

        $data = Berita::find($request->input('id_berita'));

        if(empty($request->file('gambar_utama'))){

            $nama_file = $data->gambar_utama;

        }else{
            $file           = $request->file('gambar_utama');
            $nama_file      = $file->getClientOriginalName();

            // if($data->gambar_utama){
            //     @$path = public_path()."/gambar_berita/".$data->gambar_utama;
            //     unlink(@$path);
            // }

            $file->move('gambar_berita', $nama_file);
        }

        $data->update([
            'id'            => auth::user()->id,
            'judul_berita'  => $request->judul_berita,
            'isi_berita'    => $request->isi_berita,
            'gambar_utama'  => $nama_file,
            'kategori'      => $request->kategori
        ]);

        return redirect('berita')->with(['sukses' => 'Update Data Berhasil!']);
    }

    public function destroy($id){

        $data = Berita::find($id);
        $data->delete();

        return redirect('berita')->with(['with' => 'Data berhasil dihapus!']);
    }
}
