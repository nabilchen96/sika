<?php

namespace App\Exports;

use App\Taruna;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TarunaExport implements FromView
{
	public function view(): View
        {
            //export adalah file export.blade.php yang ada di folder views
            return view('taruna.export', [
                //data adalah value yang akan kita gunakan pada blade nanti
                //User::all() mengambil seluruh data user dan disimpan pada variabel data
                'data' => Taruna::all()
            ]);
        }
}
