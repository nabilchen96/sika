<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;
use auth;


class TarunaKamarExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
   	 $data = DB::table('taruna_kamars')
   		->join('tarunas', 'tarunas.id_mahasiswa', '=', 'taruna_kamars.id_mahasiswa')
		->join('kamars', 'kamars.id_kamar', '=', 'taruna_kamars.id_kamar')
    		->get();

	return view('tarunakamar.export')->with('data', $data);	
    }
}
