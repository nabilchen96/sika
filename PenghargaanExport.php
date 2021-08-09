<?php

namespace App\Exports;

use App\Penghargaan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class Penghargaan implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
	return view('penghargaan.export', [
           'data' => Penghargaan::all()
	]);
    }
}
