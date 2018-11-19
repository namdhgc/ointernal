<?php

namespace App\Http\Controllers\Auth;

use App\User as modelUser;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Input;
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
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    
    public function validator(array $data)
    {

        return Validator::make($data, [
            // 'displayName'   => 'required|max:255',
            'name'          => 'required|max:255',
            'email'         => 'required|email|max:255|unique:users',
            'password'      => 'required|min:6|confirmed',
            // 'firstname'     => 'required|max:255',
            // 'lastname'      => 'required|max:255',
            // 'address1'      => 'required|max:255',      
            // 'phone_number'  => 'required|min:10|max:11|numeric',
            // 'birthday'      => 'required',
        ]);
    }

        // $input = array('name' => 'value');
        // $rules = array('name' => 'required|unique:posts|max:255');
        // $message   = array(
        // 'name.required' => 'msg1',
        // 'name.unique' => 'msg2',
        // 'name.max' => 'msg3'
        // );
        // $msg = array();

        // $validator = Validator::make($input, $rules, $msg);
        // if (!$validator->passes()) {
        // // validate false
        // foreach ($validator->errors()->all() as $msgError) {
        //    array_push($msg, $msgError);
        // }
        // }
    
    public function create(array $data)
    {
        
        return User::create([
            // 'displayName'   => $data['displayName'],
            // 'firstname'     => $data['firstname'],
            // 'lastname'      => $data['lastname'],
            'email'         => $data['email'],
            'name'          => $data['name'],
            'password'      => bcrypt($data['password']),
            // 'address1'      => $data['address1'],
            // 'phone_number'  => $data['phone_number'],
            // 'birthday'      => $data['birthday'],
        ]);
    }
    // public function store()
    // {
    //     $input = array('name' => 'value');
    //     $rules = array('name' => 'required|unique:posts|max:255');
    //     $message   = array(
    //     'name.required' => 'msg1',
    //     'name.unique' => 'msg2',
    //     'name.max' => 'msg3'
    //     );
    //     $msg = array();

    //     $validator = Validator::make($input, $rules, $msg);
    //     if (!$validator->passes()) {
    //     // validate false
    //     foreach ($validator->errors()->all() as $msgError) {
    //        array_push($msg, $msgError);
    //     }
    //     }
    // }
    public function store() {
        $rules = array(
            'username'      => 'required|max:255',
            'email'         => 'required|email|max:255|unique:users',
            'firstname'     => 'required|max:255',
            'lastname'      => 'required|max:255',
            'address1'      => 'required|max:255',      
            'phone_number'  => 'required|min:10|max:11|numeric',
            'birthday'      => 'required');
        if(!Validator::make(Input::all(),$rules)->fails()){
            $user               = new User();
            $user->username     = Input::get("username");
            $user->email        = Input::get("email");
            $user->firstname    = Input::get("firstname");
            $user->lastname     = Input::get("lastname");
            $user->address1     = Input::get("address1");
            $user->phone_number = Input::get("phone_number");
            $user->birthday     = Input::get("birthday");

            $user->save();
            echo "Đã đăng kí thành công";
        }
    }
}
