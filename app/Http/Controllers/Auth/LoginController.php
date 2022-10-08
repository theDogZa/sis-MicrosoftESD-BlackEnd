<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

use App\Services\LogsService;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->logs = new LogsService();
        $this->middleware('guest')->except('logout');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function login(Request $request)
    {
        $input = $request->all();
        
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $auth = Auth::attempt(
            array(
                $fieldType => $input['username'],
                'password' => $input['password'],
                'active' => 1,
                'activated' => 1
            )
        );

        if ($auth) {

            //----- user_right type of right 1=FrontEnd 5=BackEnd 9=Admin
            if (Auth::user()->user_right >= 5) {
                
                $user = User::find(Auth::id());

                $request->session()->put('last_login', $user->last_login);
                $user->last_login = date("Y-m-d H:i:s");
                $user->save();

                Log::channel('appsyslog')->info(
                    '#log#',
                    [
                        'username' => Auth::user()->username,
                        'ip' => $request->ip(),
                        'date' =>  date("Y-m-d H:i:s"),
                        'uri' => Route::current()->uri,
                        'parameters' => Route::current()->parameters(),
                        'route' => Route::currentRouteName(),
                        'request' => $request->username,
                        'response_code' => 200,
                        'methods' => Route::current()->methods
                    ]
                );

                $request->session()->put('count_login_' . $input['username'], null);

                if ($user->isChangePassword) {
                    return redirect('change-password/' . $user->remember_token);
                } else {
                    return redirect()->route('dashboard');
                }

            }else{
                
                Auth::logout();
                Session()->flush();
                return redirect()->route('login')->with('error', 'User No access rights.');
            }

        } elseif (Auth::attempt(array($fieldType => $input['username'], 'password' => $input['password']))) {

            $user = User::find(Auth::id());
            if (@$user->active == 0 || @$user->activated == 0) {

                    Log::channel('appsyslog')->info(
                      [
                         '#log#',
                             'username' => $input['username'],
                            'ip' => $request->ip(),
                            'date' =>  date("Y-m-d H:i:s"),
                            'uri' => Route::current()->uri,
                            'parameters' => Route::current()->parameters(),
                            'route' => Route::currentRouteName(),
                            'request' => $request->username,
                            'response_code' => 400,
                            'methods' => Route::current()->methods
                        ]
                );

                if(@$user->active == 0 || @$user->activated == 0){
                    Auth::logout();
                    Session()->flush();
                    return redirect()->route('login')->with('error', 'User account not Active/Activated Or User account is locked!.');
                }else{
                    Auth::logout();
                    Session()->flush();
                    return redirect()->route('login')->with('error', 'User No access rights.');
                }
            }

        } else {

            $countLogin = $request->session()->get('count_login_'. $input['username']);
            $request->session()->put('count_login_' . $input['username'], $countLogin+1);
            $countLoginShow = $request->session()->get('count_login_'.$input['username']);

            if ($countLoginShow >= 5) {

                //----- lock
                $user = User::where('username', $input['username'])->where('active',1)->first();
                if(@$user->id){
                    $user->active = 0;
                    $user->save();
                }
                return redirect()->route('login')->with('error', 'User account is locked! Please contact system administrator!'); 
            }

            return redirect()->route('login')->with('error', 'Username/Email-Address And Password Are Wrong  Can retry '. (5 - $countLoginShow).' more times');   
        }
        
    }

    public function logout()
    {
        Auth::logout();
        Session()->flush();

        return redirect()->route('login');
    }

}
