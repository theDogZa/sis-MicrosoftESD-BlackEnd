<?php

namespace App\Services;

use App\Services\EncryptionService;

class AuthService
{
    protected $tiemAdjust = 3600; //43200--- 8h

    public function __construct()
    {

    }

    public function _chkHeader($data = [])
    {
        $response = (object)[];
        $data = (object)$data;

        if (!@$data->ownerid[0] || !@$data->requestuid[0] || !@$data->timestamp[0]) {

            $response->status = 40101; 
            return $response;
        }

        $chkTime = $this->_chkTime($data->timestamp[0]);

        if (!$chkTime) {
            $response->status = 40102;
            return $response;
        }

        $response->status = 200;
        return $response;
    }

    /**
     * Generator AccessToken to SIS Payment
     * 
     * Last Update 2021-09-09 09:09:09
     * By Prasong putichanchai
     * 
     *  @return array
     */
    public function _genAccessToken($appKey = "", $id = "")
    {

        $response = [];
        $accessToken = "";
        $timeAccessToken = time() + $this->tiemAdjust;

        $objToken["id"] =  $id;
        $objToken["time_exp"] = $timeAccessToken;
        $objToken["app_key"] = $appKey;

        $Encryption = new EncryptionService();
        $accessToken = $Encryption->_encrypted(json_encode($objToken));

        //$d = $Encryption->_decrypted($accessToken);

        $response["accessToken"] = $accessToken;
        $response["expiresIn"] = $timeAccessToken;
        // $response["strlen"] = strlen($accessToken);
        // $response["d"] = $d;

        return $response;
    }

    public function _chkAccessToken($accessToken = "")
    {
        $response = (object)[];

        $arrToken = explode(' ', $accessToken[0]);

        $typeToken = @$arrToken[0];
        $token = @$arrToken[1];

        if (!$typeToken && !$token) {
            
            $response->status = 40104;
            return $response;
        }

        if($typeToken != 'Bearer'){
            $response->status = 40105;
            return $response;
        }
        
        $Encryption = new EncryptionService();
        $dataToken = $Encryption->_decrypted($token);

        if(!$dataToken){
            $response->status = 40106;
            return $response;
        }

        if(!@$dataToken['id'] || !@$dataToken['time_exp'] || !@$dataToken['app_key']){
            $response->status = 40106;
            return $response;
        }
        $response->data = (object)[];

        $response->status = 200;
        $response->data->OwnerId = md5($dataToken['id']);
        $response->data->time_exp = $dataToken['time_exp'];

        return $response;
    }

    private function _chkTime($timestamp)
    {
        $timeNow = time();

        //----fix test by sis
        if ($timestamp == 'sis-time-test') {
            $timestamp = $timeNow;
        }

        if ($timeNow < (int) $timestamp + 60 && $timeNow > (int) $timestamp - 60) {
            return true;
        } else {
            return false;
        }
    }

}