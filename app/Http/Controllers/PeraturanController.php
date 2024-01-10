<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pelanggaran;
use App\Penghargaan;

class PeraturanController extends Controller
{
    public function index(){
        $pelanggaran = Pelanggaran::all();
        $penghargaan = Penghargaan::all();
        return view('peraturan')
            ->with('penghargaan', $penghargaan)
            ->with('pelanggaran', $pelanggaran);
    }
}
