<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class LogsService
{

    public function __construct()
    {
        $this->dateTime = date("Y-m-d H:i:s");
    }

    /**
     * add Log System
     * 
     * Last Update 2021-03-19 09:09:09
     * By Prasong putichanchai
     * 
     *  @return array
     */

    public function addLogSys($request, $data = [], $req = [])
    {
        if(@Auth::user()->username != null){
            $username = Auth::user()->username;
        }else{
            $username = '';
        }

        // if (@Auth::user()->username != null) {
        //     $action = 
        // }else{
        //     $action = Route::current()->action['as'];
        // }
        
        Log::channel('logSys')->info('#log#',
            [
                'username' => $username,
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

    public function addLogSys2($request, $data = [])
    {
        $data = (object)$data;
        
        if(@Auth::user()->username != null){
            $username = Auth::user()->username;
        } elseif($data->username) {
            $username = $data->username;
        }else{
            $username = '';
        }

        if (@$data->action) {
            $action = $data->action;
        }else{
            $action = Route::current()->action['as'];
        }

        if (@$data->type) {
            $type = $data->type;
        } else {
            $type = 'info';
        }

        //---view A= all , S=Admin only
        if (@$data->view) {
            $view = $data->view;
        } else {
            $view = 'A';
        }

        if (@$request->ip()) {
            $ip = $request->ip();
        } else {
            $ip = \Request::ip();
        }

        
        Log::channel('logSys')->info('#BackEnd#',
            [
                'view' => $view,
                'type' => $type,
                'username' => $username,
                'ip'=> $ip,
                'date' =>  date("Y-m-d H:i:s"),
                'uri' => Route::current()->uri,
                'action' => $action,
                'parameters' => Route::current()->parameters(),
                'route' => Route::currentRouteName(),
                'methods' => Route::current()->methods,
                'request' => $data->request,
                'response_code'=> http_response_code(),
            ]
        );

        Log::channel('logSysDev')->info(
            '#BackEnd#',
            [
                'view' => $view,
                'type' => $type,
                'username' => $username,
                'ip' => $request->ip(),
                'date' =>  date("Y-m-d H:i:s"),
                'uri' => Route::current()->uri,
                'action' => $action,
                'parameters' => Route::current()->parameters(),
                'route' => Route::currentRouteName(),
                'methods' => Route::current()->methods,
                'request' => $data->request,
                'response_code' => http_response_code(),
                'response' => $data->response,
            ]
        );
    }

    public function addApiLog( $data = [])
    {
        try {
        
            if($data['type'] == 'info'){
                Log::channel('logApi')->info('#log#', [$data]);
            }elseif($data['type'] == 'warning'){
                Log::channel('logApi')->warning('warning', [$data]);
            }else{
                Log::channel('logApi')->error('#log#',[$data]);
            }

        } catch (\Exception $e) {
            
            $arrData['action'] = "LogsService : addApiLog";
            $arrData['response'] = $e->getMessage();
            Log::channel('logApi')->error('#log#',[$arrData]);
        }  
    }


    // public function _addApiLog($type = 'info',$method = '',$requestUid = '',$request= [],$response = [])
    // {
    //     try {
    //         $request = (object)$request;
    //         $requestHeader = (object)[];
    //         if(method_exists($request, 'header')){
    //             $requestHeader = (object)$request->header();
    //         }

    //         if (method_exists($request, 'all')) {
    //             $requestAll = (object)$request->all();
    //         }else{
    //             $requestAll = (object)$request;
    //         }

    //         if($type=='error'){
    //             Log::channel('logApi')->error('error',['response'=> @$response]);
    //         }elseif($type== 'warning'){
    //             //Log::channel('logApi')->warning('warning', ['requestUid' => @$requestUid]);
    //         }

    //     } catch (\Exception $e) {
    //         Log::channel('logApi')->error('requestUid : '.$requestUid .' error : '. $e->getMessage());
    //     }  
    // }


    protected function logEncrypt($str="")
    {
        return Crypt::encryptString(json_encode($str));
    }

    protected function logDecrypt($str="")
    {
        return Crypt::decryptString($str);
    }

}