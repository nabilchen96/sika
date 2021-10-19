<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use DB;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function changepassword(Request $request){

        DB::table('users')->where('id', auth::user()->id)->update(
            [
                'password'  => Hash::make($request->password),
            ]
        );

        return back()->with(['sukses' => 'Password berhasil diubah!']);
    }
}
