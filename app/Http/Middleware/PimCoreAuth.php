<?php

namespace App\Http\Middleware;
use Closure;

use App\Services\AuthService;
use App\Services\EncryptionService;
use App\Services\LogsService;
use App\Services\ResponseService;

class PimCoreAuth
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
		$this->logs = new LogsService();
		$this->response = new ResponseService();
		$response = (object)[];
		try {

			$reqHeader = (object)$request->header();

			$AuthService = new AuthService();

			//--- check header 
			$chkHeader = $AuthService->_chkHeader($reqHeader);

			if ($chkHeader->status != 200) {
				$response = $this->response->_genResponse($chkHeader->status);
            	return response()->json($response);
			}

			//--- check token 
			if (!@$reqHeader->authorization){
				$response = $this->response->_genResponse(40106);
            	return response()->json($response);
			}

			$chkToken = $AuthService->_chkAccessToken($reqHeader->authorization);

			if($chkToken->status != 200){
				$response = $this->response->_genResponse($chkToken->status);
				return response()->json($response);
			}

			//--- check OwnerId 
			if($chkToken->data->OwnerId != @$reqHeader->ownerid[0]){			
				$response = $this->response->_genResponse(40108);
				return response()->json($response);
			}

			$timeNow = time();
			if($chkToken->data->time_exp < $timeNow){
				$response = $this->response->_genResponse(40107);
				return response()->json($response);
			}
			
			return $next($request);
			
		} catch (\Exception $e) {
			
			$response = $this->response->_genResponse(40101);
			return response()->json($response);
		}
    }
}
