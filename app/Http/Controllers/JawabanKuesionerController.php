<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DetailKuesioner;
use DB;

class JawabanKuesionerController extends Controller
{
    public function index(Request $request){
        // if($request->id){
        //     echo 'yes';
        // }else{
        //     echo 'no';
        // }

        $data = DB::table('kuesioners')
                ->join('detail_kuesioners', 'detail_kuesioners.id_kuesioner', '=', 'kuesioners.id_kuesioner')
                ->where('kuesioners.status', '1')
                ->get();

        // dd($data);

        return view('kuesioner.isikuesioner')->with('data', $data);
    }
}
