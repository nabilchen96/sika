<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlumniController extends Controller
{
    public function index(){
        return view('alumni.index');
    }

    public function json(){

    }

    public function create(){
        return view('alumni.create');
    }
}
