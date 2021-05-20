<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PeraturanController extends Controller
{
    public function index(){
        return view('peraturan');
    }
}
