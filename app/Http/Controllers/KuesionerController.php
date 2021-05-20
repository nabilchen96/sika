<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KuesionerController extends Controller
{
    public function index(){
        return view('kuesioner.index');
    }
}
