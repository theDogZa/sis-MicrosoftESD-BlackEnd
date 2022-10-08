<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use App\Models\Config;
use App\Services\LogsService;

class ConfigsController extends Controller
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
		 'code' => 0,  'type' => 1,  'is_request' => 1,  'is_hide' => 0,  'name' => 1,  'des' => 1,  'val' => 1, 		];
		$this->arrShowFieldFrom = [
		 'code' => 0,  'type' => 1,  'is_request' => 1,  'is_hide' => 0,  'name' => 1,  'des' => 1,  'val' => 1, 		];
		$this->arrShowFieldView = [
		 'code' => 0,  'type' => 1,  'is_request' => 0,  'is_hide' => 0,  'name' => 1,  'des' => 1,  'val' => 1, 		];
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
			'code' => 'required|string|max:255',
			'name' => 'required|string|max:255',
			//#Ex
			//'username' => 'required|string|max:20|unique:users,username,' . $data ['id'],
			//'email' => 'required|string|email|max:255|unique:users,email,' . $data ['id'],
			// 'password' => 'required|string|min:6|confirmed',
			//'password' => 'required|string|min:6',
		];
		
		$messages = [
			'code.required' => trans('Config.code_required'),
			'name.required' => trans('Config.name_required'),
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

    $results = Config::select($select)->where('is_hide',0);

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

    $compact->collection = $results->sortable()->paginate(config('theme.paginator.paginate'));

    $compact->arrShowField = $this->arrShowFieldIndex;

    $dataLog = array();
    $dataLog['request'] = (array)$request->all();
    $dataLog['response'] = $results->get()->toArray();
    $this->_cLog($request, $dataLog);

    return view('_configs.index', (array) $compact);
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

      $dataLog = array();
      $this->_cLog($request, $dataLog);

      return view('_configs.form', (array) $compact);
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

      $config = new Config;
      foreach ($input as $key => $v) {
        $config->$key = $v;
      }

      $config->created_uid = Auth::id();
      $config->created_at = date("Y-m-d H:i:s");
      $config->save();

      DB::commit();
      Log::info('Successful: Config:store : ', ['data' => $config]);

      $dataLog = array();
      $dataLog['request'] = $input;
      $dataLog['response'] = $config->toArray();
      $this->_cLog($request, $dataLog);

      $message = trans('core.message_insert_success');
      $status = 'success';
      $title = 'Success';
    } catch (\Exception $e) {

      DB::rollback();
      Log::error('Error: Config:store :' . $e->getMessage());

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

    return redirect()->route('configs.index');
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
    $config = Config::select($select)->findOrFail($id);

    $compact->config = $config;

    $dataLog = array();
    $dataLog['request'] = array('id' => $id);
    $dataLog['response'] = $config->toArray();
    $this->_cLog($request, $dataLog);

    return view('_configs.form',$config, (array) $compact);
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
    $compact->config = Config::select($select)->findOrFail($id);

    $dataLog = array();
    $dataLog['request'] = array('id' => $id);
    $dataLog['response'] = $compact->config->toArray();
    $this->_cLog($request, $dataLog);

    return view('_configs.show', (array) $compact);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */

  public function update(Request $request, $id) {
  
    $input = (object) $request->except(['_token', '_method']);
  
    try {
      DB::beginTransaction();

      $config = Config::find($id);
      foreach ($input as $key => $v) {
        $config->$key = $v;
      }
      $config->updated_uid = Auth::id();
      $config->updated_at = date("Y-m-d H:i:s");
      $config->save();

      DB::commit();
      Log::info('Successful: Config:update : ', ['id' => $id, 'data' => $config]);

      $dataLog = array();
      $dataLog['request'] = $input;
      $dataLog['response'] = $config->toArray();
      $this->_cLog($request, $dataLog);

      $message = trans('core.message_update_success');
      $status = 'success';
      $title = 'Success';
    } catch (\Exception $e) {

      DB::rollback();
      Log::error('Error: Config:update :' . $e->getMessage());

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

    return redirect()->route('configs.index');
  }

  
  /**
   * Field list To Select data form db 
   *
   * @param  array  $arrField
   * @return array select data
   */
  protected function _listToSelect($arrField)
  {
    $select[] = 'configs.id';
    foreach ($arrField as $key => $val) {
      if ($val == 1) {
        $select[] = 'configs.'.$key;
      }
    }
    return $select;
  }

  protected function _easySearch($results, $search=""){
	      $results = $results->orWhere ('configs.code', 'LIKE','%'. @$search.'%') ;
	      $results = $results->orWhere ('configs.type', 'LIKE','%'. @$search.'%') ;
	      $results = $results->orWhere ('configs.name', 'LIKE','%'. @$search.'%') ;
	      $results = $results->orWhere ('configs.des', 'LIKE','%'. @$search.'%') ;
	      $results = $results->orWhere ('configs.val', 'LIKE','%'. @$search.'%') ;
        return $results;
  }

  protected function _advSearch($results, $input){
        if(@$input->code){
          $results = $results->where('configs.code', 'LIKE', "%" .  $input->code. "%" );
        }
        if(@$input->type){
          $results = $results->where('configs.type', 'LIKE', "%" .  $input->type. "%" );
        }
        if(@$input->name){
          $results = $results->where('configs.name', 'LIKE', "%" .  $input->name. "%" );
        }
        if(@$input->des){
          $results = $results->where('configs.des', 'LIKE', "%" .  $input->des. "%" );
        }
        if(@$input->val){
          $results = $results->where('configs.val', 'LIKE', "%" .  $input->val. "%" );
        }
      return $results;
  }

  protected function _getDataBelongs($compact)
  {
  
  }

    protected function _cLogSys($request, $id = '')
    {
        $newData = [];
        $newRequest = [];

        foreach ($request->all() as $key => $val) {
            if ($key != '_token' && $key != '_method') {
                $newRequest[$key] = $val;
            }
        }

        if ($id) {
            $select = $this->_listToSelect($this->arrShowFieldView);
            $data = Config::select($select)->findOrFail($id)->toArray();

            foreach ($data as $key => $val) {
                $newData[$key] = $val;
            }
        }
        $this->logs->addLogSys($request, $newData, $newRequest);
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
        $newRequest[$key] = $val;
      }
    }
    if (@$data->response) {
    foreach (@$data->response as $key => $val) {
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

/** 
 * CRUD Laravel
 * Master ฺBY Kepex  =>  https://github.com/kEpEx/laravel-crud-generator
 * Modify/Update BY PRASONG PUTICHANCHAI
 * 
 * Latest Update : 09/09/2020 10:32
 * Version : ver.1.00.00
 *
 * File Create : 2022-01-19 19:14:35 *
 */