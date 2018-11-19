<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Input;
use Auth;
use Redirect;
use Session;
use Lang;
use Config;
use App\Http\Models\User as ModelUser;
use App\Http\Controllers\EmailController;

// test
use DB;
use Hash;

class UserController extends Controller
{

    // public function login2(){
    //     if (Auth::attemp(['email'=>Input::get('email'), 'password'=>Input::get('password')])) {
    //         return redirect('pages/admin/index');
    //     }
    //     else{
    //         return redirect('pages/login/login');
    //     }
    // }

    protected $table = 'employee';

    function __construct() {

        $this->mail                     = new EmailController();
        $this->type                     = Config::get('email_types.reset_password');
    }

    public function login()
    {
      // $isAdmin= User::isAdmin(1);//current
       $username = Input::get('email');
       $password = Input::get('password');
       $active   = '1';

       // DB::table('employee')->update(array('password' => Hash::make('123456')));
       // // if(Auth::check()){
       // //     echo ' success';
       // //     exit;
       // // }

       if (Auth::attempt(['email' => $username, 'password' => $password, 'active' => $active]))
       {
           return true;
       }
       else {
           return false;
       }
   }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/');
    }

    public function changePassword($data_output_validate_param) {

        if (Auth::check()) {

          if ($data_output_validate_param['meta']['success']) {

            $old_password           = $data_output_validate_param['response']['old_password'];
            $new_password           = $data_output_validate_param['response']['new_password'];
            $new_password_retype    = $data_output_validate_param['response']['new_password_retype'];
            $user_id                = Auth::user()->id;
            $ModelUser              = new ModelUser();

            $where = [
                [
                    'fields'    => 'id',
                    'operator'  => '=',
                    'value'     => $user_id
                ]
            ];

            if (isset($old_password) && isset($new_password) && isset($new_password_retype) && $old_password != '' && $new_password != '' && $new_password_retype != '') {

                $user               = $ModelUser->selectData($this->table, $where);
                $stored_password    = $user['response'][0]->password;

                if (Hash::check($old_password, $stored_password)) {

                    if ($new_password !== $new_password_retype) {

                        $data_output_validate_param['meta']['code'] = 500;
                        $data_output_validate_param['meta']['msg']  = [ Lang::get('message.web.error.0014') ];

                        return $data_output_validate_param;

                    } else {

                        $data = [
                            'password'    => Hash::make($new_password)
                        ];
                    }
                } else {

                    $data_output_validate_param['meta']['code'] = 500;
                    $data_output_validate_param['meta']['msg']  = [ Lang::get('message.web.error.0025') ];

                    return $data_output_validate_param;
                }
            } else {

                $data_output_validate_param['meta']['code'] = 500;
                $data_output_validate_param['meta']['msg']  = [ Lang::get('message.web.error.0026') ];

                return $data_output_validate_param;
            }

            $results  = $ModelUser->updateData($this->table, $data, $where);

            $data_output_validate_param['meta']['msg']      = [ Lang::get('message.web.success.0001') ];
            $data_output_validate_param['response']['data'] = $results;
          }
        }



        return $data_output_validate_param;
    }

    public function requestResetPassword($data_output_validate_param) {

        if (!Auth::check()) {

          if ($data_output_validate_param['meta']['success']) {

            $email = $data_output_validate_param['response']['email'];

            $ModelUser  = new ModelUser();
            $check      = $ModelUser->checkExistsUserByEmail($email);

            if ($check['response'] != null) {

                $time_now = strtotime(\Carbon\Carbon::now()->toDateTimeString());

                $data = [
                    'token'                 => csrf_token(),
                    'created_at'            => $time_now,
                    'end_time_confirm'      => $time_now + Config::get('spr.system.reset_password.reset_password_time') * 60 * 60,
                    'email'                 => $email
                ];

                $where = [];

                $request = $ModelUser->checkExistsRequest($email);

                if ($request['response'] != null) {

                  $where = [
                    [
                      'fields'    => 'email',
                      'operator'  => '=',
                      'value'     => $request['response']->email
                    ]
                  ];

                  $results          = $ModelUser->updateData('password_resets', $data, $where);

                } else {

                  $results          = $ModelUser->insertData('password_resets', $data, $where);
                }

                $data['email'] = $check['response']->email;

                $data_output_validate_param['response']     = $this->mail->sendMail($this->type, $data, $request['response']->email);
                $data_output_validate_param['meta']['msg']  = ['0' => Lang::get('message.web.success.0003')];

            } else {

                $data_output_validate_param['meta']['success']  = false;
                $data_output_validate_param['meta']['code']     = 501;
                $data_output_validate_param['meta']['msg']      = ['0' => Lang::get('message.web.error.0003')];
                $data_output_validate_param['response']         = [];
            }
          }
        }

        return $data_output_validate_param;
    }

    public function checkResetPassword($data_output_validate_param) {

        $email    = $data_output_validate_param['response']['email'];
        $token    = $data_output_validate_param['response']['token'];
        $time_now = strtotime(\Carbon\Carbon::now()->toDateTimeString());

        $ModelUser  = new ModelUser();
        $check      = $ModelUser->checkExistsRequest($email, $token);

        if ($check['response'] != null) {

            $end_time_confirm = $check['response']->end_time_confirm;

            if ($time_now < $end_time_confirm) {

                return true;
            } else {

                return false;
            }
        } else {

            return false;
        }
    }

    public function actionResetPassword($data_output_validate_param) {

        $email                  = $data_output_validate_param['response']['email'];
        $token                  = $data_output_validate_param['response']['token'];
        $password               = $data_output_validate_param['response']['password'];
        $password_retype        = $data_output_validate_param['response']['password_retype'];
        $ModelUser              = new ModelUser();

        if ($password === $password_retype) {

            $check = $this->checkResetPassword($data_output_validate_param);

            if ($check == true) {

                $where = [
                    [
                        'fields'    => 'email',
                        'operator'  => '=',
                        'value'     => $email
                    ]
                ];

                $data = [
                    'password'              => Hash::make($password),
                    // 'token'                 => null,
                    // 'end_time_confirm'      => null
                ];

                $data_password_reset = [
                  'token'                 => null,
                  'end_time_confirm'      => null
                ];

                $results = $ModelUser->updateData('employee', $data, $where);
                $results = $ModelUser->updateData('password_resets', $data_password_reset, $where);

                $data_output_validate_param['meta']['msg']  = [ Lang::get('message.web.success.0001') ];
            } else {

                $data_output_validate_param['meta']['code']     = 500;
                $data_output_validate_param['meta']['success']  = false;
                $data_output_validate_param['meta']['msg']      = [ Lang::get('message.web.error.0015') ];
            }
        } else {

            $data_output_validate_param['meta']['code']     = 500;
            $data_output_validate_param['meta']['success']  = false;
            $data_output_validate_param['meta']['msg']      = [ Lang::get('message.web.error.0014') ];
        }
        return $data_output_validate_param;
    }
}