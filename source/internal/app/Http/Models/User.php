<?php

namespace App\Http\Models;

use Spr\Base\Models\Helper;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class User extends Authenticatable
{
    protected $table = "employee";
    public $timestamps = false;

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
        'username',
        'address1',
        'phone_number',
        'birthday',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // public function getDataByid ($id) {

    //     DB::table('user')->select(DB::Raw(' CONCAT() as ds '))
    //     ->whereRaw('')
    //     ->join('userinformation', 'userinformation.user_id','=', 'user.id')
    // }


    /*
    * Function to check if the user is admin
    */
    // public function isAdmin() {
    //     $query = DB::table('employee_role_relationship')
    //        ->where('employeeId','=', $this->id)
    //        ->first();

    //     if($query->roleId == 1) {
    //         return true;
    //     }
    //     return false;
    // }

    public function isAdmin() {
        $query = DB::table('employee')
           ->where('id','=', $this->id)
           ->first();

        if($query->roleId == 1 || $query->roleId == 2) {
            return true;
        }
        return false;
    }

    public static function insertData($table, $data, $where) {

        $results = Helper::insertGetId($table, $data, $where);

        return $results;
    }

    public static function selectData($table, $where, $limit = null, $offset = null, $selectType = null, $fields = null, $order = null) {

        $results = Helper::select($table, $where, $limit, $offset, $selectType, $fields, $order);

        return $results;
    }

    public static function updateData($table, $data, $where) {

        $results = Helper::update_db($table, $data, $where);

        return $results;
    }

    public function checkExistsUserByEmail($email) {

        try {

            $query = DB::table('employee')
                                        ->select('id', 'email')
                                        ->where('email', '=', $email);

            $results['response'] = $query->first();

        } catch (PDOException $e) {

            $results['meta']['success'] = false;
            $results['meta']['msg']     = $e->getMessage();
        }

        return $results;
    }

    public function checkExistsRequest($email, $token_reset_password = null){

        try {

            $query = DB::table('password_resets')->where('email', '=', $email);

            if (!is_null($token_reset_password)) {

                $query->where('token', '=', $token_reset_password);
            }

            $results['response'] = $query->first();;

        } catch (PDOException $e) {

            $results['meta']['success'] = false;
            $results['meta']['msg']     = $e->getMessage();
        }

        return $results;
    }
}