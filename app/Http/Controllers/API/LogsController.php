<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Services\LogsService;

class LogsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->logs = new LogsService();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function addLogs(Request $request)
    {

        $reqHeader = (object)$request->header();

        $response = (object) array();
        $response->status = (object) array();

        try {

            Log::channel('logSys')->info(
                '#FrontEnd#',
                $request->all()
            );

            Log::channel('logSysDev')->info(
                '#FrontEnd#',
                $request->all()
            );

            $response->status->code = 200;
            $response->status = 'Success with response body.';
            $response->data = [];

        } catch (\Exception $e) {
            
            $response->status->code = '503';
            $response->status->message = $e->getMessage();
        }

        return response()->json($response);    
    }
}