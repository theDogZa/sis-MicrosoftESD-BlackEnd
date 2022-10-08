<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use App\Models\UsersPermission;
use App\Models\User;
use App\Models\Permission;

use App\Services\LogsService;

class UsersPermissionsController extends Controller
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

    $this->arrShowFieldIndex = [
		 'user_id' => 1,  'permission_id' => 1,  'role_id' => 1,  'active' => 1, 		];
		$this->arrShowFieldFrom = [
		 'user_id' => 1,  'permission_id' => 1,  'role_id' => 1,  'active' => 1, 		];
		$this->arrShowFieldView = [
		 'user_id' => 1,  'permission_id' => 1,  'role_id' => 1,  'active' => 1, 		];
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
			'user_id' => 'required|string|max:255',
			'permission_id' => 'required|string|max:255',
			'active' => 'required|string|max:255',
			//#Ex
			//'username' => 'required|string|max:20|unique:users,username,' . $data ['id'],
			//'email' => 'required|string|email|max:255|unique:users,email,' . $data ['id'],
			// 'password' => 'required|string|min:6|confirmed',
			//'password' => 'required|string|min:6',
		];
		
		$messages = [
			'user_id.required' => trans('Users_permission.user_id_required'),
			'permission_id.required' => trans('Users_permission.permission_id_required'),
			'active.required' => trans('Users_permission.active_required'),
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

    $results = UsersPermission::select($select);

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

    $this->_cLogSys($request);

    return view('_users_permissions.index', (array) $compact);
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
    $this->_cLogSys($request);

      return view('_users_permissions.form', (array) $compact);
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

      $users_permission = new UsersPermission;
      foreach ($input as $key => $v) {
        $users_permission->$key = $v;
      }
      $users_permission->created_uid = Auth::id();
      $users_permission->created_at = date("Y-m-d H:i:s");
      $users_permission->save();

      DB::commit();
      Log::info('Successful: Users_permission:store : ', ['data' => $users_permission]);
      $this->_cLogSys($request, $users_permission->id);

      $message = trans('core.message_insert_success');
      $status = 'success';
      $title = 'Success';
    } catch (\Exception $e) {

      DB::rollback();
      Log::error('Error: Users_permission:store :' . $e->getMessage());
      $this->_cLogSys($request);
      $message = trans('core.message_insert_error');
      $status = 'error';
      $title = 'Error';
    }

    session(['noit_title' => $title]);
    session(['noit_message' => $message]);
    session(['noit_status' => $status]);

    return redirect()->route('users_permissions.index');
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
    $users_permission = UsersPermission::select($select)->findOrFail($id);

    $compact->users_permission = $users_permission;

    $this->_getDataBelongs($compact);
    $this->_cLogSys($request, $id);

    return view('_users_permissions.form',$users_permission, (array) $compact);
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
    $compact->users_permission = UsersPermission::select($select)->findOrFail($id);
    $this->_getDataBelongs($compact);
    $this->_cLogSys($request);
    return view('_users_permissions.show', (array) $compact);
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

      $users_permission = UsersPermission::find($id);
      foreach ($input as $key => $v) {
        $users_permission->$key = $v;
      }
      $users_permission->updated_uid = Auth::id();
      $users_permission->updated_at = date("Y-m-d H:i:s");
      $users_permission->save();

      DB::commit();
      Log::info('Successful: Users_permission:update : ', ['id' => $id, 'data' => $users_permission]);
      $this->_cLogSys($request, $id);

      $message = trans('core.message_update_success');
      $status = 'success';
      $title = 'Success';
    } catch (\Exception $e) {

      DB::rollback();
      Log::error('Error: Users_permission:update :' . $e->getMessage());
      $this->_cLogSys($request);
      $message = trans('core.message_update_error');
      $status = 'error';
      $title = 'Error';
    }

    session(['noit_title' => $title]);
    session(['noit_message' => $message]);
    session(['noit_status' => $status]);

    return redirect()->route('users_permissions.index');
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
      $this->_cLogSys($request, $id);
      UsersPermission::destroy($id);

      DB::commit();
      Log::info('Successful: users_permission:destroy : ', ['id' => $id]);

      $message = trans('core.message_del_success');
      $status = 'success';
      $title = 'Success';
    } catch (\Exception $e) {

      DB::rollback();
      Log::error('Error: users_permission:destroy :' . $e->getMessage());
      $this->_cLogSys($request);
      $message = trans('core.message_del_error');
      $status = 'error';
      $title = 'Error';
    }

    $response->title = $title;
    $response->status = $status;
    $response->message = $message;

    return (array) $response;

  }

   public function listByUser(Request $request, $id)
  {

    $compact = (object) array();
  
    $compact->user = User::select('username')->findOrFail($id);
    $compact->collection = UsersPermission::select('permission_id','role_id')
                          ->leftJoin('permissions', 'users_permissions.permission_id', '=', 'permissions.id')
                          ->where('users_permissions.active', 1)
                          ->where('permissions.active', 1)
                          ->where('user_id', $id)
                          ->orderBy('role_id')
                          ->orderBy('permissions.group_code')
                          ->orderBy('permissions.name')
                          ->get();

    $compact->permissionsGroup = config('auth.permission_group_code');

    $dataLog = array();
    $dataLog['request'] = array('id' => $id);
    $dataLog['response'] = $compact->permissionsGroup;
    $this->_cLog($request, $dataLog);

    return view('_users_permissions.list_permissions', (array) $compact);
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
	      $results = $results->orWhere ('Users_permissions.user_id', 'LIKE','%'. @$search.'%') ;
	      $results = $results->orWhere ('Users_permissions.permission_id', 'LIKE','%'. @$search.'%') ;
	      $results = $results->orWhere ('Users_permissions.role_id', 'LIKE','%'. @$search.'%') ;
	      $results = $results->orWhere ('Users_permissions.active', 'LIKE','%'. @$search.'%') ;
        return $results;
  }

  protected function _advSearch($results, $input){
        if(@$input->user_id){
          $results = $results->where('Users_permissions.user_id',  $input->user_id);
        }
        if(@$input->permission_id){
          $results = $results->where('Users_permissions.permission_id',  $input->permission_id);
        }
        if(@$input->role_id_start && @$input->role_id_end){
          $min = @$input->role_id_start;
          $max = @$input->role_id_end;
          $results = $results->whereBetween('Users_permissions.role_id',  [$min, $max]);
        }
        if(@$input->active){
          $results = $results->where('Users_permissions.active',  $input->active);
        }
      return $results;
  }

  protected function _getDataBelongs($compact)
  {
		  $compact->arrUser = User::where('id','!=',null)
			->orderBy('id')
			->pluck('id', 'username')	
      ->toArray();
      
		  $compact->arrPermission = Permission::where('id','!=',null)
			->orderBy('id')
			->pluck('id','id')	
      ->toArray();
  }

  protected function _cLogSys($request, $id = '')
  {
    $newData = [];
    $newRequest = [];

    foreach ($request->all() as $key => $val) {
      if ($key != '_token' && $key != '_method') {
        if ($key == 'active') {
          if ($val == 1) {
            $val = trans('users_permission.active.text_radio.true');
          } else {
            $val = trans('users_permission.active.text_radio.false');
          }
        }

        $newRequest[$key] = $val;
      }
    }

    if ($id) {
      $select = $this->_listToSelect($this->arrShowFieldView);
      $data = UsersPermission::select($select)->findOrFail($id)->toArray();

      foreach ($data as $key => $val) {
        if ($key == 'active') {
          if ($val == 1) {
            $val = trans('users_permission.active.text_radio.true');
          } else {
            $val = trans('users_permission.active.text_radio.false');
          }
        }

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
        if ($key == 'active') {
          if ($val == 1) {
            $val = trans('users_permission.active.text_radio.true');
          } else {
            $val = trans('users_permission.active.text_radio.false');
          }
        }
        
        $newRequest[$key] = $val;
      }
    }
    if (@$data->response) {
      foreach (@$data->response as $key => $val) {
        if ($key == 'active') {
          if ($val == 1) {
            $val = trans('users_permission.active.text_radio.true');
          } else {
            $val = trans('users_permission.active.text_radio.false');
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

/** 
 * CRUD Laravel
 * Master ฺBY Kepex  =>  https://github.com/kEpEx/laravel-crud-generator
 * Modify/Update BY PRASONG PUTICHANCHAI
 * 
 * Latest Update : 09/09/2020 10:32
 * Version : ver.1.00.00
 *
 * File Create : 2020-09-25 11:01:08 *
 */