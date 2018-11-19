<?php 
namespace App\Http\Controllers;

use App\Http\Models\User as modelUser;
use App\Http\Models\EmployeeRoleRelationship as modelEmployeeRoleRelationship;
use App\Http\Models\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Response\Response;
use Auth;
use Input;
use Hash;
use Redirect;
use Session;

class PagesController extends Controller
{
    protected $employee;

    function __construct(){
    $this->employee = new Employee();
    }
    
    public function getIndex() {
        
        return "controller";
    }


    public function secret($username, $password) {

        if ($username !== 'admin') {
            $error = 'Tên đăng nhập không đúng';
            return View::make('contact')->withError($error);
        } else if ($password != 'secret') {
            $error = 'Mật khẩu không đúng';
            return View::make('contact')->withError($error);
        } else {
            // return View::make('pages.add')->withUsername($username);
            return View('pages.add')->withUsernam($username);
        }

    }

    public function postAdminLogin() {
        $username = Input::get('username');
        $password = Input::get('password');


        $query = 'SELECT username, password FROM user ';
        $query .= ' WHERE username = ' . '"' . $username . '"';
        $query .= ' AND password = ' . '"' . $password . '"';


        $user = DB::select($query);
        // $user = DB::table('user')->select('username')->where('username', '=', $username);


        return $user;
    }
    public function postLogin()
    {
        $username = Input::get('email');
        $password = Input::get('password');
        
        $response = Response::response();
        $roleName = $this->employee->EmployeeInfo();
     
        if (Auth::attempt(['email'=>$username, 'password'=>$password])){                
             
            $modelEmployeeRoleRelationship = new modelEmployeeRoleRelationship();
            $dataRole = $modelEmployeeRoleRelationship->get_data_by_employee_id(Auth::user()->id);

            if($dataRole->roleId == 1 ){

                $response['response'] = 'adm-index';
            }else {

                $response['response'] = 'user-index';
            }
        }else {
            $response['meta']['success'] = false;
            $response['meta']['msg']     = 'Login Failed please try again!';
        }
        return $response;
        // if (Auth::attempt(['email'=>$username, 'password'=>$password]))
        //    {        
        //        return true;
        //    }
        //    else {
        //        return false;
        //    }
    }
    public function checkRole()
    {
        $username = Input::get('email');
        $password = Input::get('password');
        
        $response = Response::response();
        $roleName = $this->employee->EmployeeInfo();
     
        if (Auth::attempt(['email'=>$username, 'password'=>$password])){                
             
            $modelEmployeeRoleRelationship = new modelEmployeeRoleRelationship();
            $dataRole = $modelEmployeeRoleRelationship->get_data_by_employee_id(Auth::user()->id);

            if($dataRole->roleId == 1 ){

                return 'admin';
            }else {

                return 'user';
            }
        }else {
            $response['meta']['success'] = false;
            $response['meta']['msg']     = 'Login Failed please try again!';
        }
        return $response;
    }

    public function adminLogout()
    {
            Auth::logout();
            Session::flush();
            return redirect('/adminLogin');
    }
}