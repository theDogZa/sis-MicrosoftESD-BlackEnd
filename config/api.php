<?php

return [

    'SAP' => [
        'ip_host' => env('SAP_HOST', null),
        'sysnr'  => env('SAP_SYSNR', null),
        'client' => env('SAP_CLIENT', null),
        'user'   => env('SAP_USER', null),
        'password' => env('SAP_PASSWORD', null),
        'get_data' => [
            'VENDOR_CODE' => '1100000136',
            'CUSTOMER_CODE' =>[
                '1100004656',
                '1100004657',
                '1100004658',
                '1100004660',
                '1100004661',
                '1100004663',
                '1100004664',
                '1100004665',
                '1100009535'
            ]
        ]
    ],
    'Microsoft' => [
        'url' => env('MS_HOST', null),
        'service' => [
            'prepare' => 'MS_ESD/GetToken_Notes_Pre.php',
            'getLicense' => 'MS_ESD/GetToken_Notes_Act.php'
        ],
        'secreteKey' => env('MS_SECRETE_KEY', null),
        'resellerId' => env('MS_RESELLER_ID', null),
        'storeId' => env('MS_STORE_ID', null),
    ],
    'SMS' => [
        'url' => env('SMS_HOST', null),
        'service' => [
            'SingleSMS' => 'molinkservice2017/sms.asmx/SingleSMS',
            'soapSMS' => 'molinkservice2017/sms.asmx?WSDL'
        ],
    ],

    'mail' => [
        'sent_license' => [
            'isSend' => false,
            'form' => 'noReply@sisthai.com',
            'to' => 'prasong@sisthai.com'
        ],
        'sent_license_admin' => [
            'isSend' => false,
            'form' => 'noReply@sisthai.com',
            'to' => 'prasong@sisthai.com'
        ],
        'not_set_sku' => [
            'isSend' => false,
            'form' => 'prasong@sisthai.com',
            'to' => 'prasong@sisthai.com'
        ]
    ],
];


/** 
 * SiS ESD
 *
 * Modify/Update BY PRASONG PUTICHANCHAI
 * 
 * Latest Update : 29/12/2021 15:00
 * Version : ver.0.00.01
 *
 */