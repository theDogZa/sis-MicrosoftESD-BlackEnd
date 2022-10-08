<?php

namespace App\Http\Middleware;
use Closure;

use App\Services\EncryptionService;
//use Illuminate\Encryption\Encrypter;

class AuthApi
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
	        $eds = new EncryptionService();
	        $time = $eds->_decrypted($request->app_key, $request->app_secret);
	        $tn = time();
	       if ($time>$tn) {
	            return $next($request);
	        }else{
	            $response = (object)[];
	            $response->message = 'api 401 Unauthorized';
	            return response()->json($response, 401);
            
	        }
	 } catch (\Exception $e) {
	  $response = (object)[];
	            $response->message = 'api 401 Unauthorized';
	            return response()->json($response, 401);
	 }
    }
}
