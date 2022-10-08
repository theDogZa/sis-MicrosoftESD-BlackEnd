<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;


ini_set("memory_limit", "512M");
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * add Log System
     * 
     * Last Update 2021-03-19 09:09:09
     * By Prasong putichanchai
     * 
     *  @return array
     */

    public function addLogSys($request,$data = [], $req = [])
    {
        
        Log::channel('logSys')->info('#log#',
            [
                'username' => @Auth::user()->username,
                'ip'=> $request->ip(),
                'date' =>  date("Y-m-d H:i:s"),
                'uri' => Route::current()->uri,
                'action' => Route::current()->action['as'],
                'parameters' => Route::current()->parameters(),
                'route' => Route::currentRouteName(),
                'methods' => Route::current()->methods,
                'request' => $req,
                'response_code'=> http_response_code(),
                'data' => $data, 
            ]
        );       
    }
}