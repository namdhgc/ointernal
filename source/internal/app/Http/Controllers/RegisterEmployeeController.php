<?php
namespace App\Http\Controllers;

// use App\User as modelUser;
use App\Http\Get\Helper;
use App\Http\Models\Base;
use App\Http\Models\User as modelUser;
use App\Http\Models\EmployeeRoleRelationship ;
use App\Http\Models\Employee;
use App\Http\Controllers\Controller;
use App\Http\Controllers\EmailController;
use Illuminate\Support\Facades\DB;
use App\Http\Response\Response;
use Redirect;
use Session;
use Config;
use Lang;
use Input;
use Auth;
use Hash;
class RegisterEmployeeController extends Controller
{
    protected $employee;
    protected $EmployeeRoleRelationship;
    protected $mail;
    protected $type;

    function __construct(){

        $this->employee                 = new Employee();
        $this->EmployeeRoleRelationship = new EmployeeRoleRelationship();
        $this->mail                     = new EmailController();
        $this->type                     = Config::get('email_types.register');

    }

    public function addEmployee(){

        $firstname      = Input::get("firstname");
        $lastname       = Input::get("lastname");
        $gender         = Input::get("gender");
        $email          = Input::get("email");
        $birthday       = Input::get("birthday");
        $phone_number   = Input::get("digits");
        $address1       = Input::get("address1");
        $employeeCode   = Input::get("employeeCode");
        $diplomaId      = Input::get("diplomaId");
        $departmentId   = Input::get("departmentId");
        $role           = Input::get("role");
        $createdById    = Auth::user()->id;
        $created_date   = date("Y-m-d H:i:s");
        $updated_date   = date("Y-m-d H:i:s");

   
        // $password = Hash::make('123456');
        $password_without_hash = bin2hex(random_bytes(4));

        $data=[
            'firstname'     => $firstname,
            'lastname'      => $lastname,
            'gender'        => $gender,
            'email'         => $email,
            'birthday'      => $birthday,
            'phone_number'  => $phone_number,
            'address1'      => $address1,
            'employeeCode'  => $employeeCode,
            'diplomaId'     => $diplomaId,
            'departmentId'  => $departmentId,
            'createdById'   => $createdById,
            'password'      => Hash::make($password_without_hash),
            'displayName'   => $lastname . ' ' . $firstname,
            'roleId'        => $role,
            'created_date'  => $created_date,
            'updated_date'  => $updated_date,
        ];

        DB::beginTransaction();

        try {

            $id = DB::table('employee')->insertGetId($data);
            $roleData   = [
                'employeeId'    => $id,
                'roleId'        => $role,
            ];

            $this->EmployeeRoleRelationship->addRole($roleData);

            DB::commit();

            $data['password'] = $password_without_hash;

            $this->mail->sendMail($this->type, $data, $email);

            $results = Response::response(200, '', $data, true);

        } catch (Exception $e) {

            DB::rollback();
            Session::flash('fail', Lang::get('admin/register.register_fail'));

            $results['meta']['success'] = false;
            $results['meta']['msg']     = $e->getMessage();
        }

        // dd($results);

        return $results;
    }
    public function checkEmail(){
        $email  = Input::get('email');
        $status  = $this->employee->checkExist('email',$email);
        return $status;  
    }
    public function checkCode(){
        $employeeCode   = Input::get("employeeCode");
        $status  = $this->employee->checkExist('employeeCode',$employeeCode);
        return $status;  
    }
    public function getDataView(){
        $firstname      = Input::get("firstname");
        $lastname       = Input::get("lastname");
        $gender         = Input::get("gender");
        $email          = Input::get("email");
        $birthday       = Input::get("birthday");
        $phone_number   = Input::get("digits");
        $address1       = Input::get("address1");
        $employeeCode   = Input::get("employeeCode");
        $diplomaId      = Input::get("diplomaId");
        $departmentId   = Input::get("departmentId");
        $role           = Input::get("role");
        $data=[
            'firstname'     => $firstname,
            'lastname'      => $lastname,
            'gender'        => $gender,
            'email'         => $email,
            'birthday'      => $birthday,
            'phone_number'  => $phone_number,
            'address1'      => $address1,
            'employeeCode'  => $employeeCode,
            'diplomaId'     => $diplomaId,
            'departmentId'  => $departmentId,
            'role'          => $role
            ];
        return $data;    
     }
}