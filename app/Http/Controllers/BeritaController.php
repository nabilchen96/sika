<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use auth;
use App\Berita;
use DB;

class BeritaController extends Controller
{
    public function index(){

        if(Auth::user()->role == 'admin'){
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
}
