<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Http;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\User; //tambahkan model user
use DB;

class AuthController extends Controller
{

    //setting data pertama kali
    public $sso_url = 'http://127.0.0.1:8000';
    public $app = 'Sistem Informasi Ketarunaan dan Alumni (SIKA)';
    public $url = 'http://127.0.0.1:9000';
    public $home = 'home';

    public function login(){

        //jika membawa data yang dibutuhkan maka lakukan login
        if(request('data')){
            //cek apakah token ada
            //jika ada lanjutkan dan hapus token
            //jika tidak ada kembalikan ke halaman dashboard sso
            
            $data = json_decode(request('data'));

            if(@$data->email && @$data->token_sso){

                $pesan = Http::get($this->sso_url.'/check-token', [
                    'token_sso' => $data->token_sso, 
                    'email'     => $data->email
                ]);
    
                $pesan = json_decode($pesan, true);

                //jika token ada
                if($pesan == "token ada"){
    
                    //cari user
                    $user = User::where('email', $data->email)->first();
    
                    if(@Auth::loginUsingId($user->id)){
                        
                        //untuk mengirim log aktivitas
                        // $data = Http::get($this->sso_url.'/send-token-back', [
                        //     'token_sso' => $data->token_sso,
                        //     'email'     => $data->email, 
                        //     'app'       => $this->app,
                        // ]);
    
                        return redirect($this->home);
            
                    }else{
        
                        return redirect()->away($this->sso_url.'/home?pesan=Anda belum terdaftar di aplikasi tujuan!');
                    }
                
                //jika token tidak ada
                }else{
    
                    return redirect()->away($this->sso_url.'/home');
                }
            }else{
                return redirect()->away($this->sso_url.'/home');
            }

        }else{

            return redirect()->away($this->sso_url.'/check-user-login?app='.$this->app.'&url='.$this->url);
        }
    }

    public function logout(){

        Http::get($this->sso_url.'/send-logout', [
            'email'     => Auth::user()->email, 
            'app'       => $this->app,
        ]);

        Auth::logout();

        return redirect('/');
    }
}
