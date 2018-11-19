<?php

namespace Spr\Base\Controllers\Permission;

use Spr\Base\Models\Roles as ModelRoles;
use App\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Init;
use Shaphira\Base\Response\Response;
use Illuminate\Support\Facades\Input;
use Config;
use Auth;
use Cache;
use Session;
use Mail;
use Hash;
use Lang;


class Roles extends Controller
{

    public function __construct () {

    }

    public function getData($data_output_validate_param) {

        $sort           = $data_output_validate_param['response']['sort'];
        $limit          = $data_output_validate_param['response']['limit'];
        $sort_type      = $data_output_validate_param['response']['sort_type'];

        if($data_output_validate_param['meta']['success']) {

            $table  = '';
            $ModelRoles = new ModelRoles();

            $data = $ModelRoles->getDataManage($limit, $sort, $sort_type);

            return array('data' => $data, 'sort' => $sort, 'limit' => $limit , 'sort_type' => $sort_type);
        }else {

            $data_output_validate_param['response'] = array();
            return array('data' => $data_output_validate_param, 'sort' => $sort, 'limit' => $limit , 'sort_type' => $sort_type);
        }
    }
    //$activity_code, $users_id, $message, $status, $link = '', $text_link = ''
    // public function newRole($data_output_validate_param) {

    //     $msg = array();
    //     $Response = new Response();
    //     $results = $Response->response(200,'','',true);
    //     if($data_output_validate_param['meta']['success']){
    //         $dataInsert = $data_output_validate_param['response'];

    //         $ModelRoles = new ModelRoles();
    //         $dataInsert = $ModelRoles->insertNewRole($dataInsert);
    //         if($dataInsert['meta']['success']){
    //             $results['meta']['msg'] = array(Lang::get('message.success.00013'));
    //         }
    //         return $results;
    //     }else {
    //         return $data_output_validate_param;
    //     }
    // }

    // public function updateAnnouncement($dataOutputValidateParam){
    //     $msg = array();
    //     $Response = new Response();
    //     $results = $Response->response(200,'','',true);
    //     if($dataOutputValidateParam['meta']['success']){
    //         $dataInsert = $dataOutputValidateParam['response'];
    //         $id = $dataInsert['id'];
    //         unset($dataInsert['id']);
    //         $dataInsert['status'] = Config::get('shaphira.system.status.announcement.none-active');
    //         $dataInsert['updated_by'] = Auth::user()->id;

    //         $ModelAnnouncement = new ModelAnnouncement();
    //         $dataUpdate = $ModelAnnouncement->updateNewAnnouncement($id, $dataInsert);
    //         if($dataUpdate['meta']['success']){
    //             $results['meta']['msg'] = array(Lang::get('message.success.00013'));
    //         }
    //         return $results;
    //     }else {
    //         return $dataOutputValidateParam;
    //     }
    // }
}
