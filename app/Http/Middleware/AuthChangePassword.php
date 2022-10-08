<?php

namespace App\Http\Middleware;
use Closure;

use Illuminate\Support\Facades\Auth;

class AuthChangePassword
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
	try {
       // dd(Auth::user(), Auth::user()->remember_token);
        if(Auth::user()->isChangePassword == 1 ){
            return redirect('/change-password/'. Auth::user()->remember_token);
        }else{
            return $next($request);
        }
	} catch (\Exception $e) {

	}
    }
}
