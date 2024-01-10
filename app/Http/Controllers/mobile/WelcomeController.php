<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;

class WelcomeController extends Controller
{
    public function index(){
        return view('mobile.welcome');
    }
}
