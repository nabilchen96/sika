<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kuesioner;
use DataTables;
use App\DetailKuesioner;
use Route;

class KuesionerController extends Controller
{
    public function index(){

        $data = Kuesioner::all();
        return view('kuesioner.index')->with('data', $data);
    }

    public function store(Request $request){

        $request->validate([
            'judul_kuesioner' => 'required',
        ]);

        $data = Kuesioner::create([
            'judul_kuesioner' => $request->input('judul_kuesioner'),
            'status'          => 0
        ]);

        // $data = Kuesioner::find($data->id_kuesioner);
        // return Route::redirect('/detail-kuesioner/'.$data->id_kuesioner, 'DetailKuesionerController@index');

        return back()->with(['sukses' => 'Data Sukses Disimpan!']);
    }

    public function destroy($id){
        $data = Kuesioner::find($id);
        $data->delete();

        return back()->with(['sukses' => 'Data Berhasil Dihapus!']);
    }
}
