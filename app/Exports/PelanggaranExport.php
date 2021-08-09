<?php

namespace App\Exports;

use App\Pelanggaran;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class PelanggaranExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
	return view('pelanggaran.export', [
           'data' => Pelanggaran::all()
	]);
    }
}
