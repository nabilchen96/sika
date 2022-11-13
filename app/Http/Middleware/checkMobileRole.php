<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use DB;

class checkMobileRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $roles = array_slice(func_get_args(), 2);

        // dd(Auth::check());

        if(Auth::check()){

            foreach($roles as $role){
                $user = Auth::user()->role;
                if( $user == $role){
                    return $next($request);
                }
            }
        }else{
            return redirect('mobile/login');
        }

        return back()->with(['gagal' => 'Tidak dapat mengakses halaman ini!']);
    }
}
