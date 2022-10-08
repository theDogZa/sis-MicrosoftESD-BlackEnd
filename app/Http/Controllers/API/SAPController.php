<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\SapService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\Billing;
use App\Models\Inventory;

use App\Services\LogsService;

use Carbon\Carbon;

class SAPController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->logs = new LogsService();
        $this->SAP = new SapService();
        $this->Billing = new Billing();
        $this->Inventory = new Inventory();
    }

    /**
     * get Data Billing, Serial
     *
     * @return \Illuminate\Http\Response
     */
    public function getDataBillings()
    {
        try {

            // $eDate = date('Ymd', strtotime('-1 days'));
            // $sDate = date('Ymd', strtotime('-7 days'));

            $eDate = date("Ymd", strtotime("-1 days"));
            $sDate = date("Ymd", strtotime("-1 days"));

            //Log::info('info: SAPController : getDataBillings : Date : '. $sDate."-". $eDate);

            Log::channel('logSap')->info('SAPController:getDataBillings: -------------- Date', ['sDate' => $sDate, 'eDate' => $eDate]);

            $response = (object) array();
            
            $results = $this->SAP->Z_SD0001('1100000136',$sDate,$eDate);

            //Log::info('info: SAPController : getDataBillings : Z_SD0001 : ',['results'=> $results] );

            Log::channel('logSap')->info('SAPController:getDataBillings: Z_SD0001 ', ['results' => $results]);

            if ($results->status->code == 200) {

                $response->status = $results->status;
                $response->data = $results->data;

                $this->_setDataBilling($results->data);
                $this->_setDataInventory($results->data);
                
            } else {
                $response->status = $results->status;
                $response->data = [];
            }

            Log::channel('logSap')->info('SAPController:getDataBillings: Z_SD0001 ', ['response' => $response->data]);

            $arrLog['type'] = 'info';
            $arrLog['action'] = 'SAPController : getDataBillings : Successful';
            $arrLog['request'] = $sDate;
            $arrLog['response'] = $response->data;
            $this->logs->addApiLog($arrLog);

        } catch (\Exception $e) {

            DB::rollback();
            // Log::error('Error: SAPController:getDataBillings :' . $e->getMessage());
            Log::channel('logSap')->error('SAPController:getDataBillings : Exception', ['request' => $sDate."-".$eDate, 'response' =>  $e->getMessage()]);

            $arrLog['type'] = 'error';
            $arrLog['action'] = 'SAPController : getDataBillings : Exception';
            $arrLog['request'] = $sDate;
            $arrLog['response'] = $e->getMessage();
            $this->logs->addApiLog($arrLog);
            

        }
    }

    protected function _strDataSAPtoFormat($strDate='',$format = 'Y-m-d'){
        $yyyy = mb_substr($strDate, 0, 4);
        $mm = mb_substr($strDate, 4, 2);
        $dd = mb_substr($strDate, 6, 2);
        $date = $yyyy.'-'. $mm.'-'.$dd;

        return Carbon::createFromFormat('Y-m-d', $date)->format($format);
    }

    protected function _setDataBilling($data=[])
    {
        try {

            $resBillings = $data['T_ITEM'];
            $resHEADER = $data['T_HEADER'];

            //SOLDTO

            DB::beginTransaction();
            Log::channel('logSap')->info('SAPController:_setDataBilling: -------------- data', ['resBillings' => $resBillings]);

            foreach ($resBillings as $item) {
                $item = (object)$item;

                $chkBilling = Billing::select('id')->where('BILLING_NO', $item->BILLING_NO)->where('BILLING_ITEM', $item->BILLING_ITEM)->first();


                if (!isset($chkBilling)) {

                    $key = array_search($item->BILLING_NO, array_column($resHEADER, 'BILLING_NO'));
                    $dataHeader = (object)$resHEADER[$key];
                    $billingDate = $this->_strDataSAPtoFormat($dataHeader->BILLING_DOCDATE);

                    $billing = new Billing();
                    $billing->sold_to = $dataHeader->SOLDTO;
                    $billing->billing_no = $item->BILLING_NO;
                    $billing->billing_item = $item->BILLING_ITEM;
                    $billing->billing_at = $billingDate;
                    $billing->material_no = $item->MATERIAL_NO;
                    $billing->material_desc = $item->MATERIAL_DESC;
                    $billing->qty = $item->QTY;
                    $billing->po_no = $item->GR_PO_NO;
                    $billing->vendor_article = $item->VENDOR_ARTICLE;
                    $billing->remaining_amount = $item->QTY;
                    $billing->created_uid = 0; //<-- 0 = system created
                    $billing->created_at = date("Y-m-d H:i:s");
                    $billing->save();

                    $arrReq['BILLING_NO'] = $item->BILLING_NO;
                    $arrReq['BILLING_ITEM'] = $item->BILLING_ITEM;
                    $arrRes['chkBilling'] = $chkBilling;

                    $arrLog['type'] = 'info';
                    $arrLog['action'] = 'SAPController : _setDataBilling : addBilling';
                    
                    $arrLog['request'] = $arrReq;
                    $arrLog['response'] = $arrRes;
                    $this->logs->addApiLog($arrLog);

                    Log::channel('logSap')->info('SAPController:_setDataBilling: addBilling', ['item' => $item, 'billing' => $billing]);

                } else {

                    $arrReq['BILLING_NO'] = $item->BILLING_NO;
                    $arrReq['BILLING_ITEM'] = $item->BILLING_ITEM;
                    $arrRes['chkBilling'] = $chkBilling;
                    $arrRes['dataBilling'] = $item;

                    $arrLog['type'] = 'warning';
                    $arrLog['action'] = 'SAPController : _setDataBilling : duplicateData';
                    
                    $arrLog['request'] = $arrReq;
                    $arrLog['response'] = $arrRes;
                    $this->logs->addApiLog($arrLog);

                   // Log::error('Error: SAPController:_setDataBilling:duplicateData', ['duplicateId' => $chkBilling->id, 'billingData' => $item]);

                    Log::channel('logSap')->error('SAPController:_setDataBilling:duplicateData', ['duplicateId' => $chkBilling->id, 'item' => $item]);
                }
            }

            DB::commit();

        } catch (\Exception $e) {

            DB::rollback();
           // Log::error('Error: SAPController:_setDataBilling :' . $e->getMessage());

            $arrLog['type'] = 'error';
            $arrLog['action'] = 'SAPController : _setDataBilling : Exception';
            $arrLog['request'] = $data;
            $arrLog['response'] = $e->getMessage();
            $this->logs->addApiLog($arrLog);

            Log::channel('logSap')->error('SAPController:_setDataBilling : Exception', ['request' => $data, 'response' =>  $e->getMessage()]);

        }
    }

    protected function _setDataInventory($data = [])
    {
        try {

            $resSERIAL = $data['T_SERIAL'];

            DB::beginTransaction();
            Log::channel('logSap')->info('SAPController:_setDataInventory: -------------- data', ['resSERIAL' => $resSERIAL]);

            foreach ($resSERIAL as $item) {
                $item = (object)$item;
                $chkPoNo = null;

                $Billing = Billing::select('id','po_no')->where('BILLING_NO', $item->INVOICE_NO)->where('BILLING_ITEM', $item->INVOICE_ITEM)->first();
               // $PO = Billing::select('po_no')->where('BILLING_NO', $item->INVOICE_NO)->first();
                $BillingId = $Billing->id;

                $chkInv = Inventory::select('id')->where('material_no', $item->MATERIAL)->where('serial', $item->SERIAL)->first();

                if (!isset($chkInv)) {

                    if($chkPoNo != $Billing->po_no){
                    // if ($chkPoNo != $PO->po_no) {

                        //----running number by po
                        $poRunning = 0;

                        $InventoryPoNo = Inventory::select('po_item_no')
                        ->leftJoin('billings', 'inventory.billing_id', '=', 'billings.id')
                        ->where('billings.po_no', $Billing->po_no)
                        //->where('billings.po_no', $PO->po_no)
                        ->orderby('po_item_no', 'DESC')
                        ->first();

                        if(isset($InventoryPoNo)){
                            if($InventoryPoNo->po_item_no != null){
                                $poRunning = $InventoryPoNo->po_item_no;
                            }
                        }
                        $chkPoNo = $Billing->po_no;
                       // $chkPoNo = $PO->po_no;
                    }

                    $poRunning++;

                    $inventory = new Inventory;
                    $inventory->billing_id = $BillingId;
                    $inventory->serial = trim($item->SERIAL);
                    $inventory->serial_long = trim($item->SERIAL_30);
                    $inventory->imei = trim($item->IMEI);
                    $inventory->material_no = trim($item->MATERIAL);
                    $inventory->serial_raw = trim($item->SERNR_TMP);
                    $inventory->po_item_no = $poRunning;
                    $inventory->created_uid = 0; //<-- 0 = system created
                    $inventory->created_at = date("Y-m-d H:i:s");
                    $inventory->save();

                    $arrReq['MATERIAL'] = $item->MATERIAL;
                    $arrReq['SERIAL'] = $item->SERIAL;
                    $arrRes['chkInv'] = $chkInv;

                    $arrLog['type'] = 'info';
                    $arrLog['action'] = 'SAPController : _setDataInventory';
                    
                    $arrLog['request'] = $arrReq;
                    $arrLog['response'] = $arrRes;
                    $this->logs->addApiLog($arrLog);

                    Log::channel('logSap')->info('SAPController:_setDataInventory: addInventory', ['item' => $item, 'billing' => $inventory]);

                } else {
                    Log::error('Error: SAPController:_setDataInventory:duplicateData', ['duplicateId' => $chkInv->id, 'inventoryData' => $item]);

                    Log::channel('logSap')->error('SAPController:_setDataInventory : duplicateData', ['duplicateId' => $chkInv->id, 'inventoryData' => $item]);

                    $arrReq['MATERIAL'] = $item->MATERIAL;
                    $arrReq['SERIAL'] = $item->SERIAL;
                    $arrRes['chkInv'] = $chkInv;
                    $arrRes['dataInventory'] = $item;

                    $arrLog['type'] = 'warning';
                    $arrLog['action'] = 'SAPController : _setDataInventory : duplicateData';
                    
                    $arrLog['request'] = $arrReq;
                    $arrLog['response'] = $arrRes;
                    $this->logs->addApiLog($arrLog);
                }
                
            }
            DB::commit();

        } catch (\Exception $e) {

            DB::rollback();
            Log::error('Error: SAPController:_setDataInventory :' . $e->getMessage());
            $arrLog['type'] = 'error';
            $arrLog['action'] = 'SAPController : _setDataInventory : Exception';
            $arrLog['request'] = $data;
            $arrLog['response'] = $e->getMessage();
            $this->logs->addApiLog($arrLog);

            Log::channel('logSap')->error('SAPController:_setDataInventory : Exception', ['request' => $data, 'response' =>  $e->getMessage()]);
        }

    }
}