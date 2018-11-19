<?php

namespace Spr\Base\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use DB;
use Spr\Base\Models\PermissionRoles as ModelPermissionRoles;
use Spr\Base\Models\Module as ModelModule;
use App\Http\Models\Support as ModelSupport;
use Spr\Base\Models\Roles as ModelRoles;
use App\Http\Models\Setting as ModelSetting;

// use Spr\Base\Models\Media as ModelMedia;
use Spr\Base\Response\Response as ResponseBase;
// use App\Http\Controllers\GroupMediaController;
use Session;
use Config;
use Request;
use Cache;
use Auth;
use Cookie;
use App;
class Maintenance
{
     /**
     * The Guard implementation.
     *
     * @var Guard
     */
     // protected $auth;

     /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
     public function __construct()
     {
          // $this->auth = $auth;
     }

     /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
     public function handle($request, Closure $next)
     {
           // Cache::flush();
          // Cache::flush(); remove all cache
          // $this->setCacheModule();
          // $this->setCategoriesProduct();
          // $this->setCacheRoles();
          // $this->setCachePermissionRoles();
          // $this->setSessionEchaneRate();
          // $this->setCacheTransactionStatus();
          // $this->setCacheLogo();
          // $this->setCacheWhyChooseUs();
          // $this->setCacheServices();
          // $this->setCacheEmailSupport();
          // $this->setCacheHotline();
          // $this->setCacheCompanyName();
          // $this->setCacheTotalProducts();
          // $this->setCacheTotalTransactionSucess();
          // $this->setCacheDescription();
          // $this->setCacheCommitment();
          // $this->setCacheEmpSupport();


          if (strpos($_SERVER['HTTP_USER_AGENT'], "Mobile") != false ) {

               define('MOBILE_OR_WEB', 'mobile');

          } else {

               define('MOBILE_OR_WEB', 'user');
          }

          $cookies_lang = Cookie::get('applocale');
          if( $cookies_lang !== null and array_key_exists($cookies_lang, Config::get('languages')) )
          {
               if($cookies_lang == 0) $cookies_lang = 'vi';
               App::setLocale($cookies_lang);
          }

          $maintenance_system = Config::get('spr.system.maintenance.system');

          if($maintenance_system){

               if($request->is('api/*')){

               return response()->json(array(

                    'meta' => array(
                         'code' => '500',
                         'msg'  => Lang::get('message.error.00015'),
                         'success' => false
                    ),
                    'response' => null
               ));

               }else {

                return redirect()->route('maintenance');
               }

          }else {

               return $next($request);
          }
     }


     public function setSessionEchaneRate() {

          $ExchangeRatesCurrency = ExchangeRates::getExchangeRate();
          Session::put('ExchangeRateCurrency-'.Request::ip(), $ExchangeRatesCurrency['response']);
     }

     public function  setCachePermissionRoles () {

          if(Auth::check() ){

               if(!Cache::has('permissionRoles')){

                    $ModelPermissionRoles= new ModelPermissionRoles();
                    $dataPermissionRoles = $ModelPermissionRoles->getAllDataRoles();
                    $lengthData = COUNT($dataPermissionRoles['response']);
                    $arrayData = array();
                    $dataRoles = Cache::get('roles');
                    $lengthDataRoles = COUNT($dataRoles);

                    for ($i=0; $i < $lengthData; $i++) {

                         $role_id = $dataPermissionRoles['response'][$i]->roles_id;
                         $module_id = $dataPermissionRoles['response'][$i]->module_id;
                         $dataPermission = $this->getDataPermissionRoles($dataPermissionRoles['response'][$i]);

                         if(isset($arrayData[$role_id])){

                              $arrayData[$role_id][$module_id] = $dataPermission;
                         }else {


                              $arrayData[$role_id] = [$module_id => $dataPermission];
                         }
                    }
                    Cache::forget('permissionRoles');
                    Cache::forever('permissionRoles', $arrayData);
               }
          }
     }

     public function getDataPermissionRoles($data) {

          $dataReturn = [];

          foreach ($data as $key => $value) {
               if($key != 'id' && $key != 'module_id' && $key != 'roles_id') {
                    $dataReturn[$key] = $value;
               }
          }
          return $dataReturn;
     }

     public function  setCacheModule () {

          if(!Cache::has('module')){

               $ModelModule = new ModelModule();
               $dataModelModule = $ModelModule->getAllData();
               if(!empty($dataModelModule['response'])) {

                    $lengthData = COUNT($dataModelModule['response']);
                    $arrayData = array();

                    for ($i=0; $i < $lengthData; $i++) {

                         $arrayData[$dataModelModule['response'][$i]->name] = $dataModelModule['response'][$i]->id;
                    }
                    Cache::forever('module', $arrayData);
               }
          }
     }

     public function  setCacheAuthen () {

          if(!Cache::has('auth')){

               $auth = $_SERVER['HTTP_USER_AGENT'];
               Cache::forever('module', $auth);
          }
     }

     public function  setCacheRoles () {

          if(!Cache::has('roles')){

               $ModelRoles = new ModelRoles();
               $dataModelRoles = $ModelRoles->getAllData();

               if(!empty($dataModelRoles['response'])) {
                    
                    $lengthData = COUNT($dataModelRoles['response']);
                    $arrayData = array();
                    for ($i=0; $i < $lengthData; $i++) {

                         $arrayData[$dataModelRoles['response'][$i]->id] = array(
                         'name' => $dataModelRoles['response'][$i]->name,
                         'slug' => $dataModelRoles['response'][$i]->slug
                         );
                    }
                    Cache::forever('roles', $arrayData);
               }
          }
     }

     public function setCacheLogo() {

          if(!Cache::has('logo')){

               $ModelSetting = new ModelSetting();
               $logo = $ModelSetting->getLogo();
               if(!empty($logo['response'])) {

                    $lengthData = COUNT($logo['response']);
                    $url_logo   = "";

                    for ($i=0; $i < $lengthData; $i++) {

                         $url_logo = $logo['response'][$i]->path;
                    }

                    Cache::forever('logo', $url_logo);
               }
          }
     }

     public function setCacheEmailSupport() {

          if(!Cache::has('email_support')){

               $email_support = $this->getSettingFollowKey(Config::get('spr.type.setting.company-info.email_support.key'));
               
               if(!empty($email_support['response'])) {

                    $lengthData = COUNT($email_support['response']);
                    $data   = "";

                    for ($i=0; $i < $lengthData; $i++) {

                         $data = $email_support['response'][$i]->title;
                    }

                    Cache::forever('email_support', $data);
               }
          }
     }

     public function setCacheHotline() {

          if(!Cache::has('hotline')){

               $ModelSetting  = new ModelSetting();
               $hotline       = $this->getSettingFollowKey(Config::get('spr.type.setting.company-info.hotline.key'));
               if(!empty($hotline['response'])) {

                    $lengthData = COUNT($hotline['response']);
                    $data   = "";

                    for ($i=0; $i < $lengthData; $i++) {

                         $data = $hotline['response'][$i]->title;
                    }

                    Cache::forever('hotline', $data);
               }
          }
     }

     public function setCacheCompanyName() {

          if(!Cache::has('company_name')){

               $ModelSetting = new ModelSetting();
               $company_name = $this->getSettingFollowKey(Config::get('spr.type.setting.company-info.company_name.key'));
               
               if(!empty($company_name['response'])) {

                    $lengthData = COUNT($company_name['response']);
                    $data   = "";

                    for ($i=0; $i < $lengthData; $i++) {

                         $data = $company_name['response'][$i]->title;
                    }

                    Cache::forever('company_name', $data);
               }
          }
     }

     public function setCacheTotalTransactionSucess() {

          if(!Cache::has('total_transaction_success')){

               $ModelSetting = new ModelSetting();
               $total_transaction_success = $this->getSettingFollowKey(Config::get('spr.type.setting.company-info.total_transaction_success.key'));
               
               if(!empty($total_transaction_success['response'])) {

                    $lengthData = COUNT($total_transaction_success['response']);
                    $data   = "";

                    for ($i=0; $i < $lengthData; $i++) {

                         $data = $total_transaction_success['response'][$i]->title;
                    }

                    Cache::forever('total_transaction_success', $data);
               }
          }
     }

     public function setCacheDescription() {

          if(!Cache::has('description')){

               $ModelSetting = new ModelSetting();
               $description = $this->getSettingFollowKey(Config::get('spr.type.setting.company-info.sub_description.key'));
               
               if(!empty($description['response'])) {

                    $lengthData = COUNT($description['response']);
                    $arrayData = array();

                    for ($i=0; $i < $lengthData; $i++) {

                         $tmp = [];
                         $tmp['title']            =    $description['response'][$i]->title;
                         $tmp['path']            =    $description['response'][$i]->path;
                         $tmp['description']      =    $description['response'][$i]->description;
                         array_push($arrayData, $tmp);
                    }

                    Cache::forever('description', $arrayData);
               }
          }
     }


     public function setCacheCommitment() {

          if(!Cache::has('commitment')){

               $ModelSetting = new ModelSetting();
               $commitment = $this->getSettingFollowKey(Config::get('spr.type.setting.commitment-of-company.key'));
               
               if(!empty($commitment['response'])) {

                    $lengthData = COUNT($commitment['response']);
                    $arrayData = array();

                    for ($i=0; $i < $lengthData; $i++) {

                         $tmp = [];
                         $tmp['title']            =    $commitment['response'][$i]->title;
                         $tmp['path']            =    $commitment['response'][$i]->path;
                         $tmp['description']      =    $commitment['response'][$i]->description;
                         $tmp['icon_class']       =    $commitment['response'][$i]->icon_class;
                         array_push($arrayData, $tmp);
                    }

                    Cache::forever('commitment', $arrayData);
               }
          }
     }

     public function setCacheServices() {

          if(!Cache::has('services')){

               $data_services =    $this->getSettingFollowKey(Config::get('spr.type.setting.services-of-company.key'));

               if(!empty($data_services['response'])) {

                    $lengthData = COUNT($data_services['response']);
                    $arrayData = array();

                    for ($i=0; $i < $lengthData; $i++) {

                         $tmp = [];
                         $tmp['title']            =    $data_services['response'][$i]->title;
                         $tmp['path']            =    $data_services['response'][$i]->path;
                         $tmp['description']      =    $data_services['response'][$i]->description;
                         $tmp['icon_class']       =    $data_services['response'][$i]->icon_class;
                         array_push($arrayData, $tmp);
                    }

                    Cache::forever('services', $arrayData);
               }
          }
     } 


     public function setCacheEmpSupport() {

          if(!Cache::has('support')){

               $ModelSupport  =    new ModelSupport();
               $data          =    $ModelSupport->getDataForUser();
               if(!empty($data['response'])) {

                    $lengthData = COUNT($data['response']);
                    $arrayData = array();

                    for ($i=0; $i < $lengthData; $i++) {

                         $tmp = [];
                         $tmp['employee_name']              =    $data['response'][$i]->employee_name;
                         $tmp['field_support']              =    $data['response'][$i]->field_support;
                         $tmp['phone']                      =    $data['response'][$i]->phone;
                         $tmp['path']                      =    $data['response'][$i]->path;
                         array_push($arrayData, $tmp);
                    }

                    Cache::forever('support', $arrayData);
               }
          }
     }

     public function getSettingFollowKey($key)
     {

          $results       = ResponseBase::response(); 
 
          $ModelSetting = new ModelSetting();

          $where = [
               [
                'fields'    =>  's.key',
                'operator'  =>  '=',
                'value'     =>  $key,
               ],
               [
                'fields'    =>  's.deleted_at',
                'operator'  =>  'null',
                'value'     =>  'NULL'
               ]
          ];

          $data = $ModelSetting->getData($where);
          if($data['meta']['success']){

               $results  =    $data;
          }

          return $results;
     }
     

}
