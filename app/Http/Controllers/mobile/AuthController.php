<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;

class AuthController extends Controller
{
    public function login()
    {
        if(Auth::check() == true ) {
            // return redirect('mobile/welcome');
            return redirect('mobile/welcome');
        } else {
            return view('mobile.login');
        }
    }

    public function loginProses(Request $request)
    {

        $response_data = [
            'responCode' => 0,
            'respon'    => ''
        ];

        $data = [
            'email'     => $request->input('email'),
            'password'  => $request->input('password'),
        ];

        Auth::attempt($data);

        if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth
            //Login Success
            $response_data = [
                'responCode' => 1,
                'respon'    => 'OKE'
            ];

            // return view('mobile.welcome');
            return redirect('mobile/welcome');

        } else { 

            // $response_data['respon'] = 'Username atau password salah!';

            return view('mobile.login');

        }

        // return response()->json($response_data);

    }
}
