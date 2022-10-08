<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use App\Services\LogsService;

class ProfilesController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Profiles Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      $this->logs = new LogsService();

        $this->middleware(function ($request, $next) {
          $this->logs->addLogSys($request);
          return $next($request);
        });
        Cache::flush();
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: text/html');
        $this->arrShowFieldProfile = [
		    'username' => 1,  'first_name' => 1,  'last_name' => 1,  'email' => 1,  'email_verified_at' => 0,  'password' => 1, 'active' => 0,  'activated' => 0,  'remember_token' => 0,  'last_login' => 1, 		];
    }

  /**
   * Show profile the form for editing the specified resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $id = Auth::id();
    $select = '*';

    $compact = (object) array();
    $user = User::select($select)->findOrFail($id);
    $compact->arrShowField = $this->arrShowFieldProfile;

    $compact->user = $user;

    $compact->Role = $request->user()->hasRole('developer');


    return view('_profile.form',$user, (array) $compact);
  }

   /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */

  public function store(Request $request) {
  
    $input = (object) $request->except(['_token', '_method']);
  
    try {
      DB::beginTransaction();
    
      $user = User::find(Auth::id());   
      if($user->username !== $input->username){
      
        $user->username = $input->username;
      }

      $user->email = $input->email;
      $user->first_name = $input->first_name;
      $user->last_name = $input->last_name;
      
      $user->save();

      DB::commit();
      Log::info('Successful: User:Profiles : ', ['id' => $user->id, 'data' => $user]);

      $message = trans('profiles.message_change_success');
      $status = 'success';
      $title = 'Success';
    } catch (\Exception $e) {

      DB::rollback();
      Log::error('Error: User:update :' . $e->getMessage());

      $message = trans('profiles.message_change_error');
      $status = 'error';
      $title = 'Error';
    }
    $compact = (object) array();
    $compact->arrShowField = $this->arrShowFieldProfile;

    session(['noit_title' => $title]);
    session(['noit_message' => $message]);
    session(['noit_status' => $status]);

    return view('_profile.form', $user, (array) $compact);
  }

  public function checkUsername(Request $request) {
    $response = (object)[];
    $chk = false;
    $user = User::select('id')->where('username',$request->username)->first();

    if(!isset($user->id)){
        $chk = true;
    }
    $response->code = 200;
    $response->message = $chk;

    return base64_encode(json_encode((array)$response));
  }

  public function checkEmail(Request $request) {
    $response = (object)[];
    $chk = false;
    $user = User::select('id')->where('email',$request->email)->first();
    if(!isset($user->id)){
        $chk = true;
    }
    $response->code = 200;
    $response->message = $chk;

    return base64_encode(json_encode((array)$response));
  }
}
