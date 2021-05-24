<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Taruna;
use App\Alumni;
use DB;

class AlumniController extends Controller
{
    public function index(){
        return view('alumni.index');
    }

    public function json(){
        $alumni = DB::table('alumnis')
                    ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'alumnis.id_mahasiswa')
                    ->get();  

        return Datatables::of($alumni)->make(true);
    }

    public function create(){
        return view('alumni.create');
    }

    public function tarunajson(Request $request){
        $taruna = Taruna::where('id_prodi', $request->input('id_prodi'));   
        return Datatables::of($taruna)->make(true);
    }

    public function store(Request $request){

        for($i=0; $i<count($request->input('id_mahasiswa')); $i++){

            Alumni::create([
                'id_mahasiswa'  => $request->input('id_mahasiswa')[$i],
                'tgl_lulus'     => $request->tgl_lulus
            ]);
        }

        return redirect('alumni')->with(['sukses' => 'Data Sukses Disimpan']);
    }
}
