<?php

namespace App\Exports;

use App\Penghargaan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class PenghargaanExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
        {
            //export adalah file export.blade.php yang ada di folder views
            return view('penghargaan.export', [
                //data adalah value yang akan kita gunakan pada blade nanti
                //User::all() mengambil seluruh data user dan disimpan pada variabel data
                'data' => Penghargaan::all()
            ]);
        }
}
