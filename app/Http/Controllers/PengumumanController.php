<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index(){
        return view('pengumuman');
    }

    public function detail($id){

        $data = DB::table('beritas')
                ->join('users', 'users.id', '=', 'beritas.id')
                ->select(
                    'beritas.*',
                    'users.id',
                    'users.name'
                )
                ->orderBy('beritas.created_at', 'DESC')
                ->get();

        $detailberita = $data->firstWhere('id_berita', $id);
        $recentberita = $data->whereNotIn('id_berita', $id)->take(3);
        

        return view('detailberita')
            ->with('recentberita', $recentberita)
            ->with('detailberita', $detailberita);
    }
}
