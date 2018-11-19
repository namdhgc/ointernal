<?php

namespace Spr\Base\Controllers\ExchangeRates;

use App\Http\Models\User;
use App\Http\Controllers\Controller;
use Spr\Base\Response\Response;
use Illuminate\Support\Facades\Input;
use Spr\Base\Controllers\Http\Request;
use Spr\Base\Controllers\ExchangeRates\Currency\VietCombank;
use Config;
use Auth;
use Cache;
use Session;
use Mail;
use Hash;
use Lang;

class ExchangeRates extends Controller
{

    public function __construct () {

    }

    public static function getExchangeRate () {

    	$Response = new Response();
    	$msg = array();

		$sourceExchangeRatesCurrency = Config::get('spr.exchangeRates.currency.vietcombank.source');
		$listCurrency = array('JPY');
		$ExchangeRatesCurrency = VietCombank::getExchangeRate($sourceExchangeRatesCurrency, $listCurrency);

		return $ExchangeRatesCurrency;
    }
}



