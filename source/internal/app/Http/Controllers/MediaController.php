<?php

namespace App\Http\Controllers;

// use Spr\Base\Models\Media as Image;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Models\Media as ModelMedia;
use Spr\Base\Controllers\Helper as HelperController;
// use Intervention\Image\Exception\NotReadableException;
use Hash;
use Input;
use Image;
use Config;
use File;
use Auth;
use Lang;
use Session;

class MediaController extends Controller
{

    protected $name_session_file_upload;
    protected $table = "media";

    public function __construct()
    {
        $this->name_session_file_upload = Auth::guard('web')->user()->id.'-tmp-upload-file';
    }
    /**
    * Manage Post Request
    *
    * @return void
    */
    public function imageUpload($data_output_validate_param)
    {

        // get config Mime
        if($data_output_validate_param['meta']['success']){

            $new_file_upload    = null;
            $images             = $data_output_validate_param['response']['image'];

            $mime_type = Config::get('spr.type.mimeFile');
                
            $file = $images;

            // $file = $data_output_validate_param['response']['image'];

            $tmp_filename =  HelperController::uniqid_base36($data_output_validate_param['response']['created_at']);

            $client_original_mime = $file->getMimeType();

            $file_size  = $file->getSize();
            $file_name  = $file->getClientOriginalName();
            $file_mime  = $client_original_mime;

            $new_file_upload = [

                'client_original_size'  => $file_size,
                'client_original_name'  => $file_name,
                'client_original_mime'  => $file_mime,
                'tmp_name'              => $tmp_filename,
            ];

            $list_file_upload = [];

            if(!empty($new_file_upload)){

                // Get folder upload tmp
                try {

                    $tmp_path = public_path( Config::get('spr.system.uploadMedia.path_tmp_upload') );
                    // check exit path
                    HelperController::create_path($tmp_path);

                    // Create full path, file name for save file to tmp folder
                    $full_path_file_tmp = $tmp_path . '/' . $tmp_filename .'.'. Config::get('spr.type.mimeFile')[$client_original_mime];

                    $path  = substr($full_path_file_tmp, strpos($full_path_file_tmp, 'assets/'));
                    $path  = str_replace('\\', '/', $path);

                    // save file tmp
                    Image::make($file)->save($full_path_file_tmp, 100);

                    // add file to session
                    array_push($list_file_upload, $new_file_upload);

                    Session::put($this->name_session_file_upload, $list_file_upload);

                    //insert data into database
                    // table media: id, path, name, type, path_thumb, title
                    $ModelMedia = new ModelMedia();

                    $where = [];

                    $data = [
                        'name'          => $tmp_filename,
                        'path'         => $path,
                        'tmp_path'     => $path,
                        'url'           => '',
                        'tmp_url'       => '',
                        'slug'          => '',
                        'description'   => '',
                        'type'          => $file_mime,
                        'status'        => '0',
                        'created_at'    => strtotime(\Carbon\Carbon::now()->toDateTimeString()),
                        'created_by_id' => Auth::guard('web')->user()->id,
                    ];

                    $results = $ModelMedia->insertData($data, $where);
                    $data_output_validate_param['response']['data']  = $results;

                } catch (NotReadableException $e) {

                    $data_output_validate_param['meta']['success'] = false;
                    $data_output_validate_param['meta']['code'] = 501;
                    $data_output_validate_param['meta']['msg'] = [Lang::get('action\message.error.00004')];

                }
            }

            $data_output_validate_param['response']['image']  = $new_file_upload;
        }

        return $data_output_validate_param;
    }


    public function getData($data_output_validate_param) {

        $sort           = $data_output_validate_param['response']['sort'];
        $limit          = $data_output_validate_param['response']['limit'];
        $sort_type      = $data_output_validate_param['response']['sort_type'];
        $key_search     = $data_output_validate_param['response']['key_search'];

        // $this->removeAllMediaTmp($data_output_validate_param);

        if($data_output_validate_param['meta']['success']) {

            $table  = '';
            $ModelMedia = new ModelMedia();

            $data = $ModelMedia->getDataManage($key_search, $limit, $sort, $sort_type);

            $data_output_validate_param['response']['data'] = $data;
        }else {

            $data_output_validate_param['response'] = array();
            $data_output_validate_param['response']['data'] = $data_output_validate_param;
        }

        return $data_output_validate_param['response'];
    }

}