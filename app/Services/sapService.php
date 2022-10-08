<?php

namespace App\Services;

use SAPNWRFC\Connection as SapConnection;
use SAPNWRFC\Exception as SapException;

class sapService
{
    public function __construct()
    {
        try {
            $config = [
                'ashost' => '172.21.130.208',
                'sysnr'  => '00',
                'client' => '110',
                'user'   => 'notes',
                'passwd' => 'february_02',
                'trace'  => SapConnection::TRACE_LEVEL_OFF,
            ];
            $options = [
                'use_function_desc_cache' => false,
            ];

            $this->sap = new SapConnection($config, $options);

            $this->isConnect = null;

        } catch (SapException $ex) {

            //echo 'Exception: ' . $ex->getMessage() . PHP_EOL;

            $response = (object) array();
            $status = (object) array();

            $status->code = 500;
            $status->message = "500 Internal SAP Server Error";

            $response->status = $status;

            $this->isConnect = $response;
        }
    }

    public function Z_SD0001($VENDOR_CODE="",$sDATE,$eDATE)
    {
        if($this->isConnect){
            return $this->isConnect;
        }
        
        $response = (object) array();
        $response->status = (object) array();
        try {

            $T_MATNRSELECTION = [
                [
                    'SIGN' => 'I',
                    'OPTION' => 'CP',
                    'MATNR_LOW' => 'MCS-*'
                ]
            ];

            $T_SALE_ORG = [
                [
                    'SIGN' => 'I',
                    'OPTION' => 'EQ',
                    'SALESORG_LOW' => '1000'
                ]
            ];

            $T_COMMGRP = [
                [
                    'SIGN' => 'I',
                    'OPTIONS' => 'EQ',
                    'LOW' => 'SM'
                ],
                [
                    'SIGN' => 'I',
                    'OPTIONS' => 'EQ',
                    'LOW' => 'SW'
                ]
            ];

            $T_BILLING_TYPE = [
                [
                    'SIGN' => 'I',
                    'OPTION' => 'CP',
                    'LOW' => 'ZOR*'
                ]
            ];

            $T_BILLING_CUSTOMER = [
                [
                    'SIGN' => 'I',
                    'OPTION' => 'EQ',
                    'LOW' => '1100004665'
                ],
                [
                    'SIGN' => 'I',
                    'OPTION' => 'EQ',
                    'LOW' => '1100004663'
                ],
                [
                    'SIGN' => 'I',
                    'OPTION' => 'EQ',
                    'LOW' => '1100004660'
                ],
                [
                    'SIGN' => 'I',
                    'OPTION' => 'EQ',
                    'LOW' => '1100004661'
                ],
                [
                    'SIGN' => 'I',
                    'OPTION' => 'EQ',
                    'LOW' => '1100004658'
                ],
                [
                    'SIGN' => 'I',
                    'OPTION' => 'EQ',
                    'LOW' => '1100004656'
                ],
                [
                    'SIGN' => 'I',
                    'OPTION' => 'EQ',
                    'LOW' => '1100004657'
                ],
                [
                    'SIGN' => 'I',
                    'OPTION' => 'EQ',
                    'LOW' => '1100004664'
                ],
                [
                    'SIGN' => 'I',
                    'OPTION' => 'EQ',
                    'LOW' => '1100009535'
                ]
            ];

            $T_BILLING_CREATE_DATE = [
                [
                    'SIGN' => 'I',
                    'OPTION' => 'BT',
                    'LOW' => $sDATE,
                    'HIGH' => $eDATE,
                ]
            ];

            $parameters = [
                'I_VENDOR_CODE' => $VENDOR_CODE,
                'T_MATNRSELECTION' => $T_MATNRSELECTION,
                'T_SALE_ORG' => $T_SALE_ORG,
                'T_COMMGRP' => $T_COMMGRP,
                'T_BILLING_TYPE' => $T_BILLING_TYPE,
                'T_BILLING_CUSTOMER' => $T_BILLING_CUSTOMER,
                'T_BILLING_CREATE_DATE' => $T_BILLING_CREATE_DATE
            ];

            $options = [];

            $f = $this->sap->getFunction('Z_SD0001_MSESD_THEMALL');
            $result = $f->invoke($parameters, $options);
            $this->sap->close();

            $response->status->code = 200;
            $response->status->message = "Success";
            $response->data = $result;

        } catch (SapException $ex) {

            $response->status->code = 400;
            $response->status->message = $ex->getMessage() . PHP_EOL;
            $response->data = [];

        }

        return $response;
    }
}


