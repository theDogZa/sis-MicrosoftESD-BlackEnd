<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use App\Models\Permission;

use App\Services\LogsService;

class PermissionsController extends Controller
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
		 'slug' => 1,  'name' => 1,  'description' => 1,  'group_code' => 1,  'active' => 1, 		];
		$this->arrShowFieldFrom = [
		 'slug' => 1,  'name' => 1,  'description' => 1,  'group_code' => 1,  'active' => 1, 		];
		$this->arrShowFieldView = [
		 'slug' => 1,  'name' => 1,  'description' => 1,  'group_code' => 1,  'active' => 1, 		];
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
			'slug' => 'required|string|max:255|unique:slug',
			'active' => 'required|string|max:255',
			//#Ex
			//'username' => 'required|string|max:20|unique:users,username,' . $data ['id'],
			//'email' => 'required|string|email|max:255|unique:users,email,' . $data ['id'],
			// 'password' => 'required|string|min:6|confirmed',
			//'password' => 'required|string|min:6',
		];
		
		$messages = [
			'slug.required' => trans('Permission.slug_required'),
			'active.required' => trans('Permission.active_required'),
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

    $results = Permission::select($select);

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

    return view('_permissions.index', (array) $compact);
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

      return view('_permissions.form', (array) $compact);
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

      $permission = new Permission;
      foreach ($input as $key => $v) {
        $permission->$key = $v;
      }
      $permission->created_uid = Auth::id();
      $permission->created_at = date("Y-m-d H:i:s");
      $permission->save();

      DB::commit();
      Log::info('Successful: Permission:store : ', ['data' => $permission]);
      $this->_cLogSys($request, $permission->id);

      $message = trans('core.message_insert_success');
      $status = 'success';
      $title = 'Success';
    } catch (\Exception $e) {

      DB::rollback();
      Log::error('Error: Permission:store :' . $e->getMessage());
      $this->_cLogSys($request);
      $message = trans('core.message_insert_error');
      $status = 'error';
      $title = 'Error';
    }

    session(['noit_title' => $title]);
    session(['noit_message' => $message]);
    session(['noit_status' => $status]);

    return redirect()->route('permissions.index');
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
    $permission = Permission::select($select)->findOrFail($id);

    $compact->permission = $permission;

    $this->_getDataBelongs($compact);
    $this->_cLogSys($request, $id);

    return view('_permissions.form',$permission, (array) $compact);
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
    $compact->permission = Permission::select($select)->findOrFail($id);
    $this->_getDataBelongs($compact);
    $this->_cLogSys($request);
    return view('_permissions.show', (array) $compact);
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

      $permission = Permission::find($id);
      foreach ($input as $key => $v) {
        $permission->$key = $v;
      }
      $permission->updated_uid = Auth::id();
      $permission->updated_at = date("Y-m-d H:i:s");
      $permission->save();

      DB::commit();
      Log::info('Successful: Permission:update : ', ['id' => $id, 'data' => $permission]);
      
      $this->_cLogSys($request, $id);

      $message = trans('core.message_update_success');
      $status = 'success';
      $title = 'Success';
    } catch (\Exception $e) {

      DB::rollback();
      Log::error('Error: Permission:update :' . $e->getMessage());
      $this->_cLogSys($request);

      $message = trans('core.message_update_error');
      $status = 'error';
      $title = 'Error';
    }

    session(['noit_title' => $title]);
    session(['noit_message' => $message]);
    session(['noit_status' => $status]);

    return redirect()->route('permissions.index');
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
      Permission::destroy($id);

      DB::commit();
      Log::info('Successful: permission:destroy : ', ['id' => $id]);

      $message = trans('core.message_del_success');
      $status = 'success';
      $title = 'Success';
    } catch (\Exception $e) {

      DB::rollback();
      Log::error('Error: permission:destroy :' . $e->getMessage());
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
	      $results = $results->orWhere ('Permissions.slug', 'LIKE','%'. @$search.'%') ;
	      $results = $results->orWhere ('Permissions.name', 'LIKE','%'. @$search.'%') ;
	      $results = $results->orWhere ('Permissions.description', 'LIKE','%'. @$search.'%') ;
	      $results = $results->orWhere ('Permissions.group_code', 'LIKE','%'. @$search.'%') ;
	      $results = $results->orWhere ('Permissions.active', 'LIKE','%'. @$search.'%') ;
        return $results;
  }

  protected function _advSearch($results, $input){
        if(@$input->slug){
          $results = $results->where('Permissions.slug', 'LIKE', "%" .  $input->slug. "%" );
        }
        if(@$input->name){
          $results = $results->where('Permissions.name', 'LIKE', "%" .  $input->name. "%" );
        }
        if(@$input->description){
          $results = $results->where('Permissions.description', 'LIKE', "%" .  $input->description. "%" );
        }
        if(@$input->group_code){
          $results = $results->where('Permissions.group_code', 'LIKE', "%" .  $input->group_code. "%" );
        }
        if(@$input->active){
          $results = $results->where('Permissions.active',  $input->active);
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
        if ($key == 'active') {
          if ($val == 1) {
            $val = trans('permission.active.text_radio.true');
          } else {
            $val = trans('permission.active.text_radio.false');
          }
        }
        
        $newRequest[$key] = $val;
      }
    }

    if ($id) {
      $select = $this->_listToSelect($this->arrShowFieldView);
      $data = Permission::select($select)->findOrFail($id)->toArray();

      foreach ($data as $key => $val) {
        if ($key == 'active') {
          if ($val == 1) {
            $val = trans('permission.active.text_radio.true');
          } else {
            $val = trans('permission.active.text_radio.false');
          }
        }

        $newData[$key] = $val;
      }
    }
    $this->logs->addLogSys($request, $newData, $newRequest);
  }

}