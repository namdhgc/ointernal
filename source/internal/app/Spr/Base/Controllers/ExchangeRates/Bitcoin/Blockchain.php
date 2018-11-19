<?php
namespace Shaphira\Base\Controllers\ExchangeRates\Bitcoin;

use App\Http\Models\User;
use App\Http\Controllers\Controller;
use Shaphira\Base\Response\Response;
use Illuminate\Support\Facades\Input;
use Shaphira\Base\Controllers\Http\Request;
use Config;
use Auth;
use Cache;
use Session;
use Mail;
use Hash;
use Lang;

class Blockchain extends Controller
{

    public function __construct () {

    }

    public static function getExchangeRate ($source, $listCurrency) {

        $Request = new Request();
        $objExchangeRates = $Request->getJsonFromUrl($source);

        $Response   = new Response();
        $results    = $Response->response(200,'','',true);

        $dataExchangeRates = array();

        // ngay up date $xmlData['1']['value'];
        if($objExchangeRates){

            $error = false;
            foreach($listCurrency as $v){

                if(isset($objExchangeRates->$v))
                {
                    $data[$v] = $objExchangeRates->$v->sell;
                    if($data[$v] == 0) $error = true;
                }
            }
            if(!$error){
                if(Cache::has('ExchangeRateBitcoin')){
                    Cache::forget('ExchangeRateBitcoin');
                }
                Cache::forever('ExchangeRateBitcoin',$data);
                $results['response'] = $data;
            }else {
                if(Cache::has('ExchangeRateBitcoin')){
                    $results['response'] = Cache::get('ExchangeRateBitcoin');
                }else {
                    $results['meta']['success'] = false;
                }
            }
            return $results;

        }else {
            if(Cache::has('ExchangeRateBitcoin')){
                $results['response'] = Cache::get('ExchangeRateBitcoin');
            }else {
                $results['meta']['success'] = false;
            }
        }
        return $results;
    }
}

?>