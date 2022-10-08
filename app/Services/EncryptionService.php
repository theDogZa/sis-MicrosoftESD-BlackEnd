<?php

namespace App\Services;

class EncryptionService
{
    public function __construct()
    {
        $this->encryptMethod = "AES-256-CBC";
        $this->secretIv = "sisthai-payment-2021";
        $this->secretKey = "395f426c0e5bd914375837483b791d80854dd9a19dd86fd189e94ccade60c5b8";
    }
    function _encrypted($string)
    {
        $obj = json_decode($string);
        $string = $obj->time_exp . ":".$obj->app_key.":". $obj->id;

        $output = false;

        $key = hash('sha256', $this->secretKey);
        $iv = substr(hash('sha256', $this->secretIv), 0, 16);

        $output = openssl_encrypt($string, $this->encryptMethod, $key, 0, $iv);
        $output = base64_encode($output);
        $output = $this->setEnTokenFormat($output,"-",9);

        return $output;
    }

    function _decrypted($string)
    {
        $string = $this->setDeTokenFormat($string, "-", 9);
        $output = false;

        $key = hash('sha256', $this->secretKey);
        $iv = substr(hash('sha256', $this->secretIv), 0, 16);

        $string = base64_decode($string);
        $output = openssl_decrypt($string, $this->encryptMethod, $key, 0, $iv);
        
        if($output){ 
            $output = explode(':', $output);

            $outputArr["id"] =  $output[2];
            $outputArr["time_exp"] = $output[0];
            $outputArr["app_key"] = $output[1];

            $output = $outputArr;
        }

        return $output;
    }

    function setEnTokenFormat($oldstr, $str_to_inser, $pos){
        $output = "";
        $oldstr = substr($oldstr, 0, -1);
        $arrStr = str_split($oldstr, $pos);
        krsort($arrStr);
        $output = implode($str_to_inser, $arrStr);
        return $output;
    }

    function setDeTokenFormat($oldstr, $str_to_inser, $pos)
    {
        $arrStr = explode( $str_to_inser, $oldstr);
        krsort($arrStr);
        $output = implode('', $arrStr);
        return $output;
    }
}