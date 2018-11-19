<?php
namespace App\Http\Controllers;

// use Spr\Base\Models\Media as Image;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Models\Media as ModelMedia;
use App\Http\Models\Setting as ModelSetting;
use Spr\Base\Controllers\Helper as HelperController;
use Spr\Base\Response\Response;
use Intervention\Image\Exception\NotReadableException;
use Input;
use Config;
use Auth;
use Lang;
use Session;
use Image;

class SettingController  extends Controller
{


    public function __construct()
    {

    }

    public function insertData($data_output_validate_param){

        if($data_output_validate_param['meta']['success']){

            $title          =   $data_output_validate_param['response']['title'];
            $key            =   $data_output_validate_param['response']['key'];
            $description    =   $data_output_validate_param['response']['description'];
            $icon           =   $data_output_validate_param['response']['image'];
            $icon_class     =   $data_output_validate_param['response']['icon_class'];
            $created_at     =   $data_output_validate_param['response']['created_at'];

            $ModelSetting    =   new ModelSetting();
            $ModelMedia         =   new ModelMedia();

            $mime_type = Config::get('spr.type.mimeFile');

            $image_name =  HelperController::uniqid_base36($data_output_validate_param['response']['created_at']);

            $image_original_mime = $icon->getMimeType();

            $path_tmp = public_path( Config::get('spr.system.uploadMedia.path_tmp_upload') );
            $path     = public_path( Config::get('spr.system.uploadMedia.path_image_upload') );

            HelperController::create_path($path_tmp);
            HelperController::create_path($path);

            $full_path_file     = $path . '/' . $image_name .'.'. Config::get('spr.type.mimeFile')[$image_original_mime];
            $full_path_file_tmp = $path_tmp . '/' . $image_name .'.'. Config::get('spr.type.mimeFile')[$image_original_mime];


            // save file tmp
            Image::make($icon)->save($full_path_file, 100);
            Image::make($icon)->save($full_path_file_tmp, 100);

            $path = Config::get('spr.system.uploadMedia.path_image_upload'). '/' . $image_name .'.'. Config::get('spr.type.mimeFile')[$image_original_mime];
            $path_tmp = Config::get('spr.system.uploadMedia.path_tmp_upload'). '/' . $image_name .'.'. Config::get('spr.type.mimeFile')[$image_original_mime];

            $data_image = [

                'name'       =>  $image_name,
                'path'      =>  $path,
                'tmp_path'  =>  $path_tmp,
                'url'        =>  'url',
                'tmp_url'    =>  'tmp_url',
            ];

            $media_id = $ModelMedia->insertData($data_image);

            if($media_id['meta']['success']){

                $data = [

                    'title'         =>  $title,
                    'key'           =>  $key,
                    'description'   =>  $description,
                    'icon'          =>  $media_id['response'],
                    'icon_class'    =>  $icon_class,
                    'created_at'    =>  $created_at,
                ];

                $data_output_validate_param = $ModelSetting->insertData($data);

            }else{

                 $data_output_validate_param  =  $media_id;
            }


        }else{

            $data_output_validate_param['response'] = array();

        }

        Session::flash('message', $data_output_validate_param['meta']['msg']);

        return $data_output_validate_param;

    }

    public function updateCompanyInfo($data_output_validate_param){


        if ($data_output_validate_param['meta']['success']) {

            $image                          =   $data_output_validate_param['response']['image'];
           // $media_id                           =   $data_output_validate_param['response']['icon'];
            $company_name                   =   $data_output_validate_param['response']['company_name'];
            $email                          =   $data_output_validate_param['response']['email'];
            $phone_number                   =   $data_output_validate_param['response']['phone_number'];
            $address                        =   $data_output_validate_param['response']['address'];
            $description                    =   $data_output_validate_param['response']['description'];
            $updated_at                     =   $data_output_validate_param['response']['updated_at'];
            $icon                           =   null;
            $data                           =   [];
            $where                          =   [];

            $ModelSetting                   =   new ModelSetting();

            if($image != '' && $image != null){

                $mime_type              = Config::get('spr.type.mimeFile');
                $image_name             =  HelperController::uniqid_base36($data_output_validate_param['response']['created_at']);
                $image_original_mime    = $image->getMimeType();
                $path_tmp               = public_path( Config::get('spr.system.uploadMedia.path_tmp_upload') );
                $path                   = public_path( Config::get('spr.system.uploadMedia.path_image_upload') );

                HelperController::create_path($path_tmp);
                HelperController::create_path($path);

                $full_path_file     = $path . '/' . $image_name .'.'. Config::get('spr.type.mimeFile')[$image_original_mime];
                $full_path_file_tmp = $path_tmp . '/' . $image_name .'.'. Config::get('spr.type.mimeFile')[$image_original_mime];

                // save file tmp
                Image::make($image)->save($full_path_file, 100);
                Image::make($image)->save($full_path_file_tmp, 100);

                $path       = Config::get('spr.system.uploadMedia.path_image_upload'). '/' . $image_name .'.'. Config::get('spr.type.mimeFile')[$image_original_mime];
                $path_tmp   = Config::get('spr.system.uploadMedia.path_tmp_upload'). '/' . $image_name .'.'. Config::get('spr.type.mimeFile')[$image_original_mime];


                $key_logo   =   Config::get('spr.type.setting.company-info.logo.key');
                $ModelMedia =   new ModelMedia();

                $data_media = [

                    'name'          =>  $image_name,
                    'path'          =>  $path,
                    'tmp_path'      =>  $path_tmp,
                    'url'           =>  'url',
                    'tmp_url'       =>  'tmp_url',
                ];

                $icon   =  $ModelMedia->insertData($data_media)['response'];

                $data[Config::get('system.setting.logo')] = $icon;
            }

            $data[Config::get('system.setting.company_name')]   = $company_name;
            $data[Config::get('system.setting.email')]          = $email;
            $data[Config::get('system.setting.phone_number')]   = $phone_number;
            $data[Config::get('system.setting.address')]        = $address;
            $data[Config::get('system.setting.description')]    = $description;

            foreach ($data as $key => $value) {

                $tmp = $this->updateCompanyInfoByKeyValue($key, $value);
            }

            $data_output_validate_param['meta']['msg']  = Lang::get('message.api.success.0001');

        }

        return $data_output_validate_param;
    }

    public function updateAllowedIpAddress($data_output_validate_param) {

        if ($data_output_validate_param['meta']['success']) {

            $ip_address         = $data_output_validate_param['response']['allowed_ip_address'];
            $split_string       = ",";
            $flag               = true;

            $splited_ip_address = explode($split_string, $ip_address);

            foreach ($splited_ip_address as $key => $value) {

                if (!filter_var($value, FILTER_VALIDATE_IP)) {

                    $flag = false;
                }
            }

            if ($flag) {

                $results = $this->updateCompanyInfoByKeyValue( Config::get('system.setting.allowed_ip_address'), $ip_address );
                $data_output_validate_param['meta']['msg']  = Lang::get('message.api.success.0001');

            } else {

                $data_output_validate_param['meta']['code'] = 500;
                $data_output_validate_param['meta']['msg']  = Lang::get('message.api.error.0001');
            }
        }

        return $data_output_validate_param;
    }

    public function getData(){

        $results        = Response::response();
        $ModelSetting   = new ModelSetting();
        $data           = $ModelSetting->getData();

        foreach (Config::get('system.setting') as $key_setting => $value_setting) {

            foreach ($data['response'] as $r_key => $item) {

                if ($item->key_setting == $value_setting) {

                    $results['response'][$item->key_setting] = $item;
                }
            }
        }

        return $results;
    }

    public function getLogo(){

        $ModelSetting   =   new ModelSetting();
        $results        =   $ModelSetting->getLogo();
        return $results;
    }

    public function getCompanyInfo($key){

        $ModelSetting   =   new ModelSetting();
        $results        =   $ModelSetting->getCompanyInfo($key);
        return $results;
    }

    public function updateCompanyInfoByKeyValue($key, $value) {

        $ModelSetting   = new ModelSetting();
        $data           = []; 

        if ($key == Config::get('system.setting.logo')) {

            $data = [
                'icon'    => $value
            ];

        } else {

            $data = [
                'title'    => $value
            ];
        }

        $where = [
            [
                'fields'    => 'key_setting',
                'operator'  => '=',
                'value'     => $key
            ]
        ];

        $results = $ModelSetting->updateData($data, $where);

        return $results;
    }


}