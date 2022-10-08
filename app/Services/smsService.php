<?php

namespace App\Services;

use App\Services\GuzzleHttp;
use App\Models\Config;
use Illuminate\Support\Facades\Log;

class SmsService
{
    public function __construct()
    {
        $this->GuzzleHttp = new GuzzleHttp;

        $this->url = config('api.SMS.url');
        $this->dateTime = date('YmdHis'); //YYYYMMDDhhmmss
        $this->username = Config::select('val')->where('code', 'USMS')->first()->val;
        $this->sender = Config::select('val')->where('code', 'SSMS')->first()->val;
        $this->password = Config::select('val')->where('code', 'PSMS')->first()->val;

    }

    public function sentLicense($data)
    {

        $response = (object) array();
        $response->status = (object) array();
        $data = (object)$data;

        try {

            $text = Config::select('val')->where('code', 'TSMS')->first()->val;

            $text =  str_replace("###", trim($data->nameItem, " "),$text);
            $text =  str_replace("XXX", trim($data->license, " ") ,$text);

            $arrReq = (object)array();

            $arrHeader = array();
            $params = array();
            $params['username'] = $this->username;
            $params['password'] = $this->password;
            $params['txtMobile'] = '66'. substr($data->smsTo, 1, 10);
            $params['sender'] = $this->sender;
            
            $params['txtSMS'] = $text;

            $arrReq->url = $this->url . config('api.SMS.service.SingleSMS');
            $arrReq->headers = $arrHeader;
            $arrReq->body = $params;

            $apiResponse = (object)$this->GuzzleHttp->get($arrReq);

            Log::info('info: sms : sentLicense : ', ['params'=> $params,'apiResponse' => $apiResponse]);

            if ($apiResponse->code == 200) {
        
                $xml = simplexml_load_string($apiResponse->data);
                $json = json_encode($xml);
                $objReturn = (object)json_decode($json, TRUE);

                $response->status->code = 200;
                $response->status->message = 'Success';
                $response->data = $objReturn;
            } else {
                $response->status->code = $apiResponse->code;
                $response->status->message = 'error';
                $response->data = $apiResponse->data;
            }

        } catch (\Exception $ex) {
            $response->status->code = 503;
            $response->status->message = 'Error : ' . $ex->getMessage();
            $response->data = [];
        }

        return $response;
    }
}


