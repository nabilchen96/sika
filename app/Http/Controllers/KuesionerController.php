<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kuesioner;
use DataTables;

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

        Kuesioner::create([
            'judul_kuesioner' => $request->input('judul_kuesioner'),
            'status'          => 0
        ]);

        return back()->with(['sukses' => 'Data Berhasil Disimpan!']);
    }

    public function detail($id){
        return view('kuesioner.detail');
    }
}
