<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hukuman;
use DataTables;

class HukumanController extends Controller
{
    public function json(){
        $hukuman = Hukuman::all();
        return Datatables::of($hukuman)->make(true);
    }

    public function index(){
        return view('hukuman.index');
    }

    public function store(Request $request){
        $request->validate([
            'kategori_hukuman' => 'required',
            'hukuman'          => 'required'
        ]);

        Hukuman::create([
            'kategori_hukuman'  => $request->input('kategori_hukuman'),
            'hukuman'           => $request->input('hukuman')
        ]);

        return back()->with(['sukses' => 'Data Berhasil Disimpan']);
        
    }

    public function update(Request $request){
        $request->validate([
            'kategori_hukuman' => 'required',
            'hukuman'          => 'required',
            'id_hukuman'       => 'required'
        ]);

        $hukuman = Hukuman::find($request->input('id_hukuman'));
        $hukuman->update([
            'kategori_hukuman'  => $request->input('kategori_hukuman'),
            'hukuman'           => $request->input('hukuman')
        ]);

        return back()->with(['sukses' => 'Data Berhasil Diupdate!']);
    }

    public function destroy($id){
        $hukuman = Hukuman::find($id);
        $hukuman->delete();

        return back()->with(['sukses' => 'Data Berhasil Dihapus!']);
    }
}
