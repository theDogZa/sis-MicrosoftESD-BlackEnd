<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use App\Models\Role;
use App\Models\UsersPermission;
use App\Models\RolesPermission;
use App\Models\UsersRole;

use App\Services\LogsService;

class RolesController extends Controller
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
		 'slug' => 0,  'name' => 1,  'description' => 1,  'active' => 1, 		];
		$this->arrShowFieldFrom = [
		 'slug' => 0,  'name' => 1,  'description' => 1,  'active' => 1, 		];
		$this->arrShowFieldView = [
		 'slug' => 0,  'name' => 1,  'description' => 1,  'active' => 1, 		];
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
			//'slug' => 'required|string|max:255',
			'name' => 'required|string|max:255',
			'active' => 'required|string|max:255',
			//#Ex
			//'username' => 'required|string|max:20|unique:users,username,' . $data ['id'],
			//'email' => 'required|string|email|max:255|unique:users,email,' . $data ['id'],
			// 'password' => 'required|string|min:6|confirmed',
			//'password' => 'required|string|min:6',
		];
		
		$messages = [
			//'slug.required' => trans('Role.slug_required'),
			'name.required' => trans('Role.name_required'),
			'active.required' => trans('Role.active_required'),
			//#Ex
			//'email.unique'  => 'Email already taken' ,
			//'username.unique'  => 'Username "' . $data['username'] . '" already taken',
			//'email.email' =>'Email type',
		];

		return Validator::make($data,$rules,$messages);
	}

  public function index(Request $request)
  {
    if ($request->user()->hasRole('developer')) {
      $this->arrShowFieldIndex['slug'] = 1;
    }

    $compact = (object) array();

    $select = $this->_listToSelect($this->arrShowFieldIndex);

    $results = Role::select($select);
    
    if(!$request->user()->hasRole('developer')){
      $results->where('id','!=',1);
    }

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

    return view('_roles.index', (array) $compact);
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

      return view('_roles.form', (array) $compact);
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

      $role = new Role;
      foreach ($input as $key => $v) {
        $role->$key = $v;
      }
      $role->slug = strtolower(str_replace(" ", "_", $input->name));
      $role->created_uid = Auth::id();
      $role->created_at = date("Y-m-d H:i:s");
      $role->save();

      DB::commit();
      Log::info('Successful: Role:store : ', ['data' => $role]);
      
      $dataLog = array();
      $dataLog['request'] = $input;
      $dataLog['response'] = $role->toArray();
      $this->_cLog($request, $dataLog);

      $message = trans('core.message_insert_success');
      $status = 'success';
      $title = 'Success';

    } catch (\Exception $e) {

      DB::rollback();
      Log::error('Error: Role:store :' . $e->getMessage());
  
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

    return redirect()->route('roles.index');
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit(Request $request, $id)
  {
    if ($request->user()->hasRole('developer')) {
      $this->arrShowFieldFrom['slug'] = 1;
    }

    if (!$request->user()->hasRole('developer') && $id == 1) {
      abort(404);
    }
    
    $select = $this->_listToSelect($this->arrShowFieldFrom);

    $compact = (object) array();
    $compact->arrShowField = $this->arrShowFieldFrom;
    $role = Role::select($select)->findOrFail($id);

    $compact->role = $role;

    $this->_getDataBelongs($compact);

    $dataLog = array();
    $dataLog['request'] = array('id' => $id);
    $dataLog['response'] = $role->toArray();
    $this->_cLog($request, $dataLog);

    return view('_roles.form',$role, (array) $compact);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show(Request $request, $id)
  {
    if ($request->user()->hasRole('developer')) {
      $this->arrShowFieldView['slug'] = 1;
    }

    if (!$request->user()->hasRole('developer') && $id==1) {
      abort(404);
    }
    
    $select = $this->_listToSelect($this->arrShowFieldView);

    $compact = (object) array();
    $compact->arrShowField = $this->arrShowFieldView;
    $compact->role = Role::select($select)->findOrFail($id);

    $compact->usersRole = UsersRole::select('users.username', 'users.first_name', 'users.last_name')
    ->leftJoin('users', 'users_roles.user_id', '=', 'users.id')
    ->where('users_roles.role_id', $id)
    ->where('users_roles.active', true)
    ->orderBy('users.username')
    ->get();

    $compact->rolesPermission = RolesPermission::select('permissions.name', 'permissions.group_code')
    ->leftJoin('permissions', 'roles_permissions.permission_id', '=', 'permissions.id')
    ->where('roles_permissions.role_id', $id)
    ->where('roles_permissions.active', true)
    //->orderBy('permissions.group_code')
    ->get();

    $compact->permissionsGuoup = config('auth.permission_group_code');

    $dataLog = array();
    $dataLog['request'] = array('id' => $id);
    $dataLog['response'] = $compact->role->toArray();
    $this->_cLog($request, $dataLog);

    return view('_roles.show', (array) $compact);
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

      //$select = $this->_listToSelect($this->arrShowFieldFrom);
      //$oldrole = Role::select($select)->findOrFail($id)->toArray();

      $role = Role::findOrFail($id); 
      foreach ($input as $key => $v) {
        $role->$key = $v;
      }
      $role->updated_uid = Auth::id();
      $role->updated_at = date("Y-m-d H:i:s");
      $role->save();

      DB::commit();
      Log::info('Successful: Role:update : ', ['id' => $id, 'data' => $role]);

      $dataLog = array();
      $dataLog['request'] = $input;
      $dataLog['response'] = $role->toArray();
      $this->_cLog($request, $dataLog);

      $message = trans('core.message_update_success');
      $status = 'success';
      $title = 'Success';
    } catch (\Exception $e) {

      DB::rollback();
      Log::error('Error: Role:update :' . $e->getMessage());
      
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

    return redirect()->route('roles.index');
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

      //$this->_cLogSysDel($request, $id);
      // $dataLog = array();
      // $dataLog['request'] = array('id' => $id);
      // $dataLog['response'] = Role::find($id)->toArray();
      // $this->_cLog($request, $dataLog);

      $isDelRolesPermission = RolesPermission::where('role_id', $id)->delete();
      $isDelUsersPermission = UsersPermission::where('role_id', $id)->delete();
      $isDelUsersRole = UsersRole::where('role_id', $id)->delete();

      Log::info('Successful: role:destroy : ', ['isDelUsersRole' => $isDelUsersRole, 'isDelUsersPermission' => $isDelUsersPermission, 'isDelRolesPermission' => $isDelRolesPermission]);
      $isDelRole = Role::destroy($id);
      Log::error('Error: role:isDelRole :' . $isDelRole);

      $dataLog = array();
      $dataLog['request'] = array('id' => $id);
      $dataLog['response'] = [];
      $this->_cLog($request, $dataLog);
      
      DB::commit();
      Log::info('Successful: role:destroy : ', ['id' => $id]);

      $message = trans('core.message_del_success');
      $status = 'success';
      $title = 'Success';
    } catch (\Exception $e) {

      DB::rollback();
      Log::error('Error: role:destroy :' . $e->getMessage());

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
    $select[] = 'id';
    foreach ($arrField as $key => $val) {
      if ($val == 1) {
        $select[] = $key;
      }
    }
    return $select;
  }

  protected function _easySearch($results, $search=""){
    $results->where(function ($results) use ($search) {

      return $results->orWhere('Roles.name', 'LIKE', '%' . @$search . '%')
        ->orWhere('Roles.description', 'LIKE', '%' . @$search . '%')
        ->orWhere('Roles.active', 'LIKE', '%' . @$search . '%');
    });
	      // $results = $results->orWhere ('Roles.slug', 'LIKE','%'. @$search.'%') ;
	      // $results = $results->orWhere ('Roles.name', 'LIKE','%'. @$search.'%') ;
	      // $results = $results->orWhere ('Roles.description', 'LIKE','%'. @$search.'%') ;
	      // $results = $results->orWhere ('Roles.active', 'LIKE','%'. @$search.'%') ;
        return $results;
  }

  protected function _advSearch($results, $input){
        if(@$input->slug){
          $results = $results->where('Roles.slug', 'LIKE', "%" .  $input->slug. "%" );
        }
        if(@$input->name){
          $results = $results->where('Roles.name', 'LIKE', "%" .  $input->name. "%" );
        }
        if(@$input->description){
          $results = $results->where('Roles.description', 'LIKE', "%" .  $input->description. "%" );
        }
        if(@$input->active != null){
          $results = $results->where('Roles.active',  $input->active);
        }
      return $results;
  }

  protected function _getDataBelongs($compact)
  {
  }

  // protected function _cLogSysDel($request, $role_id = 0)
  // {
  //   $newData = [];
  //   $newRequest = [];
  
  //   if ($role_id) {

  //     $Role = Role::select('name')->findOrFail($role_id)->toArray();
  //     $newData['RoleName'] = $Role['name'];

  //     $UsersRole = UsersRole::select('users.username')->where('role_id', $role_id)
  //     ->leftJoin('users', 'users_roles.user_id', '=', 'users.id')->get();

  //     $a1 = [];
  //     $a2 = [];

  //     foreach ($UsersRole as $key => $val) {
  //       $a2[] = $val->username;
  //     }

  //     $newData['username'] = $a2;
    
  //     $RolesPermission = RolesPermission::select('permissions.name')->where('role_id', $role_id)
  //     ->leftJoin('permissions', 'roles_permissions.permission_id', '=', 'permissions.id')->get();
  
  //     foreach ($RolesPermission as $key => $val) {
  //       $a1[] = $val->name;
  //     }

  //     $newData['Permissions'] = $a1;
  //   }

  //   foreach ($request->all() as $key => $val) {
  //     if ($key != '_token' && $key != '_method' && $key != 'slug') {
  //       if ($key == 'active') {
  //         if ($val == 1) {
  //           $val = trans('roles.active.text_radio.true');
  //         } else {
  //           $val = trans('roles.active.text_radio.false');
  //         }
  //       }
  //       $newRequest[$key] = $val;
  //     }
  //   }

  //   $this->logs->addLogSys($request, $newData, $newRequest);

  // }

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
      if ($key != '_token' && $key != '_method' && $key != 'slug') {
        if ($key == 'active') {
          if ($val == 1) {
            $val = trans('roles.active.text_radio.true');
          } else {
            $val = trans('roles.active.text_radio.false');
          }
        }

        $newRequest[$key] = $val;
      }
    }
    if (@$data->response) {
      foreach (@$data->response as $key => $val) {
        if ($key != 'id' && $key != 'slug' && $key != 'created_uid' && $key != 'updated_uid' && $key != 'created_at' && $key != 'updated_at') {
          if ($key == 'active') {
            if ($val == 1) {
              $val = trans('roles.active.text_radio.true');
            } else {
              $val = trans('roles.active.text_radio.false');
            }
          }
          $newResponse[$key] = $val;
        }
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
 * File Create : 2020-09-22 15:47:51 *
 */