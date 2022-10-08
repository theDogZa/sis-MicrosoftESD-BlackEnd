<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use App\Models\OrderItem;
use App\Models\Inventory;

use App\Services\LogsService;

class OrderItemsController extends Controller
{
  /**
   * Instantiate a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->logs = new LogsService();
    
    Cache::flush();
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header('Content-Type: text/html');

    $this->arrShowFieldIndex = [
		 'order_id' => 1,  'inventory_id' => 1,  'license_key' => 1,  'license_at' => 1, 'count_resend' => 1];
		$this->arrShowFieldFrom = [
		 'order_id' => 1,  'inventory_id' => 1,  'license_key' => 1,  'license_at' => 1, 'count_resend' => 1];
		$this->arrShowFieldView = [
		 'order_id' => 1,  'inventory_id' => 1,  'license_key' => 1,  'license_at' => 1, 'count_resend' => 1];
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
			'order_id' => 'required|string|max:255',
			'inventory_id' => 'required|string|max:255',
			//#Ex
			//'username' => 'required|string|max:20|unique:users,username,' . $data ['id'],
			//'email' => 'required|string|email|max:255|unique:users,email,' . $data ['id'],
			// 'password' => 'required|string|min:6|confirmed',
			//'password' => 'required|string|min:6',
		];
		
		$messages = [
			'order_id.required' => trans('OrderItem.order_id_required'),
			'inventory_id.required' => trans('OrderItem.inventory_id_required'),
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

    $results = OrderItem::select($select);

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

    return view('_order_items.index', (array) $compact);
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

      return view('_order_items.form', (array) $compact);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $this->validator($request->all())->validate();

    $input = (object) $request->except(['_token', '_method']);

    try {
      DB::beginTransaction();

      $orderitem = new OrderItem;
      foreach ($input as $key => $v) {
        $orderitem->$key = $v;
      }
      $orderitem->created_uid = Auth::id();
      $orderitem->created_at = date("Y-m-d H:i:s");
      $orderitem->save();

      DB::commit();
      Log::info('Successful: OrderItem:store : ', ['data' => $orderitem]);

      $message = trans('core.message_insert_success');
      $status = 'success';
      $title = 'Success';
    } catch (\Exception $e) {

      DB::rollback();
      Log::error('Error: OrderItem:store :' . $e->getMessage());

      $message = trans('core.message_insert_error');
      $status = 'error';
      $title = 'Error';
    }

    session(['noit_title' => $title]);
    session(['noit_message' => $message]);
    session(['noit_status' => $status]);

    return redirect()->route('order_items.index');
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
    $orderitem = OrderItem::select($select)->findOrFail($id);

    $compact->orderitem = $orderitem;

    $this->_getDataBelongs($compact);

    return view('_order_items.form',$orderitem, (array) $compact);
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
    $compact->orderitem = OrderItem::select($select)->findOrFail($id);
    $this->_getDataBelongs($compact);
    return view('_order_items.show', (array) $compact);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */

  public function update(Request $request, $id) {
  
    $this->validator($request->all())->validate();

    $input = (object) $request->except(['_token', '_method']);
  
    try {
      DB::beginTransaction();

      $orderitem = OrderItem::find($id);
      foreach ($input as $key => $v) {
        $orderitem->$key = $v;
      }
      $orderitem->updated_uid = Auth::id();
      $orderitem->updated_at = date("Y-m-d H:i:s");
      $orderitem->save();

      DB::commit();
      Log::info('Successful: OrderItem:update : ', ['id' => $id, 'data' => $orderitem]);

      $message = trans('core.message_update_success');
      $status = 'success';
      $title = 'Success';
    } catch (\Exception $e) {

      DB::rollback();
      Log::error('Error: OrderItem:update :' . $e->getMessage());

      $message = trans('core.message_update_error');
      $status = 'error';
      $title = 'Error';
    }

    session(['noit_title' => $title]);
    session(['noit_message' => $message]);
    session(['noit_status' => $status]);

    return redirect()->route('order_items.index');
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

      OrderItem::destroy($id);

      DB::commit();
      Log::info('Successful: orderitem:destroy : ', ['id' => $id]);

      $message = trans('core.message_del_success');
      $status = 'success';
      $title = 'Success';
    } catch (\Exception $e) {

      DB::rollback();
      Log::error('Error: orderitem:destroy :' . $e->getMessage());

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
    $select[] = 'id';
    foreach ($arrField as $key => $val) {
      if ($val == 1) {
        $select[] = $key;
      }
    }
    return $select;
  }

  protected function _easySearch($results, $search=""){
	      $results = $results->orWhere ('order_items.order_id', 'LIKE','%'. @$search.'%') ;
	      $results = $results->orWhere ('order_items.inventory_id', 'LIKE','%'. @$search.'%') ;
	      $results = $results->orWhere ('order_items.license_key', 'LIKE','%'. @$search.'%') ;
	      $results = $results->orWhere ('order_items.license_at', 'LIKE','%'. @$search.'%') ;
        return $results;
  }

  protected function _advSearch($results, $input){
        if(@$input->order_id_start && @$input->order_id_end){
          $min = @$input->order_id_start;
          $max = @$input->order_id_end;
          $results = $results->whereBetween('order_items.order_id',  [$min, $max]);
        }
        if(@$input->inventory_id){
          $results = $results->where('order_items.inventory_id',  $input->inventory_id);
        }
        if(@$input->license_key){
          $results = $results->where('order_items.license_key', 'LIKE', "%" .  $input->license_key. "%" );
        }
        if(@$input->license_at_start && @$input->license_at_end){
          $sd = date_create($input->license_at_start . ":00");
          $sDate = date_format($sd, "Y-m-d H:i:s");
          $ed = date_create(@$input->license_at_end . ":59");
          $eDate = date_format($ed, "Y-m-d H:i:s");
          $results = $results->whereBetween('order_items.license_at',  [$sDate, $eDate]);
        }
      return $results;
  }

  protected function _getDataBelongs($compact)
  {
		  $compact->arrInventory = Inventory::where('id','!=',null)
			->orderBy('id')
			->pluck('id','id')	
      ->toArray();
  }
}

/** 
 * CRUD Laravel
 * Master ฺBY Kepex  =>  https://github.com/kEpEx/laravel-crud-generator
 * Modify/Update BY PRASONG PUTICHANCHAI
 * 
 * Latest Update : 09/09/2020 10:32
 * Version : ver.1.00.00
 *
 * File Create : 2022-01-05 12:25:55 *
 */