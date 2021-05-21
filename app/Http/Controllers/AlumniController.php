<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Taruna;

class AlumniController extends Controller
{
    public function index(){
        return view('alumni.index');
    }

    public function json(){

    }

    public function create(){
        return view('alumni.create');
    }

    public function tarunajson(Request $request){
        $taruna = Taruna::where('id_prodi', $request->input('id_prodi'));   
        return Datatables::of($taruna)->make(true);
    }
}
