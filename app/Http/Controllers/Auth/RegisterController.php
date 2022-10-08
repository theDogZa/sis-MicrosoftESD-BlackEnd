<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\ApiConfig;
use App\Services\LogsService;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->logs = new LogsService();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'username' => ['required', 'string', 'min:4', 'max:200', 'unique:users'],
            'email' => ['required', 'string', 'email', 'min:5', 'max:200', 'unique:users'],
            'password' => ['required', 'string'],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $request = new Request();

        $arrLog = array();
        $arrLog['view'] = 'A';
        $arrLog['username'] = $data['username'];
        $arrLog['action'] = 'Register.';
        $arrLog['request'] = $data;
        $arrLog['response'] = [];

        $this->logs->addLogSys2($request, $arrLog);

        $key = 'register';
        $value = 'User account not Active. Please contact administrator';
        session()->put($key, $value);

        Log::info('Successful: RegistersUsers:create : ', ['req' => $data]);

        return User::create([
            'username' => $data['username'],
            'email' => @$data['email'],
            'first_name' => @$data['first_name'],
            'last_name' => @$data['last_name'],
            'activated' => 1,
            'active' => 0,
            'user_right' => 5, //---backend
            'password' => Hash::make($data['password']),
        ]);

    }
}
