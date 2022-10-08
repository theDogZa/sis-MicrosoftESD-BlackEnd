<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use App\Models\Billing;

use App\Services\LogsService;

class BillingsController extends Controller
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
      'sold_to' => 1 , 'billing_no' => 1,  'billing_item' => 0,  'billing_at' => 1,  'material_no' => 1,  'material_desc' => 1,  'qty' => 1,  'po_no' => 1,  'vendor_article' => 1,  'active' => 1,  'sale_count' => 1, 'remaining_amount' => 1		];
		$this->arrShowFieldFrom = [
      'sold_to' => 1 , 'billing_no' => 1,  'billing_item' => 0,  'billing_at' => 1,  'material_no' => 1,  'material_desc' => 1,  'qty' => 1,  'po_no' => 1,  'vendor_article' => 1,  'active' => 1,  'sale_count' => 1, 'remaining_amount' => 1 		];
		$this->arrShowFieldView = [
      'sold_to' => 1, 'billing_no' => 1,  'billing_item' => 0,  'billing_at' => 1,  'material_no' => 1,  'material_desc' => 1,  'qty' => 1,  'po_no' => 1,  'vendor_article' => 1,  'active' => 1,  'sale_count' => 1, 'remaining_amount' => 1 		];
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
      'sold_to' => 'required|string|max:255',
      'billing_no' => 'required|string|max:255',
			'billing_item' => 'required|string|max:255',
			'billing_at' => 'required|string|max:255',
			'material_no' => 'required|string|max:255',
			'qty' => 'required|string|max:255',
			'po_no' => 'required|string|max:255',
			'vendor_article' => 'required|string|max:255',
			'active' => 'required|string|max:255',
			'sale_count' => 'required|string|max:255',
      'remaining_amount' => 'required|string|max:255',
			//#Ex
			//'username' => 'required|string|max:20|unique:users,username,' . $data ['id'],
			//'email' => 'required|string|email|max:255|unique:users,email,' . $data ['id'],
			// 'password' => 'required|string|min:6|confirmed',
			//'password' => 'required|string|min:6',
		];
		
		$messages = [
      'sold_to.required' => trans('Billing.sold_to_required'),
			'billing_no.required' => trans('Billing.billing_no_required'),
			'billing_item.required' => trans('Billing.billing_item_required'),
			'billing_at.required' => trans('Billing.billing_at_required'),
			'material_no.required' => trans('Billing.material_no_required'),
			'qty.required' => trans('Billing.qty_required'),
			'po_no.required' => trans('Billing.po_no_required'),
			'vendor_article.required' => trans('Billing.vendor_article_required'),
			'active.required' => trans('Billing.active_required'),
			'sale_count.required' => trans('Billing.sale_count_required'),
      'remaining_amount' => trans('Billing.remaining_amount_required'),
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

    $results = Billing::select($select);

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
    $dataLog['request'] = $request->all();
    $dataLog['response'] = $results->get()->toArray();
    $this->_cLog($request, $dataLog);

    return view('_billings.index', (array) $compact);
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

      return view('_billings.form', (array) $compact);
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

      $billing = new Billing;
      foreach ($input as $key => $v) {
        $billing->$key = $v;
      }
      $billing->created_uid = Auth::id();
      $billing->created_at = date("Y-m-d H:i:s");
      $billing->save();

      DB::commit();
      //Log::info('Successful: Billing:store : ', ['data' => $billing]);

      $dataLog = array();
      $dataLog['request'] = $input;
      $dataLog['response'] = $billing->toArray();
      $this->_cLog($request, $dataLog);

      $message = trans('core.message_insert_success');
      $status = 'success';
      $title = 'Success';
    } catch (\Exception $e) {

      DB::rollback();
      Log::error('Error: Billing:store :' . $e->getMessage());

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

    return redirect()->route('billings.index');
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
    $billing = Billing::select($select)->findOrFail($id);

    $compact->billing = $billing;

    $this->_getDataBelongs($compact);

    $dataLog = array();
    $dataLog['request'] = array('id' => $id);
    $dataLog['response'] = $billing->toArray();
    $this->_cLog($request, $dataLog);

    return view('_billings.form',$billing, (array) $compact);
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
    $compact->billing = Billing::select($select)->findOrFail($id);
    $this->_getDataBelongs($compact);
    
    $dataLog = array();
    $dataLog['request'] = array('id' => $id);
    $dataLog['response'] = $compact->billing->toArray();
    $this->_cLog($request, $dataLog);

    return view('_billings.show', (array) $compact);
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

      $billing = Billing::find($id);
      foreach ($input as $key => $v) {
        $billing->$key = $v;
      }
      $billing->updated_uid = Auth::id();
      $billing->updated_at = date("Y-m-d H:i:s");
      $billing->save();

      DB::commit();
      //Log::info('Successful: Billing:update : ', ['id' => $id, 'data' => $billing]);

      $dataLog = array();
      $dataLog['request'] = $input;
      $dataLog['response'] = $billing->toArray();
      $this->_cLog($request, $dataLog);

      $message = trans('core.message_update_success');
      $status = 'success';
      $title = 'Success';
    } catch (\Exception $e) {

      DB::rollback();
      Log::error('Error: Billing:update :' . $e->getMessage());

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

    return redirect()->route('billings.index');
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

      Billing::destroy($id);

      DB::commit();
      Log::info('Successful: billing:destroy : ', ['id' => $id]);

      $dataLog = array();
      $dataLog['request'] = array('id' => $id);
      $dataLog['response'] = [];
      $this->_cLog($request, $dataLog);

      $message = trans('core.message_del_success');
      $status = 'success';
      $title = 'Success';
    } catch (\Exception $e) {

      DB::rollback();
      Log::error('Error: billing:destroy :' . $e->getMessage());

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
    $select[] = 'billings.' . 'id';
    foreach ($arrField as $key => $val) {
      if ($val == 1) {
        $select[] = 'billings.' . $key;
      }
    }
    return $select;
  }

  protected function _easySearch($results, $search=""){
    
    $results = $results->orWhere('billings.sold_to', 'LIKE', '%' . @$search . '%');
    $results = $results->orWhere ('billings.billing_no', 'LIKE','%'. @$search.'%') ;
    $results = $results->orWhere ('billings.billing_item', 'LIKE','%'. @$search.'%') ;
    $results = $results->orWhere ('billings.billing_at', 'LIKE','%'. @$search.'%') ;
    $results = $results->orWhere ('billings.material_no', 'LIKE','%'. @$search.'%') ;
    $results = $results->orWhere ('billings.material_desc', 'LIKE','%'. @$search.'%') ;
    $results = $results->orWhere ('billings.qty', 'LIKE','%'. @$search.'%') ;
    $results = $results->orWhere ('billings.po_no', 'LIKE','%'. @$search.'%') ;
    $results = $results->orWhere ('billings.vendor_article', 'LIKE','%'. @$search.'%') ;
    $results = $results->orWhere ('billings.active', 'LIKE','%'. @$search.'%') ;
    $results = $results->orWhere ('billings.sale_count', 'LIKE','%'. @$search.'%') ;
    $results = $results->orWhere ('billings.remaining_amount', 'LIKE', '%' . @$search . '%');
    
    return $results;
  }

  protected function _advSearch($results, $input){
    if (@$input->sold_to) {
      $results = $results->where('billings.sold_to', 'LIKE', "%" .  $input->sold_to . "%");
    }
        if(@$input->billing_no){
          $results = $results->where('billings.billing_no', 'LIKE', "%" .  $input->billing_no. "%" );
        }
        if(@$input->billing_item){
          $results = $results->where('billings.billing_item', 'LIKE', "%" .  $input->billing_item. "%" );
        }
        if(@$input->billing_at_start && @$input->billing_at_end){
          $sd = date_create(@$input->billing_at_start);
          $sDate = date_format($sd, "Y-m-d");
          $ed = date_create(@$input->billing_at_end);
          $eDate = date_format($ed, "Y-m-d");
          $results = $results->whereBetween('billings.billing_at',  [$sDate, $eDate]);
        }
        if(@$input->material_no){
          $results = $results->where('billings.material_no', 'LIKE', "%" .  $input->material_no. "%" );
        }
        if(@$input->material_desc){
          $results = $results->where('billings.material_desc', 'LIKE', "%" .  $input->material_desc. "%" );
        }
        if(@$input->qty_start && @$input->qty_end){
          $min = @$input->qty_start;
          $max = @$input->qty_end;
          $results = $results->whereBetween('billings.qty',  [$min, $max]);
        }
        if(@$input->po_no){
          $results = $results->where('billings.po_no', 'LIKE', "%" .  $input->po_no. "%" );
        }
        if(@$input->vendor_article){
          $results = $results->where('billings.vendor_article', 'LIKE', "%" .  $input->vendor_article. "%" );
        }
        if(@$input->active){
          $results = $results->where('billings.active',  $input->active);
        }
        if(@$input->sale_count_start && @$input->sale_count_end){
          $min = @$input->sale_count_start;
          $max = @$input->sale_count_end;
          $results = $results->whereBetween('billings.sale_count',  [$min, $max]);
        }
        if (@$input->remaining_amount_start && @$input->remaining_amount_end) {
          $r_min = @$input->remaining_amount_start;
          $r_max = @$input->remaining_amount_end;
          $results = $results->whereBetween('billings.remaining_amount',  [$r_min, $r_max]);
        }
      return $results;
  }

  protected function _getDataBelongs($compact)
  {
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

    if (@$data->request) {
      $dataRequest = $data->request;
    } else {
      $dataRequest = $request->all();
    }

    foreach ($dataRequest as $key => $val) {
      if ($key != '_token' && $key != '_method') {
        if ($key == 'active') {
          if ($val == 1) {
            $val = trans('billings.active.text_radio.true');
          } else {
            $val = trans('billings.active.text_radio.false');
          }
        }

        $newRequest[$key] = $val;
      }
    }
    if (@$data->response) {
      foreach (@$data->response as $key => $val) {
      if ($key == 'active') {
        if ($val == 1) {
          $val = trans('billings.active.text_radio.true');
        } else {
          $val = trans('billings.active.text_radio.false');
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