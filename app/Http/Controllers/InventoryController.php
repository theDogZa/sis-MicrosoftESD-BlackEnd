<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use App\Models\Inventory;
use App\Models\Billing;

use App\Services\LogsService;

class InventoryController extends Controller
{
  /**
   * Instantiate a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('RolePermission');
    $this->logs = new LogsService();

    Cache::flush();
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header('Content-Type: text/html');

    $this->arrShowFieldIndex = [
		 'billing_id' => 1,  'serial' => 1,  'serial_long' => 0,  'imei' => 0,  'material_no' => 1,  'serial_raw' => 0,  'active' => 1,  'sale_status' => 1, 'po_item_no' => 0		];
		$this->arrShowFieldFrom = [
		 'billing_id' => 1,  'serial' => 1,  'serial_long' => 1,  'imei' => 0,  'material_no' => 1,  'serial_raw' => 0,  'active' => 1,  'sale_status' => 1, 'po_item_no' => 0		];
		$this->arrShowFieldView = [
		 'billing_id' => 1,  'serial' => 1,  'serial_long' => 1,  'imei' => 0,  'material_no' => 1,  'serial_raw' => 0,  'active' => 1,  'sale_status' => 1, 'po_item_no' => 0		];
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
			'billing_id' => 'required|string|max:255',
			'serial' => 'required|string|max:255',
			'serial_long' => 'required|string|max:255',
			'material_no' => 'required|string|max:255',
			'serial_raw' => 'required|string|max:255',
			'active' => 'required|string|max:255',
			'sale_status' => 'required|string|max:255',
			//#Ex
			//'username' => 'required|string|max:20|unique:users,username,' . $data ['id'],
			//'email' => 'required|string|email|max:255|unique:users,email,' . $data ['id'],
			// 'password' => 'required|string|min:6|confirmed',
			//'password' => 'required|string|min:6',
		];
		
		$messages = [
			'billing_id.required' => trans('Inventory.billing_id_required'),
			'serial.required' => trans('Inventory.serial_required'),
			'serial_long.required' => trans('Inventory.serial_long_required'),
			'material_no.required' => trans('Inventory.material_no_required'),
			'serial_raw.required' => trans('Inventory.serial_raw_required'),
			'active.required' => trans('Inventory.active_required'),
			'sale_status.required' => trans('Inventory.sale_status_required'),
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

    $results = Inventory::select($select);

    //------ search
    if (count($request->all())) {
      $input = (object) $request->all();
      if(@$input->search){
        $results = $this->_easySearch($results, $input->search);
      }else{
        $results = $this->_advSearch($results, $input);
      }
    }
    $compact->search = (object) $request->all();

    $this->_getDataBelongs($compact);
    //-----

    $compact->collection = $results->sortable()->paginate(config('theme.paginator.paginate'));

    $compact->arrShowField = $this->arrShowFieldIndex;

    $dataLog = array();
    $dataLog['request'] = (array)$request->all();
    $dataLog['response'] = $results->get()->toArray();
    $this->_cLog($request, $dataLog);

    return view('_inventory.index', (array) $compact);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request)
  {
      $compact = (object) array();
      $compact->arrShowField = $this->arrShowFieldFrom;

      $this->_getDataBelongs($compact);

      $dataLog = array();
      $this->_cLog($request, $dataLog);

      return view('_inventory.form', (array) $compact);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //$this->validator($request->all())->validate();

    $input = (object) $request->except(['_token', '_method']);

    try {
      DB::beginTransaction();

      $inventory = new Inventory;
      foreach ($input as $key => $v) {
        $inventory->$key = $v;
      }
      $inventory->created_uid = Auth::id();
      $inventory->created_at = date("Y-m-d H:i:s");
      $inventory->save();

      DB::commit();
      //Log::info('Successful: Inventory:store : ', ['data' => $inventory]);

      $dataLog = array();
      $dataLog['request'] = $input;
      $dataLog['response'] = $inventory->toArray();
      $this->_cLog($request, $dataLog);

      $message = trans('core.message_insert_success');
      $status = 'success';
      $title = 'Success';
    } catch (\Exception $e) {

      DB::rollback();
      Log::error('Error: Inventory:store :' . $e->getMessage());

      $dataLog = array();
      $dataLog['request'] = $input;
      $dataLog['response'] = array('ErrorMessage' => $e->getMessage());
      $this->_cLog($request, $dataLog);

      $message = trans('core.message_insert_error');
      $status = 'error';
      $title = 'Error';
    }

    session(['noit_title' => $title]);
    session(['noit_message' => $message]);
    session(['noit_status' => $status]);

    return redirect()->route('inventory.index');
  }

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
    $inventory = Inventory::select($select)->findOrFail($id);

    $compact->inventory = $inventory;

    $this->_getDataBelongs($compact);

    $dataLog = array();
    $dataLog['request'] = array('id' => $id);
    $dataLog['response'] = $inventory->toArray();
    $this->_cLog($request, $dataLog);

    return view('_inventory.form',$inventory, (array) $compact);
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
    $compact->inventory = Inventory::select($select)->findOrFail($id);
    $this->_getDataBelongs($compact);
    
    $dataLog = array();
    $dataLog['request'] = array('id' => $id);
    $dataLog['response'] = $compact->inventory->toArray();
    $this->_cLog($request, $dataLog);

    return view('_inventory.show', (array) $compact);
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

      $inventory = Inventory::find($id);
      foreach ($input as $key => $v) {
        $inventory->$key = $v;
      }
      $inventory->updated_uid = Auth::id();
      $inventory->updated_at = date("Y-m-d H:i:s");
      $inventory->save();

      DB::commit();

      $dataLog = array();
      $dataLog['request'] = $input;
      $dataLog['response'] = $inventory->toArray();
      $this->_cLog($request, $dataLog);

      $message = trans('core.message_update_success');
      $status = 'success';
      $title = 'Success';
    } catch (\Exception $e) {

      DB::rollback();
      Log::error('Error: Inventory:update :' . $e->getMessage());

      $dataLog = array();
      $dataLog['request'] = $input;
      $dataLog['response'] = array('ErrorMessage' => $e->getMessage());
      $this->_cLog($request, $dataLog);

      $message = trans('core.message_update_error');
      $status = 'error';
      $title = 'Error';
    }

    session(['noit_title' => $title]);
    session(['noit_message' => $message]);
    session(['noit_status' => $status]);

    return redirect()->route('inventory.index');
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
      // $dataLog['response'] = Inventory::find($id)->toArray();
      // $this->_cLog($request, $dataLog);

      Inventory::destroy($id);

      DB::commit();
      Log::info('Successful: inventory:destroy : ', ['id' => $id]);

      $dataLog = array();
      $dataLog['request'] = array('id' => $id);
      $dataLog['response'] = [];
      $this->_cLog($request, $dataLog);

      $message = trans('core.message_del_success');
      $status = 'success';
      $title = 'Success';
    } catch (\Exception $e) {

      DB::rollback();
      Log::error('Error: inventory:destroy :' . $e->getMessage());

      $dataLog = array();
      $dataLog['request'] = array('id' => $id);
      $dataLog['response'] = array('errorMessage' => $e->getMessage());
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
    $select[] = 'inventory.' . 'id';
    foreach ($arrField as $key => $val) {
      if ($val == 1) {
        $select[] = 'inventory.'.$key;
      }
    }
    return $select;
  }

  protected function _easySearch($results, $search=""){
	      $results = $results->leftJoin('billings', 'inventory.billing_id', '=', 'billings.id')->orWhere ('billings.billing_no', 'LIKE','%'. @$search.'%') ;
	      $results = $results->orWhere ('inventory.serial', 'LIKE','%'. @$search.'%') ;
	      $results = $results->orWhere ('inventory.serial_long', 'LIKE','%'. @$search.'%') ;
	      $results = $results->orWhere ('inventory.imei', 'LIKE','%'. @$search.'%') ;
	      $results = $results->orWhere ('inventory.material_no', 'LIKE','%'. @$search.'%') ;
	      $results = $results->orWhere ('inventory.serial_raw', 'LIKE','%'. @$search.'%') ;
	      $results = $results->orWhere ('inventory.active', 'LIKE','%'. @$search.'%') ;
	      $results = $results->orWhere ('inventory.sale_status', 'LIKE','%'. @$search.'%') ;
        return $results;
  }

  protected function _advSearch($results, $input){
        if(@$input->billing_id){
          $results = $results->where('inventory.billing_id',  $input->billing_id);
        }
        if(@$input->serial){
          $results = $results->where('inventory.serial', 'LIKE', "%" .  $input->serial. "%" );
        }
        if(@$input->serial_long){
          $results = $results->where('inventory.serial_long', 'LIKE', "%" .  $input->serial_long. "%" );
        }
        if(@$input->imei){
          $results = $results->where('inventory.imei', 'LIKE', "%" .  $input->imei. "%" );
        }
        if(@$input->material_no){
          $results = $results->where('inventory.material_no', 'LIKE', "%" .  $input->material_no. "%" );
        }
        if(@$input->serial_raw){
          $results = $results->where('inventory.serial_raw', 'LIKE', "%" .  $input->serial_raw. "%" );
        }
        if(@$input->active){
          $results = $results->where('inventory.active',  $input->active);
        }
        if(@$input->sale_status){
          $results = $results->where('inventory.sale_status',  $input->sale_status);
        }
      return $results;
  }

  protected function _getDataBelongs($compact)
  {
		$compact->arrBilling = Billing::where('id','!=',null)
			->orderBy('id')
			->pluck('billing_no','id')	
      ->toArray();
  }

  /**
   * add create log format to add log
   *
   * @param  array  $data Log
   */
  protected function _cLog($request, $data = [])
  {

    $data = (object)$data;

    $newResponse = [];
    $newRequest = [];

    if(@$data->request){
      $dataRequest = $data->request;
    }else{
      $dataRequest = $request->all();
    }

    foreach ($dataRequest as $key => $val) {
      if ($key != '_token' && $key != '_method') {
        if ($key == 'active') {
          if ($val == 1) {
            $val = trans('inventory.active.text_radio.true');
          } else {
            $val = trans('inventory.active.text_radio.false');
          }
        } elseif ($key == 'sale_status') {
          if ($val == 1) {
            $val = trans('inventory.sale_status.text_radio.true');
          } else {
            $val = trans('inventory.sale_status.text_radio.false');
          }
        }

        $newRequest[$key] = $val;
      }
    }
    if (@$data->response) {
      foreach (@$data->response as $key => $val) {
        if ($key == 'active') {
            if ($val == 1) {
              $val = trans('inventory.active.text_radio.true');
            } else {
              $val = trans('inventory.active.text_radio.false');
            }
        }elseif($key == 'sale_status'){
            if ($val == 1) {
              $val = trans('inventory.sale_status.text_radio.true');
            } else {
              $val = trans('inventory.sale_status.text_radio.false');
            }
        }
        $newResponse[$key] = $val;
      }
    }

    $arrLog = array();
    $arrLog['type'] = @$data->type;
    $arrLog['view'] = @$data->view;
    $arrLog['action'] = @$data->action;
    $arrLog['request'] = $newRequest;
    $arrLog['response'] = $newResponse;

    $this->logs->addLogSys2($request, $arrLog);
  }
}

