<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7;

class GuzzleHttp
{
    public function post($req = [])
    {
        $req = (object)$req;

        try {
            
            $client = new Client([
                'curl' => [
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_SSL_VERIFYHOST => false
                ],
            ]);

            $res = $client->post($req->url, [
                'headers' => (array)$req->headers,
                'body' => json_encode($req->body),
                'http_errors' => false
            ]);

            // $request = new Request(
            //         "POST",
            //         $req->url,
            //         $req->headers,
            //         json_encode($req->body),

            //     );
            //   $res = $client->send($request);
            // dd($req->url, (array)$req->headers, json_encode($req->body), $res->getBody()->getContents());

            $response['code'] = $res->getStatusCode();
            $response['data'] = json_decode($res->getBody()->getContents());

        } catch (ConnectException  $e) {

            if($e->getCode() == 0){
                $response['code'] =  $e->getHandlerContext()['errno'];
            } else {
                $response['code'] = $e->getCode();
            }
            $response['message'] = $e->getMessage();
            $response['data'] = $e;
        } catch (ClientException  $e) {
            
            $response['code'] = $e->getCode();
            $response['message'] = $e->getMessage();
            $response['data'] = json_decode($e->getResponse()->getBody()->getContents());
        }
        
        return $response;
    }

    public function get($req = [])
    {
        $req = (object)$req;

        try {
            $client = new Client([
                'curl' => [
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false
                ],
            ]);

            $res = $client->get($req->url, [
                'headers' => (array)$req->headers,
                'query' => (array)$req->body
            ]);

            $response['code'] = $res->getStatusCode();
            $response['data'] = $res->getBody()->getContents();
        } catch (ConnectException  $e) {
            $response['code'] = $e->getCode();
            $response['message'] = $e->getMessage();
            $response['data'] = $e;
        }
        
        return $response;
    }

    public function put($req = [])
    {
        $req = (object)$req;

        try {

            $client = new Client([
                'curl' => [
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false
                ],
            ]);

            $request = new Request(
                "PUT",$req->url,$req->headers, $req->body
            );

            $res = $client->send($request);
            $response['code'] = $res->getStatusCode();
            $response['data'] = $res;
        } catch (ClientException  $e) {
            $response['code'] = $e->getCode();
            $response['data'] = $e;
            $response['message'] = $e->getMessage();
        }
        return $response;
    }
}