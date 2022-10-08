<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use App\Models\Example;
use App\Models\User;

class ExamplesController extends Controller
{
  /**
   * Instantiate a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    //$this->middleware('auth');
    //$this->middleware('RolePermission');
    Cache::flush();
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header('Content-Type: text/html');

    $this->arrShowFieldIndex = [
		 'parent_id' => 1,  'users_id' => 1,  'title' => 1,  'body' => 1,  'amount' => 1,  'date' => 1,  'time' => 1,  'datetime' => 1,  'status' => 1,  'active' => 1, 		];
		$this->arrShowFieldFrom = [
		 'parent_id' => 1,  'users_id' => 1,  'title' => 1,  'body' => 1,  'amount' => 1,  'date' => 1,  'time' => 1,  'datetime' => 1,  'status' => 1,  'active' => 1, 		];
		$this->arrShowFieldView = [
		 'parent_id' => 1,  'users_id' => 1,  'title' => 1,  'body' => 1,  'amount' => 1,  'date' => 1,  'time' => 1,  'datetime' => 1,  'status' => 1,  'active' => 1, 		];
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
			'users_id' => 'required|string|max:255',
			'title' => 'required|string|max:255',
			'body' => 'required|string|max:255',
			'amount' => 'required|string|max:255',
			'datetime' => 'required|string|max:255',
			'active' => 'required|string|max:255',
			//#Ex
			//'username' => 'required|string|max:20|unique:users,username,' . $data ['id'],
			//'email' => 'required|string|email|max:255|unique:users,email,' . $data ['id'],
			// 'password' => 'required|string|min:6|confirmed',
			//'password' => 'required|string|min:6',
		];
		
		$messages = [
			'users_id.required' => trans('Example.users_id_required'),
			'title.required' => trans('Example.title_required'),
			'body.required' => trans('Example.body_required'),
			'amount.required' => trans('Example.amount_required'),
			'datetime.required' => trans('Example.datetime_required'),
			'active.required' => trans('Example.active_required'),
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

    $results = Example::select($select);

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

    return view('_examples.index', (array) $compact);
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

      return view('_examples.form', (array) $compact);
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

      $example = new Example;
      foreach ($input as $key => $v) {
        $example->$key = $v;
      }
      $example->created_uid = Auth::id();
      $example->created_at = date("Y-m-d H:i:s");
      $example->save();

      DB::commit();
      Log::info('Successful: Example:store : ', ['data' => $example]);

      $message = trans('core.message_insert_success');
      $status = 'success';
      $title = 'Success';
    } catch (\Exception $e) {

      DB::rollback();
      Log::error('Error: Example:store :' . $e->getMessage());

      $message = trans('core.message_insert_error');
      $status = 'error';
      $title = 'Error';
    }

    session(['noit_title' => $title]);
    session(['noit_message' => $message]);
    session(['noit_status' => $status]);

    return redirect()->route('examples.index');
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
    $example = Example::select($select)->findOrFail($id);

    $compact->example = $example;

    $this->_getDataBelongs($compact);

    return view('_examples.form',$example, (array) $compact);
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
    $compact->example = Example::select($select)->findOrFail($id);
    $this->_getDataBelongs($compact);
    return view('_examples.show', (array) $compact);
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

      $example = Example::find($id);
      foreach ($input as $key => $v) {
        $example->$key = $v;
      }
      $example->updated_uid = Auth::id();
      $example->updated_at = date("Y-m-d H:i:s");
      $example->save();

      DB::commit();
      Log::info('Successful: Example:update : ', ['id' => $id, 'data' => $example]);

      $message = trans('core.message_update_success');
      $status = 'success';
      $title = 'Success';
    } catch (\Exception $e) {

      DB::rollback();
      Log::error('Error: Example:update :' . $e->getMessage());

      $message = trans('core.message_update_error');
      $status = 'error';
      $title = 'Error';
    }

    session(['noit_title' => $title]);
    session(['noit_message' => $message]);
    session(['noit_status' => $status]);

    return redirect()->route('examples.index');
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

      Example::destroy($id);

      DB::commit();
      Log::info('Successful: example:destroy : ', ['id' => $id]);

      $message = trans('core.message_del_success');
      $status = 'success';
      $title = 'Success';
    } catch (\Exception $e) {

      DB::rollback();
      Log::error('Error: example:destroy :' . $e->getMessage());

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
	      $results = $results->orWhere ('Examples.parent_id', 'LIKE','%'. @$search.'%') ;
	      $results = $results->orWhere ('Examples.users_id', 'LIKE','%'. @$search.'%') ;
	      $results = $results->orWhere ('Examples.title', 'LIKE','%'. @$search.'%') ;
	      $results = $results->orWhere ('Examples.body', 'LIKE','%'. @$search.'%') ;
	      $results = $results->orWhere ('Examples.amount', 'LIKE','%'. @$search.'%') ;
	      $results = $results->orWhere ('Examples.date', 'LIKE','%'. @$search.'%') ;
	      $results = $results->orWhere ('Examples.time', 'LIKE','%'. @$search.'%') ;
	      $results = $results->orWhere ('Examples.datetime', 'LIKE','%'. @$search.'%') ;
	      $results = $results->orWhere ('Examples.status', 'LIKE','%'. @$search.'%') ;
	      $results = $results->orWhere ('Examples.active', 'LIKE','%'. @$search.'%') ;
        return $results;
  }

  protected function _advSearch($results, $input){
        if(@$input->parent_id){
          $results = $results->where('Examples.parent_id',  $input->parent_id);
        }
        if(@$input->users_id){
          $results = $results->where('Examples.users_id',  $input->users_id);
        }
        if(@$input->title){
          $results = $results->where('Examples.title', 'LIKE', "%" .  $input->title. "%" );
        }
        if(@$input->body){
          $results = $results->where('Examples.body', 'LIKE', "%" .  $input->body. "%" );
        }
        if(@$input->amount_start && @$input->amount_end){
          $min = @$input->amount_start;
          $max = @$input->amount_end;
          $results = $results->whereBetween('Examples.amount',  [$min, $max]);
        }
        if(@$input->date_start && @$input->date_end){
          $sd = date_create(@$input->date_start);
          $sDate = date_format($sd, "Y-m-d");
          $ed = date_create(@$input->date_end);
          $eDate = date_format($ed, "Y-m-d");
          $results = $results->whereBetween('Examples.date',  [$sDate, $eDate]);
        }
        if(@$input->time_start && @$input->time_end){
          $sd = date_create(@$input->time_start . ":00");
          $sDate = date_format($sd, "H:i:s");
          $ed = date_create(@$input->time_end . ":59");
          $eDate = date_format($ed, "H:i:s");
          $results = $results->whereBetween('Examples.time',  [$sDate, $eDate]);
        }
        if(@$input->datetime_start && @$input->datetime_end){
          $sd = date_create($input->datetime_start . ":00");
          $sDate = date_format($sd, "Y-m-d H:i:s");
          $ed = date_create(@$input->datetime_end . ":59");
          $eDate = date_format($ed, "Y-m-d H:i:s");
          $results = $results->whereBetween('Examples.datetime',  [$sDate, $eDate]);
        }
        if(@$input->status){
          $results = $results->where('Examples.status',  $input->status);
        }
        if(@$input->active){
          $results = $results->where('Examples.active',  $input->active);
        }
      return $results;
  }

  protected function _getDataBelongs($compact)
  {
		  $compact->arrParent = Example::where('id','!=',null)
			->orderBy('id')
			->pluck('id','id')	
      ->toArray();
		  $compact->arrUsers = User::where('id','!=',null)
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
 * File Create : 2020-09-18 17:10:04 *
 */