<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Input;
use DB;
use Hash;
use Auth;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }


    public function login(){
       $username = Input::get('email');
       $password = Input::get('password');
       // print_r($username);
       // exit();
       // DB::table('employee')->update(array('password' => Hash::make('123456')));
       // if(Auth::check()){
       //     echo ' success';
       //     exit;
       // }

       if (Auth::attempt(['email'=>$username, 'password'=>$password]))
       {           
           return view('/admin');
       }
       else {
           return 'error';
       }
   }
}
