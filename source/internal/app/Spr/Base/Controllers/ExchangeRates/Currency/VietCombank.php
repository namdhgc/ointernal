<?php

namespace Spr\Base\Controllers\ExchangeRates\Currency;

use App\Http\Models\User;
use App\Http\Controllers\Controller;
use Spr\Base\Response\Response;
use Illuminate\Support\Facades\Input;
use Spr\Base\Controllers\Http\Request;
use Config;
use Auth;
use Cache;
use Session;
use Mail;
use Hash;
use Lang;

class VietCombank extends Controller
{

    public function __construct () {

    }

    public static function getExchangeRate ($source, $listCurrency) {

        $Request = new Request();

        $Response   = new Response();
        $results    = $Response->response(200,'','',true);
        try {
            $xmlExchangeRates = $Request->getXml($source);

            $dataExchangeRates = array();
            // ngay up date $xmlExchangeRates['1']['value'];
            if($xmlExchangeRates){
                $data = array();
                foreach($xmlExchangeRates as $v){

                    if(isset($v['attributes']) && isset($v['attributes']['CURRENCYCODE']) && in_array($v['attributes']['CURRENCYCODE'], $listCurrency))
                    {
                        $data[$v['attributes']['CURRENCYCODE']] = $v['attributes']['BUY'];
                    }
                }

                if(!empty( $data )){

                    if(Cache::has('ExchangeRateCurrency')){
                        Cache::forget('ExchangeRateCurrency');
                    }
                    Cache::forever('ExchangeRateCurrency',$data);
                    $results['response'] = $data;
                }else {
                    $results['meta']['success'] = false;
                    $results['meta']['code'] = 501;
                }
            }else {
                if(Cache::has('ExchangeRateCurrency')){
                    $results['response'] = Cache::get('ExchangeRateCurrency');
                }else {
                    $results['meta']['success'] = false;
                }
            }
        } catch (Exception $e) {
            $results['meta']['success'] = false;
        }
        if(!$results['meta']['success'] && Cache::has('ExchangeRateCurrency')) {
            $results['meta']['success'] = true;
            $results['meta']['code'] = 200;
            $results['response'] = Cache::get('ExchangeRateCurrency');
        }
        return $results;
    }
}
