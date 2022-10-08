<?php

namespace App\Services;

use App\Services\GuzzleHttp;

class MicrosoftService
{
    public function __construct()
    {
        $this->GuzzleHttp = new GuzzleHttp;
        $this->url = config('api.Microsoft.url');
        $this->dateTime = date('YmdHis'); //YYYYMMDDhhmmss
    }

    public function prepare($data = [])
    {
        
        $response = (object) array();
        $response->status = (object) array();

        $data = (object)$data;
        try {

            $arrReq = (object)array();

            $arrHeader = array();
            $params = array();
            $params['SiS'] = config('api.Microsoft.secreteKey');
            $params['pono'] = $data->poNumber;
            $params['poitem'] = $data->poItem;
            $params['vdarticle'] = $data->vendorArticle;
            $params['qty'] = $data->qty;
            $params['nocache'] = $this->dateTime;

            $arrReq->url = $this->url . config('api.Microsoft.service.prepare');
            $arrReq->headers = $arrHeader;
            $arrReq->body = $params;

            $apiResponse = (object)$this->GuzzleHttp->get($arrReq);

            if ($apiResponse->code == 200) {

                $response->status->code = 200;
                $response->status->message = 'Success';
                $response->data = $apiResponse->data;

            }else{
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

    public function getLicense($data)
    {

        $response = (object) array();
        $response->status = (object) array();
        $data = (object)$data;
        try {

            $arrReq = (object)array();
            $arrHeader = array();
            $params = array();
            $params['SiS'] = config('api.Microsoft.secreteKey');
            $params['pono'] = $data->poNumber;
            $params['poitem'] = $data->poItem;
            $params['resellerId'] = config('api.Microsoft.resellerId');
            $params['storeid'] = config('api.Microsoft.storeId');
            $params['nocache'] = $this->dateTime;

            $arrReq->url = $this->url . config('api.Microsoft.service.getLicense');
            $arrReq->headers = $arrHeader;
            $arrReq->body = $params;

            $apiResponse = (object)$this->GuzzleHttp->get($arrReq);

            //dd($arrReq->url,$params,$apiResponse->code, $apiResponse->data);

            if ($apiResponse->code == 200) {
                $response->status->code = 200;
                $response->status->message = 'Success';
                $response->data = $apiResponse->data;
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


