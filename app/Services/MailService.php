<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;

class MailService
{
    public function __construct()
    {
        
        $this->url = config('api.Microsoft.url');
        $this->dateTime = date('YmdHis'); //YYYYMMDDhhmmss
    }

    public function sentLicense($data)
    {

        $response = (object) array();
        $response->status = (object) array();
        $data = (array)$data;

        try {

            $arrmailTo = $data['mailTo'];
            $subject = trans('mail.sentLicense.subject')." ".$data['nameItem'];

            $formMail = config('api.mail.sent_license.form');
            $toMail = $arrmailTo;
            $isSend = Mail::send('_emails.sent_license', $data, function ($message) use ($formMail, $toMail, $subject) {
                $message->from($formMail);
                $message->to($toMail);
                $message->subject($subject);
            });

            $response->status->code = 200;
            $response->status->message = 'Success';
            $response->data = $isSend;

        } catch (\Exception $ex) {
            $response->status->code = 503;
            $response->status->message = 'Error : ' . $ex->getMessage();
            $response->data = [];
        }

        return $response;
    }

    public function sentLicenseAdmin($data){
        $response = (object) array();
        $response->status = (object) array();
        $data = (array)$data;

        try {

            $arrmailTo = $data['mailTo'];
            $subject =  trans('mail.sentLicense.subject')." ".$data['nameItem'];

            $formMail = config('api.mail.sent_license_admin.form');
            $toMail = $arrmailTo;
            $isSend = Mail::send('_emails.sent_license_admin', $data, function ($message) use ($formMail, $toMail, $subject) {
                $message->from($formMail);
                $message->to($toMail);
                $message->subject($subject);
            });

            $response->status->code = 200;
            $response->status->message = 'Success';
            $response->data = $isSend;

        } catch (\Exception $ex) {
            $response->status->code = 503;
            $response->status->message = 'Error : ' . $ex->getMessage();
            $response->data = [];
        }

        return $response;
    }
}


