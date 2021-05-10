<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pelanggaran;
use DataTables;
use App\Kamar;
use Illuminate\Support\Facades\Validator;

class PelanggaranController extends Controller
{
    public function json(){
        $pelanggaran = Pelanggaran::all();
        return Datatables::of($pelanggaran)->make(true);
    }

    public function index(){
        return view('pelanggaran.index');
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'pelanggaran'           => 'required',
            'kategori_pelanggaran'  => 'required',
            'submit'                => 'required',
            'poin_pelanggaran'      => 'required'
        ]);

        if($validator->fails()){
            return back()
                ->with(['submit' => $request->input('submit')])
                ->withErrors($validator, 'data');
        }

        Pelanggaran::create([
            'pelanggaran'           => $request->input('pelanggaran'),
            'kategori_pelanggaran'  => $request->input('kategori_pelanggaran'),
            'poin_pelanggaran'      => $request->input('poin_pelanggaran')
        ]);

        return back()->with(['sukses' => 'Data Berhasil Ditambahkan']);
    }

    public function update(Request $request){

        $validator = Validator::make($request->all(), [
            'pelanggaran'           => 'required',
            'kategori_pelanggaran'  => 'required',
            'submit'                => 'required',
            'poin_pelanggaran'      => 'required',
            'id_pelanggaran'        => 'required'
        ]);

        if($validator->fails()){
            return back()
                ->with(['submit' => $request->input('submit')])
                ->withErrors($validator, 'data');
        }

        $pelanggaran = Pelanggaran::find($request->input('id_pelanggaran'));
        $pelanggaran->update([
            'pelanggaran'           => $request->input('pelanggaran'),
            'kategori_pelanggaran'  => $request->input('kategori_pelanggaran'),
            'poin_pelanggaran'      => $request->input('poin_pelanggaran')
        ]);

        return back()->with(['sukses' => 'Data Berhasil Ditambahkan']);
    }

    public function destroy($id){
        $pelanggaran = Pelanggaran::find($id);
        $pelanggaran->delete();

        return back()->with(['sukses' => 'Data Berhasil Dihapus']);
    }
}
