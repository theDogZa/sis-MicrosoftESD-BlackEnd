<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;

use App\Models\Billing;
use App\Models\Config;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;

use App\Services\MailService;
use App\Services\LogsService;
use App\Services\SmsService;

use App\Exports\OrdersExport;
use Maatwebsite\Excel\Facades\Excel;

class OrdersController extends Controller
{
  /**
   * Instantiate a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    //$this->middleware('RolePermission');
    $this->logs = new LogsService();

    Cache::flush();
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header('Content-Type: text/html');

    $this->EMail = new MailService();
    $this->SMS = new SmsService();

    $this->arrShowFieldIndex = [
		 'customer_name' => 1,  'email' => 1,  'tel' => 1,  'path_no' => 1,  'receipt_no' => 1,  'sale_uid' => 1,  'sale_at' => 1, 		];
		$this->arrShowFieldFrom = [
		 'customer_name' => 1,  'email' => 1,  'tel' => 1,  'path_no' => 1,  'receipt_no' => 1,  'sale_uid' => 1,  'sale_at' => 1, 		];
		$this->arrShowFieldView = [
		 'customer_name' => 1,  'email' => 1,  'tel' => 1,  'path_no' => 1,  'receipt_no' => 1,  'sale_uid' => 1,  'sale_at' => 1,	];
  }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
		$rules = [
			'customer_name' => 'required|string|max:255',
			'email' => 'required|string|max:255',
			'tel' => 'required|string|max:255',
			'path_no' => 'required|string|max:255',
			'receipt_no' => 'required|string|max:255',
			'sale_uid' => 'required|string|max:255',
			'sale_at' => 'required|string|max:255',
			//#Ex
			//'username' => 'required|string|max:20|unique:users,username,' . $data ['id'],
			//'email' => 'required|string|email|max:255|unique:users,email,' . $data ['id'],
			// 'password' => 'required|string|min:6|confirmed',
			//'password' => 'required|string|min:6',
		];
		
		$messages = [
			'customer_name.required' => trans('Order.customer_name_required'),
			'email.required' => trans('Order.email_required'),
			'tel.required' => trans('Order.tel_required'),
			'path_no.required' => trans('Order.path_no_required'),
			'receipt_no.required' => trans('Order.receipt_no_required'),
			'sale_uid.required' => trans('Order.sale_uid_required'),
			'sale_at.required' => trans('Order.sale_at_required'),
			//#Ex
			//'email.unique'  => 'Email already taken' ,
			//'username.unique'  => 'Username "' . $data['username'] . '" already taken',
			//'email.email' =>'Email type',
		];

		return Validator::make($data,$rules,$messages);
	}

  public function index(Request $request)
  {
    $compact = (object) array();

    $select = $this->_listToSelect($this->arrShowFieldIndex);

    $results = Order::select($select);
    $results = $results->leftJoin('order_items', 'order_items.order_id', '=', 'orders.id')
                      ->leftJoin('inventory', 'order_items.inventory_id', '=', 'inventory.id')
                      ->leftJoin('billings', 'inventory.billing_id', '=', 'billings.id');

    //------ search
    if (count($request->all())) {
      $input = (object) $request->all();
      if(@$input->search){
        $results = $this->_easySearch($results, $input->search);
      }else{
        $results = $this->_advSearch($results, $input);
      }
    }

    if(!@$request->sort){
      $request->sort = 'sale_at';
      $request->direction = 'desc';
    }

    $compact->search = (object) $request->all();

    $compact->searchStr = http_build_query($request->all(),'','&');

    $this->_getDataBelongs($compact);
    //-----

    //$compact->collection = $results->sortable(['sale_at' => 'desc'])->paginate(config('theme.paginator.paginate'));
    $compact->collection = $results->orderBy($request->sort, $request->direction)->paginate(config('theme.paginator.paginate'));
    
    $this->arrShowFieldIndex['serial'] = 1;
    $compact->arrShowField = $this->arrShowFieldIndex;

    $dataLog = array();
    $dataLog['request'] = $request->all();
    $dataLog['response'] = $results->get()->toArray();
    $this->_cLog($request, $dataLog);

    return view('_orders.index', (array) $compact);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  // public function create(Request $request)
  // {
  //     $compact = (object) array();
  //     $compact->arrShowField = $this->arrShowFieldFrom;

  //     $this->_getDataBelongs($compact);

  //     $this->_cLogSys($request);

  //     return view('_orders.form', (array) $compact);
  // }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  // public function store(Request $request)
  // {
  //   $this->validator($request->all())->validate();

  //   $input = (object) $request->except(['_token', '_method']);

  //   try {
  //     DB::beginTransaction();

  //     $order = new Order;
  //     foreach ($input as $key => $v) {
  //       $order->$key = $v;
  //     }
  //     $order->created_uid = Auth::id();
  //     $order->created_at = date("Y-m-d H:i:s");
  //     $order->save();

  //     DB::commit();
  //     Log::info('Successful: Order:store : ', ['data' => $order]);

  //     $this->_cLogSys($request, $order->id);

  //     $message = trans('core.message_insert_success');
  //     $status = 'success';
  //     $title = 'Success';
  //   } catch (\Exception $e) {

  //     DB::rollback();
  //     Log::error('Error: Order:store :' . $e->getMessage());

  //     $this->_cLogSys($request);

  //     $message = trans('core.message_insert_error');
  //     $status = 'error';
  //     $title = 'Error';
  //   }

  //   session(['noit_title' => $title]);
  //   session(['noit_message' => $message]);
  //   session(['noit_status' => $status]);

  //   return redirect()->route('orders.index');
  // }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit(Request $request, $id)
  {
    $select = $this->_listToSelect($this->arrShowFieldFrom);

    $compact = (object) array();
    $compact->arrShowField = $this->arrShowFieldFrom;
    $order = Order::select($select)->findOrFail($id);
    $orderItems = OrderItem::where('order_id',$id)->get();

    foreach($orderItems as $orderItem){
      $showLicense = '';
      $arrDataLicense = explode("-", $orderItem->license_key);
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
        $orderItem->license_key = $showLicense;
      }
    }
    
    $compact->orderItems = $orderItems;

    $compact->order = $order;

    $this->_getDataBelongs($compact);
    
    $dataLog = array();
    $dataLog['request'] = array('id' => $id);
    $dataLog['response'] = $order->toArray();

    $this->_cLog($request, $dataLog);

    return view('_orders.form',$order, (array) $compact);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show(Request $request, $id)
  {
    $select = $this->_listToSelect($this->arrShowFieldView);

    $compact = (object) array();
    $compact->arrShowField = $this->arrShowFieldView;
    $compact->order = Order::select($select)->findOrFail($id);
    $orderItems = OrderItem::where('order_id',$id)->get();

    foreach($orderItems as $orderItem){
      $showLicense = '';
      $arrDataLicense = explode("-", $orderItem->license_key);
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
        $orderItem->license_key = $showLicense;
      }
    }
    
    $compact->orderItems = $orderItems;
    $this->_getDataBelongs($compact);
    
    $dataLog = array();
    $dataLog['request'] = array('id' => $id);
    $dataLog['response'] = $compact->order->toArray();
    $this->_cLog($request, $dataLog);

    return view('_orders.show', (array) $compact);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */

  public function update(Request $request, $id) {
  
    //$this->validator($request->all())->validate();

    $input = (object) $request->except(['_token', '_method']);
  
    try {
      DB::beginTransaction();

      $order = Order::find($id);
      foreach ($input as $key => $v) {
        $order->$key = $v;
      }
      $order->updated_uid = Auth::id();
      $order->updated_at = date("Y-m-d H:i:s");
      $order->save();

      DB::commit();

      $dataLog = array();
      $dataLog['request'] = (array)$input;
      $dataLog['response'] = $order->toArray();
      $this->_cLog($request, $dataLog);

      $message = trans('core.message_update_success');
      $status = 'success';
      $title = 'Success';
    } catch (\Exception $e) {

      DB::rollback();
      Log::error('Error: order:update :' . $e->getMessage());

      $dataLog = array();
      $dataLog['request'] = (array)$input;
      $dataLog['response'] = array('ErrorMessage' => $e->getMessage());
      $this->_cLog($request, $dataLog);

      $message = trans('core.message_update_error');
      $status = 'error';
      $title = 'Error';
    }

    session(['noit_title' => $title]);
    session(['noit_message' => $message]);
    session(['noit_status' => $status]);

    return redirect()->route('orders.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request, $id) {

    $response = (object) array();

    try {
      DB::beginTransaction();

     // $dataLog = array();
      // $dataLog['request'] = array('id' => $id);
      // $dataLog['response'] = Order::find($id)->toArray();
      // $this->_cLog($request, $dataLog);

      Order::destroy($id);

      DB::commit();

      $dataLog = array();
      $dataLog['request'] = array('id' => $id);
      $dataLog['response'] = array();
      $this->_cLog($request, $dataLog);

      $message = trans('core.message_del_success');
      $status = 'success';
      $title = 'Success';
    } catch (\Exception $e) {

      DB::rollback();
      Log::error('Error: order:destroy :' . $e->getMessage());

      $dataLog = array();
      $dataLog['request'] = array('id' => $id);
      $dataLog['response'] = array('ErrorMessage' => $e->getMessage());
      $this->_cLog($request, $dataLog);

      $message = trans('core.message_del_error');
      $status = 'error';
      $title = 'Error';
    }

    $response->title = $title;
    $response->status = $status;
    $response->message = $message;

    return (array) $response;

  }

  /**
   * Field list To Select data form db 
   *
   * @param  array  $arrField
   * @return array select data
   */
  protected function _listToSelect($arrField)
  {
    $select[] = 'orders.id';
    foreach ($arrField as $key => $val) {
      if ($val == 1) {
        $select[] = 'orders.'.$key;
      }
    }
    return $select;
  }

  protected function _easySearch($results, $search=""){
	      $results = $results->orWhere ('orders.customer_name', 'LIKE','%'. @$search.'%') ;
	      $results = $results->orWhere ('orders.email', 'LIKE','%'. @$search.'%') ;
	      $results = $results->orWhere ('orders.tel', 'LIKE','%'. @$search.'%') ;
	      $results = $results->orWhere ('orders.path_no', 'LIKE','%'. @$search.'%') ;
	      $results = $results->orWhere ('orders.receipt_no', 'LIKE','%'. @$search.'%') ;
	      $results = $results->leftJoin('users', 'orders.sale_uid', '=', 'users.id')->orWhere ('users.username', 'LIKE','%'. @$search.'%') ;
	      $results = $results->orWhere ('orders.sale_at', 'LIKE','%'. @$search.'%') ;
        $results = $results->orWhere ('inventory.serial', 'LIKE','%'. @$search.'%') ;
        $results = $results->orWhere('billings.sold_to', 'LIKE', '%' . @$search . '%');  
        return $results;
  }

  protected function _advSearch($results, $input){
        if(@$input->customer_name){
          $results = $results->where('orders.customer_name', 'LIKE', "%" .  $input->customer_name. "%" );
        }
        if(@$input->email){
          $results = $results->where('orders.email', 'LIKE', "%" .  $input->email. "%" );
        }
        if(@$input->tel){
          $results = $results->where('orders.tel', 'LIKE', "%" .  $input->tel. "%" );
        }
        if(@$input->path_no){
          $results = $results->where('orders.path_no', 'LIKE', "%" .  $input->path_no. "%" );
        }
        if(@$input->receipt_no){
          $results = $results->where('orders.receipt_no', 'LIKE', "%" .  $input->receipt_no. "%" );
        }
        if(@$input->serial){
          $results = $results->where('inventory.serial', 'LIKE', "%" .  $input->serial. "%" );
        }
        if(@$input->sale_uid){
          $results = $results->where('orders.sale_uid',  $input->sale_uid);
        }
        if(@$input->sale_at_start && @$input->sale_at_end){
          $sd = date_create($input->sale_at_start . "00:00:01");
          $sDate = date_format($sd, "Y-m-d H:i:s");
          $ed = date_create(@$input->sale_at_end . "23:59:59");
          $eDate = date_format($ed, "Y-m-d H:i:s");
          $results = $results->whereBetween('orders.sale_at',  [$sDate, $eDate]);
        }
        if (@$input->sold_to) {
          $results = $results->where('billings.sold_to', 'LIKE', "%" .  $input->sold_to . "%");
        }
      return $results;
  }

  protected function _getDataBelongs($compact)
  {
		$compact->arrSaleu = User::where('users.id','!=',null)
      ->leftJoin('users_roles', 'users_roles.user_id', '=', 'users.id')
      ->where('users_roles.role_id','!=', 1)
      //->where('users.active', 1)
			->orderBy('users.username')
			->pluck('username', 'users.id')
      ->toArray();

    $compact->arrSoldTo = Billing::select('id','sold_to')->groupBy('sold_to')->orderBy('billings.sold_to')->pluck('sold_to', 'sold_to')->toArray();
  }

  /**
   *Re Send License to Email & SMS
   *
   * @param  int  $id
   * @param  str  $email
   * @param  str  $tel
   * @return \Illuminate\Http\Response
   */
  public function reSendLicense(Request $request) {

    $response = (object) array();
    $response->status = (object) array();

    try {
      $id = $request->orderId;
      $email = $request->email;
      $tel = $request->tel;

      $order = Order::select('*')->findOrFail($id);
      $orderItems = OrderItem::where('order_id', $id)->get();

      $arrLog = array();
      $arrLog['type'] = 'info';
      $arrLog['view'] = 'S';
      $arrLog['request'] = array('orderId' => $id);
      $arrLog['response'] = array('order' => $order->toArray(), 'orderItems' => $orderItems->toArray());
      $this->logs->addLogSys2($request, $arrLog);

      foreach ($orderItems as $orderItem) {

        $showLicense = '';
        $arrDataLicense = explode("-", $orderItem->license_key);
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

        $resEmail = (object) array();
        $resEmailAdmin = (object) array();
        $resSMS = (object) array();
        $resSMS->status = (object) array();

        $eMailData = (object)[];
        $eMailData->customerName = $order->customer_name;
        $eMailData->mailTo = $email;
        $eMailData->serial = $orderItem->Inventory->serial;
        $eMailData->license = $orderItem->license_key;
        $eMailData->nameItem = $orderItem->Inventory->Billing->material_desc;
        $eMailData->receiptNo = $order->receipt_no;
        $eMailData->partNo = $order->path_no;
        //$eMailData->description = '';
        $eMailData->quantity = 1;
        $eMailData->dateTime = $order->sale_at;
        $eMailData->showLicense = $showLicense;

        $resEmail = $this->EMail->sentLicense($eMailData);

        $arrLog = array();
        $arrLog['action'] = 'email.send';
        $arrLog['request'] = (array)$eMailData;
        $arrLog['response'] = $resEmail;
        $this->logs->addLogSys2($request, $arrLog);

        $arrEmail = Config::select('val')->where('code', 'AEMAIL')->first();
        $eMailData->mailTo = explode(",", $arrEmail->val);

        $resEmailAdmin = $this->EMail->sentLicenseAdmin($eMailData);
        $arrLog = array();
        $arrLog['action'] = 'email.send admin';
        $arrLog['request'] = (array)$eMailData;
        $arrLog['response'] = $resEmailAdmin;
        $this->logs->addLogSys2($request, $arrLog);

        //---- sent sms
        $smsData = (object)[];
        $smsData->smsTo = $tel;
        $smsData->serial = $orderItem->Inventory->serial;
        $smsData->license = $orderItem->license_key;
        $smsData->nameItem = $orderItem->Inventory->Billing->material_desc;
        $smsData->dateTime = date("Y-m-d H:i");
        $resSms = $this->SMS->sentLicense($smsData);

        // $resSms = (object)[];
        // $resSms->status =(object)[];
        // $resSms->status->code = 200;

        $arrLog = array();
        $arrLog['action'] = 'SMS.send';
        $arrLog['request'] = $smsData;
        $arrLog['response'] = $resSms;
        $this->logs->addLogSys2($request, $arrLog);
  
        if ($resEmail->status->code == 200 && $resEmailAdmin->status->code == 200 && $resSms->status->code == 200){
          
          $response->status->code = 200;
          $response->status->message = 'Success';

          $arrLog = array();
          $arrLog['request'] = $request->all();
          $arrLog['response'] = true;
          $this->logs->addLogSys2($request, $arrLog);

        }else{

          $arrError['Email'] = $resEmail->data;
          $arrError['EmailAdmin'] = $resEmailAdmin->data;
          $arrError['SMS'] = $resSms->data;

          $response->status->code = 400;
          $response->status->message = 'error';
          $response->data = $arrError;

          $arrLog = array();
          $arrLog['request'] = $request->all();
          $arrLog['response'] = $arrError;
          $this->logs->addLogSys2($request, $arrLog);
        }

        $oi = OrderItem::find($orderItem->id);
        $oi->count_resend = $oi->count_resend+1;
        $oi->updated_uid = Auth::id();
        $oi->updated_at = date("Y-m-d H:i:s");
        $oi->save();

      }
    } catch (\Exception $e) {

      $response->status->code = '503';
      $response->status->message = $e->getMessage();

      $arrLog = array();
      $arrLog['type'] = 'error';
      $arrLog['view'] = 'S';
      $arrLog['request'] = $request;
      $arrLog['response'] = $response;
      $this->logs->addLogSys2($request, $arrLog);
    }

    $response->status->code = 200;
    $response->status->message = 'Success';
    return response()->json($response);  
  }


  public function exportOrdersXLS(Request $request)
  {
    $search = [];
    if (count($request->all())) {
      $search = $request->all();
    }

    $nameFile = 'orders_'.date('Ymdhis').'.xlsx';

    $arrLog = array();
    $arrLog['action'] = 'export.xls';
    $arrLog['request'] = $request;
    $arrLog['response'] = $nameFile;

    $this->logs->addLogSys2($request, $arrLog);

    return (new OrdersExport)->forSerach($search)->download($nameFile);

  }

  public function exportOrdersCSV(Request $request)
  {
    $search = [];
    if (count($request->all())) {
      $search = $request->all();
    }

    $nameFile = 'orders_' . date('Ymdhis') . '.csv';

    $arrLog = array();
    $arrLog['action'] = 'export.csv';
    $arrLog['request'] = $request;
    $arrLog['response'] = $nameFile;

    $this->logs->addLogSys2($request, $arrLog);

    return (new OrdersExport)->forSerach($search)->download($nameFile, \Maatwebsite\Excel\Excel::CSV, [
      'Content-Type' => 'text/csv',
    ]);
  }

  /**
   * add create log format to add log
   *
   * @param  array  $data Log
   */
  protected function _cLog($request, $data = [])
  {

    $data = (object)$data;

    // $newResponse = [];
    // $newRequest = [];

    // foreach ($data->request as $key => $val) {
    //   if ($key == 'sort') {
    //     // if ($val == 1) {
    //     //   $val = trans('orders.active.text_radio.true');
    //     // } else {
    //     //   $val = trans('orders.active.text_radio.false');
    //     // }
    //     $val = 'Sort by';
    //   } elseif ($key == 'direction') {
    //     if ($val == 'DESC') {
    //       $val = trans('orders.sale_status.text_radio.true');
    //     } else {
    //       $val = trans('orders.sale_status.text_radio.false');
    //     }
    //   }
    //   $newRequest[$key] = $val;
    // }

    // foreach ($data->response as $key => $val) {
    //   if ($key == 'active') {
    //     if ($val == 1) {
    //       $val = trans('orders.active.text_radio.true');
    //     } else {
    //       $val = trans('orders.active.text_radio.false');
    //     }
    //   } elseif ($key == 'sale_status') {
    //     if ($val == 1) {
    //       $val = trans('orders.sale_status.text_radio.true');
    //     } else {
    //       $val = trans('orders.sale_status.text_radio.false');
    //     }
    //   }
    //   $newResponse[$key] = $val;
    // }

    $arrLog = array();
    $arrLog['type'] = @$data->type;
    $arrLog['view'] = @$data->view;
    $arrLog['action'] = @$data->action;
    $arrLog['request'] = $data->request;
    $arrLog['response'] = $data->response;

    $this->logs->addLogSys2($request, $arrLog);

  }
}
