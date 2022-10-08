<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\MicrosoftService;
use App\Services\MailService;
use App\Services\SmsService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Order;
use App\Models\Config;
use App\Models\OrderItem;
use App\Models\Inventory;

use App\Services\LogsService;

class MicrosoftController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->logs = new LogsService();
        $this->Microsoft = new MicrosoftService();
        $this->EMail = new MailService();
        $this->SMS = new SmsService();

        $this->Order = new Order();
        $this->OrderItem = new OrderItem();
        $this->Inventory = new Inventory();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function getLicensesByOrder(Request $request)
    {
        $reqHeader = (object)$request->header();

        $response = (object) array();
        $response->status = (object) array();

        $resEmail = "";
        $resEmailAdmin = "";
        $isLicenses = false;

        $arrResponseAll = [];

        try {
            $orderId = $request->orderId;
            $order = $this->Order::where('id', $orderId)->first();
            $orderItems = $this->OrderItem::where('order_id',$orderId)->get();

            $arrReq = [];
            $arrReq['orderId'] = $orderId;
            $arrRes['order'] = $order;
            $arrRes['orderItems'] = $orderItems;
            
            $arrLog = [];
            $arrLog['type'] = 'info';
            $arrLog['view'] = 'S';
            $arrLog['action'] = 'orders.GetData';
            $arrLog['request'] = $arrReq;
            $arrLog['response'] = $arrRes;
            $this->logs->addApiLog($arrLog);
            Log::info('info: MicrosoftController:getLicensesByOrder : ', ['orderItems' => $orderItems, 'orderId'=>$orderId,'r'=>$request]);
            $arrResponseAll['getOrder'] = $arrLog;

            foreach($orderItems as $orderItem){
                //Log::info('info: MicrosoftController:getLicensesByOrder : ', ['prepare' => $orderItem]);
                $orderQty = 1;
                $poNo = $orderItem->Inventory->Billing->po_no;
                $poQty = $orderItem->Inventory->Billing->sale_count;
                $poItemNo = $orderItem->Inventory->po_item_no;
                $vendorArticle = trim($orderItem->Inventory->Billing->vendor_article);
                
                //--- fixtest
                //$vendorArticle = 'ABC-77777';
                 //$poQty = $orderItem->Inventory->Billing->qty;

                $data['qty'] = $orderQty;
                $data['poNumber'] = $poNo;
                $data['poItem'] = $poItemNo;
                $data['vendorArticle'] = $vendorArticle;

                $apiResponse = $this->Microsoft->prepare($data);

                $arrData = explode("=", $apiResponse->data);
                $arrLog = [];
                $arrLog['type'] = 'info';
                $arrLog['action'] = 'Microsoft.Prepare';
                $arrLog['request'] = $data;
                $arrLog['response'] = $apiResponse;

                $this->logs->addApiLog($arrLog);
                $arrResponseAll['MsPrepare'] = $arrLog;
                Log::info('info: MicrosoftController:getLicensesByOrder : Microsoft Prepare', ['request' => $data, 'response' => $apiResponse]);

                if(@$arrData[1]==200){

                    $apiResponseLic = $this->Microsoft->getLicense($data);
                    $arrLog = [];
                    $arrLog['type'] = 'info';
                    $arrLog['action'] = 'Microsoft.getLicense';
                    $arrLog['request'] = $data;
                    $arrLog['response'] = $apiResponseLic;

                    $arrDataLicenseLog = explode("#", $apiResponseLic->data);
                    $apiResponseLic->data = $arrDataLicenseLog[0];
                    $this->logs->addApiLog($arrLog);
                    $arrResponseAll['MsGetLicense'] = $arrLog;
                    Log::info('info: MicrosoftController:getLicensesByOrder : Microsoft getLicense', ['request' => $data, 'response' => $apiResponseLic]);

                    if($apiResponseLic->status->code == 200){

                        $arrDataLicense = explode("|", $apiResponseLic->data);
                        if(@$arrDataLicense[2]){
                            $isLicenses = true;
                            $License = explode("#", $arrDataLicense[2])[0]; //License

                            $response->status->code = 200;
                            $response->status->message = 'Success';
                            $response->data = $License;
                        }else{
                            $response->status->code = 403;
                            $response->status->message = 'error : '.$apiResponseLic->data;
                            $response->data = [];
                        }

                    }else{

                        $response->status->code = $apiResponseLic->status->code;
                        $response->data = [];
                    }

                    if($isLicenses){

                        $showLicense = '';
                        $arrDataLicense = explode("-", $License);
                        if(isset($arrDataLicense)){
                            foreach($arrDataLicense AS $k => $v){
                                if($k != 0 && $k != count($arrDataLicense)-1){
                                $nv = '-xxxxx';
                                }elseif($k == count($arrDataLicense)-1){
                                $nv ='-'.$v;
                                }else{
                                $nv = $v;
                                }
                                $showLicense .= $nv;
                            }
                        }

                        //-----update to OrderItem
                        $OrderItem = $this->OrderItem::find($orderItem->id);
                        $OrderItem->license_key = $License;
                        $OrderItem->license_at = date("Y-m-d H:i:s");
                        $OrderItem->updated_uid = $order->sale_uid;
                        $OrderItem->updated_at = date("Y-m-d H:i:s");
                        $OrderItem->save();

                        // $arrLog = [];
                        // $arrLog['type'] = 'info';
                        // $arrLog['action'] = 'MicrosoftController : getLicensesByOrder : emailSentLicense';
                        // $arrLog['request'] = $eMailData;
                        // $arrLog['response'] = $resEmail;

                        // $arrResponseAll['updateOrderItem'] = $arrLog;

                        $eMailData = (object)[];
                        $eMailData->customerName = $order->customer_name;
                        $eMailData->mailTo = $order->email;
                        $eMailData->serial = $orderItem->Inventory->serial;
                        $eMailData->license = $License;
                        $eMailData->nameItem = $orderItem->Inventory->Billing->material_desc;
                        $eMailData->receiptNo = $order->receipt_no;
                        $eMailData->partNo = $order->path_no;
                        //$eMailData->description = $orderItem->Inventory->Billing->material_desc;
                        $eMailData->quantity = 1;
                        $eMailData->dateTime = $order->sale_at;
                        $eMailData->showLicense = $showLicense;
                        $resEmail = $this->EMail->sentLicense($eMailData);

                        $arrLog = [];
                        $arrLog['type'] = 'info';
                        $arrLog['action'] = 'email.send';
                        $arrLog['request'] = $eMailData;
                        $arrLog['response'] = $resEmail;
                        $arrResponseAll['sentEmail'] = $arrLog;

                        Log::info('info: MicrosoftController:getLicensesByOrder : Microsoft sentEmail', ['request' => $eMailData, 'response' => $resEmail]);

                        $arrEmail = Config::select('val')->where('code', 'AEMAIL')->first();
                        $eMailData->mailTo = explode(",", $arrEmail->val);
                        $resEmailAdmin = $this->EMail->sentLicenseAdmin($eMailData);

                        $arrLog = [];
                        $arrLog['type'] = 'info';
                        $arrLog['action'] = 'email.send admin';
                        $arrLog['request'] = $eMailData;
                        $arrLog['response'] = $resEmailAdmin;
                        $arrResponseAll['sentEmailAdmin'] = $arrLog;

                        Log::info('info: MicrosoftController:getLicensesByOrder : Microsoft sentEmailAdmin', ['request' => $eMailData, 'response' => $resEmailAdmin]);

                        //---- sent sms
                        $smsData = (object)[];
                        $smsData->smsTo = $order->tel;
                        $smsData->serial = $orderItem->Inventory->serial;
                        $smsData->license = $License;
                        $smsData->nameItem = $orderItem->Inventory->Billing->material_desc;
                        $smsData->dateTime = date("Y-m-d H:i");
                        $resSms = $this->SMS->sentLicense($smsData);

                        //------fix test
                        // $resSms = (object)[];
                        // $resSms->status =(object)[];
                        // $resSms->status->code = 200;

                        $arrLog = [];
                        $arrLog['type'] = 'info';
                        $arrLog['action'] = 'SMS.send';
                        $arrLog['request'] = $smsData;
                        $arrLog['response'] = $resSms;
                        $arrResponseAll['sentSMS'] = $arrLog;

                        Log::info('info: MicrosoftController:getLicensesByOrder : Microsoft sentSMS', ['request' => $smsData, 'response' => $resSms]);
                    }
                }else{
                    Log::error('Error: MicrosoftController:getLicensesByOrder : Microsoft Prepare', ['request' => $data, 'response' => $apiResponse->data]);
                }
            }

            $arrLog = [];
            $arrLog['type'] = 'info';
            $arrLog['action'] = 'orders.getLicenses';
            $arrLog['request'] = $request->all();
            $arrLog['response'] = true;
            $arrResponseAll['getLicenses'] = $arrLog;

            $response->status->code = '200';
            $response->status->message = 'Successful';
            $response->data = ['logs' => $arrResponseAll];
            //Log::info('Successful: MicrosoftController:getLicensesByOrder : ', ['resEmail' => $resEmail, 'resEmailAdmin' => $resEmailAdmin]);

        } catch (\Exception $e) {
            
            $response->status->code = '503';
            $response->status->message = $e->getMessage();

            $arrLog = [];
            $arrLog['type'] = 'error';
            $arrLog['action'] = 'orders.getLicenses';
            $arrLog['request'] = $request;
            $arrLog['response'] = $e->getMessage();
            $arrResponseAll['getLicenses'] = $arrLog;

            $response->data = ['logs' => $arrResponseAll];
            Log::error('Error: MicrosoftController:getLicensesByOrder', ['request' => $request, 'ErrorMessage' => $e->getMessage()]);
        }

        return response()->json($response);
    }


    public function _getLicensesByOrderByCronjob($orderId)
    {
      //  $reqHeader = (object)$request->header();

        $response = (object) array();
        $response->status = (object) array();

        $request = (object) array();
        $request->orderId = $orderId;

        $resEmail = "";
        $resEmailAdmin = "";
        $isLicenses = false;

        $arrResponseAll = [];

        try {
            $orderId = $request->orderId;
            $order = $this->Order::where('id', $orderId)->first();
            $orderItems = $this->OrderItem::where('order_id', $orderId)->get();

            $arrReq = [];
            $arrReq['orderId'] = $orderId;
            $arrRes['order'] = $order;
            $arrRes['orderItems'] = $orderItems;

            $arrLog = [];
            $arrLog['type'] = 'info';
            $arrLog['view'] = 'S';
            $arrLog['action'] = 'orders.GetData';
            $arrLog['request'] = $arrReq;
            $arrLog['response'] = $arrRes;
            $this->logs->addApiLog($arrLog);
            Log::info('info: MicrosoftController:getLicensesByOrderJOB : ', ['orderItems' => $orderItems, 'orderId' => $orderId, 'r' => $request]);
            $arrResponseAll['getOrder'] = $arrLog;

            foreach ($orderItems as $orderItem) {
                //Log::info('info: MicrosoftController:getLicensesByOrderJOB : ', ['prepare' => $orderItem]);
                $orderQty = 1;
                $poNo = $orderItem->Inventory->Billing->po_no;
                $poQty = $orderItem->Inventory->Billing->sale_count;
                $poItemNo = $orderItem->Inventory->po_item_no;
                $vendorArticle = trim($orderItem->Inventory->Billing->vendor_article);

                //--- fixtest
                //$vendorArticle = 'ABC-77777';
                //$poQty = $orderItem->Inventory->Billing->qty;

                $data['qty'] = $orderQty;
                $data['poNumber'] = $poNo;
                $data['poItem'] = $poItemNo;
                $data['vendorArticle'] = $vendorArticle;

                $apiResponse = $this->Microsoft->prepare($data);

                $arrData = explode("=", $apiResponse->data);
                $arrLog = [];
                $arrLog['type'] = 'info';
                $arrLog['action'] = 'Microsoft.Prepare';
                $arrLog['request'] = $data;
                $arrLog['response'] = $apiResponse;

                $this->logs->addApiLog($arrLog);
                $arrResponseAll['MsPrepare'] = $arrLog;
                Log::info('info: MicrosoftController:getLicensesByOrderJOB : Microsoft Prepare', ['request' => $data, 'response' => $apiResponse]);

                if (@$arrData[1] == 200) {

                    $apiResponseLic = $this->Microsoft->getLicense($data);
                    $arrLog = [];
                    $arrLog['type'] = 'info';
                    $arrLog['action'] = 'Microsoft.getLicense';
                    $arrLog['request'] = $data;
                    $arrLog['response'] = $apiResponseLic;

                    $arrDataLicenseLog = explode("#", $apiResponseLic->data);
                    $apiResponseLic->data = $arrDataLicenseLog[0];
                    $this->logs->addApiLog($arrLog);
                    $arrResponseAll['MsGetLicense'] = $arrLog;
                    Log::info('info: MicrosoftController:getLicensesByOrderJOB : Microsoft getLicense', ['request' => $data, 'response' => $apiResponseLic]);

                    if ($apiResponseLic->status->code == 200) {

                        $arrDataLicense = explode("|", $apiResponseLic->data);
                        if (@$arrDataLicense[2]) {
                            $isLicenses = true;
                            $License = explode("#", $arrDataLicense[2])[0]; //License

                            $response->status->code = 200;
                            $response->status->message = 'Success';
                            $response->data = $License;
                        } else {
                            $response->status->code = 403;
                            $response->status->message = 'error : ' . $apiResponseLic->data;
                            $response->data = [];
                        }
                    } else {

                        $response->status->code = $apiResponseLic->status->code;
                        $response->data = [];
                    }

                    if ($isLicenses) {

                        $showLicense = '';
                        $arrDataLicense = explode("-", $License);
                        if (isset($arrDataLicense)) {
                            foreach ($arrDataLicense as $k => $v) {
                                if ($k != 0 && $k != count($arrDataLicense) - 1) {
                                    $nv = '-xxxxx';
                                } elseif ($k == count($arrDataLicense) - 1) {
                                    $nv = '-' . $v;
                                } else {
                                    $nv = $v;
                                }
                                $showLicense .= $nv;
                            }
                        }

                        //-----update to OrderItem
                        $OrderItem = $this->OrderItem::find($orderItem->id);
                        $OrderItem->license_key = $License;
                        $OrderItem->license_at = date("Y-m-d H:i:s");
                        $OrderItem->updated_uid = $order->sale_uid;
                        $OrderItem->updated_at = date("Y-m-d H:i:s");
                        $OrderItem->save();

                        // $arrLog = [];
                        // $arrLog['type'] = 'info';
                        // $arrLog['action'] = 'MicrosoftController : getLicensesByOrder : emailSentLicense';
                        // $arrLog['request'] = $eMailData;
                        // $arrLog['response'] = $resEmail;

                        // $arrResponseAll['updateOrderItem'] = $arrLog;

                        $eMailData = (object)[];
                        $eMailData->customerName = $order->customer_name;
                        $eMailData->mailTo = $order->email;
                        $eMailData->serial = $orderItem->Inventory->serial;
                        $eMailData->license = $License;
                        $eMailData->nameItem = $orderItem->Inventory->Billing->material_desc;
                        $eMailData->receiptNo = $order->receipt_no;
                        $eMailData->partNo = $order->path_no;
                        //$eMailData->description = $orderItem->Inventory->Billing->material_desc;
                        $eMailData->quantity = 1;
                        $eMailData->dateTime = $order->sale_at;
                        $eMailData->showLicense = $showLicense;
                        $resEmail = $this->EMail->sentLicense($eMailData);

                        $arrLog = [];
                        $arrLog['type'] = 'info';
                        $arrLog['action'] = 'email.send';
                        $arrLog['request'] = $eMailData;
                        $arrLog['response'] = $resEmail;
                        $arrResponseAll['sentEmail'] = $arrLog;

                        Log::info('info: MicrosoftController:getLicensesByOrderJOB : Microsoft sentEmail', ['request' => $eMailData, 'response' => $resEmail]);

                        $arrEmail = Config::select('val')->where('code', 'AEMAIL')->first();
                        $eMailData->mailTo = explode(",", $arrEmail->val);
                        $resEmailAdmin = $this->EMail->sentLicenseAdmin($eMailData);

                        $arrLog = [];
                        $arrLog['type'] = 'info';
                        $arrLog['action'] = 'email.send admin';
                        $arrLog['request'] = $eMailData;
                        $arrLog['response'] = $resEmailAdmin;
                        $arrResponseAll['sentEmailAdmin'] = $arrLog;

                        Log::info('info: MicrosoftController:getLicensesByOrderJOB : Microsoft sentEmailAdmin', ['request' => $eMailData, 'response' => $resEmailAdmin]);

                        //---- sent sms
                        $smsData = (object)[];
                        $smsData->smsTo = $order->tel;
                        $smsData->serial = $orderItem->Inventory->serial;
                        $smsData->license = $License;
                        $smsData->nameItem = $orderItem->Inventory->Billing->material_desc;
                        $smsData->dateTime = date("Y-m-d H:i");
                        $resSms = $this->SMS->sentLicense($smsData);

                        //------fix test
                        // $resSms = (object)[];
                        // $resSms->status =(object)[];
                        // $resSms->status->code = 200;

                        $arrLog = [];
                        $arrLog['type'] = 'info';
                        $arrLog['action'] = 'SMS.send';
                        $arrLog['request'] = $smsData;
                        $arrLog['response'] = $resSms;
                        $arrResponseAll['sentSMS'] = $arrLog;

                        Log::info('info: MicrosoftController:getLicensesByOrderJOB : Microsoft sentSMS', ['request' => $smsData, 'response' => $resSms]);
                    }
                } else {
                    Log::error('Error: MicrosoftController:getLicensesByOrderJOB : Microsoft Prepare', ['request' => $data, 'response' => $apiResponse->data]);
                }
            }

            $arrLog = [];
            $arrLog['type'] = 'info';
            $arrLog['action'] = 'orders.getLicenses';
            $arrLog['request'] = $request;
            $arrLog['response'] = true;
            $arrResponseAll['getLicenses'] = $arrLog;

            $response->status->code = '200';
            $response->status->message = 'Successful';
            $response->data = ['logs' => $arrResponseAll];
            Log::info('Successful: MicrosoftController:getLicensesByOrderJOB : ', ['response' => $response]);

        } catch (\Exception $e) {

            $response->status->code = '503';
            $response->status->message = $e->getMessage();

            $arrLog = [];
            $arrLog['type'] = 'error';
            $arrLog['action'] = 'orders.getLicenses';
            $arrLog['request'] = $request;
            $arrLog['response'] = $e->getMessage();
            $arrResponseAll['getLicenses'] = $arrLog;

            $response->data = ['logs' => $arrResponseAll];
            Log::error('Error: MicrosoftController:getLicensesByOrderJOB', ['request' => $request, 'ErrorMessage' => $e->getMessage()]);
        }

        return response()->json($response);
    }

}