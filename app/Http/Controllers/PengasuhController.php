<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use DataTables;

class PengasuhController extends Controller
{

    public function json(){
        $pengasuh   = User::where('role', 'pengasuh');
        return Datatables::of($pengasuh)->make(true);
    }

    public function index(){
        return view('pengasuh.index');
    }

    public function create(){
        return view('pengasuh.create');
    }

    public function store(Request $request){
        $request->validate([
            'nip'           => 'required',
            'nama_pengasuh' => 'required',
            'jk'            => 'required',
            'notelp'        => 'required',
            'alamat'        => 'required',
            'password'      => 'required',
            'email'         => 'required',
            'tempat_lahir'  => 'required',
            'tgl_lahir'     => 'required'
        ]);

        User::create([
            'nip'           => $request->input('nip'),
            'name'          => $request->input('nama_pengasuh'),
            'jk'            => $request->input('jk'),
            'no_telp'       => $request->input('notelp'),
            'alamat'        => $request->input('alamat'),
            'email'         => $request->input('email'),
            'password'      => Hash::make($request->input('password')),
            'role'          => 'pengasuh',
            'tempat_lahir'  => $request->input('tempat_lahir'),
            'tgl_lahir'     => $request->input('tgl_lahir')
        ]);

        return redirect('pengasuh')->with(['sukses' => 'Data Berhasil Disimpan!']);
    }

    public function edit($id){
        $pengasuh = User::find($id);
        return view('pengasuh.edit')->with('pengasuh', $pengasuh);
    }

    public function update(Request $request, $email, $nip){
        $request->validate([
            'nip'           => 'required|unique:users,nip,'.$nip.',nip',
            'nama_pengasuh' => 'required',
            'jk'            => 'required',
            'tempat_lahir'  => 'required',
            'tgl_lahir'     => 'required',
            'notelp'        => 'required',
            'alamat'        => 'required',
            'email'         => 'required|unique:users,email,'.$email.',email',
        ]);

        
        $user = User::find($request->input('id'));
        $user->update([
            'nip'           => $request->input('nip'),
            'name'          => $request->input('nama_pengasuh'),
            'jk'            => $request->input('jk'),
            'no_telp'       => $request->input('notelp'),
            'alamat'        => $request->input('alamat'),
            'email'         => $request->input('email'),
            'tempat_lahir'  => $request->input('tempat_lahir'),
            'tgl_lahir'     => $request->input('tgl_lahir')
        ]);

        return redirect('pengasuh')->with(['sukses' => 'Data Berhasil Diupdate!']);
    }

    public function destroy($id){
        $pengasuh  = User::find($id);
        $pengasuh->delete();

        return redirect('pengasuh')->with(['sukses' => 'Data Berhasil Dihapus']);
    }
}
