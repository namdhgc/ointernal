<?php
namespace Spr\Base\Controllers;

use Config;
use Spr\Base\Response\Response;
use Lang;
use App\Http\Models\User;
use Hash;
use Validator;
use Auth;
use File;
use Cache;

class Helper {

    public function __construct () {

    }

    public static function html_entity_encode_XSS_attack($string) {

		$tag_html = Config::get('spr.system.init.htmlTag');
		$string = htmlentities($string);
		// $string = str_replace("\r\n", '', $string);

		$countTag = COUNT($tag_html);

		for ($i=0; $i < $countTag; $i++) {

			switch ($tag_html[$i]) {
				case 'javascript:':

					$string = str_replace('javascript:',"javascript :",$string);
					break;

				case 'script':

					$string = str_replace("&lt;script&gt;"," ",$string);
					$string = str_replace("&lt;script","",$string);
					$string = str_replace("&lt;/".$tag_html[$i]."&gt;"," ",$string);
					$string = str_replace($tag_html[$i],"",$string);
					break;

				case '&nbsp;':

					$string = str_replace('&nbsp;'," ",$string);
					break;

				case '&amp;':

					$string = str_replace('&amp;',"&",$string);
					break;

				case '&quot;':

					$string = str_replace("&quot;","&quot;",$string);
					break;

				default:

					$string = str_replace("&lt;".$tag_html[$i]."&gt;","<".$tag_html[$i].">",$string);
					$string = str_replace("&lt;".$tag_html[$i],"<".$tag_html[$i],$string);
					$string = str_replace("&lt;/".$tag_html[$i]."&gt;","</".$tag_html[$i].">",$string);
					break;
			}
		}
		// var_dump($string);
		// exit;
		return $string;
    }

    public static function returnDataManageView($data, $dataInput){

    	$_return = array('data' => $data);

    	foreach ($dataInput as $key => $value) {
    		$_return[$key] = $value;
    	}
    	return $_return;
    }

    public static function remove_file($path){

    	if( File::exists($path) ){
    		
    		File::delete($path);
    	}
    }

    public static function create_path($path){
    	
    	if ( ! is_dir($path)) mkdir($path, 0777, true);
    }

	public static function time_elapsed_A($secs){
		//6d 15h 48m 19s
	    $bit = array(
	        'y' => $secs / 31556926 % 12,
	        'w' => $secs / 604800 % 52,
	        'd' => $secs / 86400 % 7,
	        'h' => $secs / 3600 % 24,
	        'm' => $secs / 60 % 60,
	        's' => $secs % 60
	        );

	    foreach($bit as $k => $v){

	        if($v > 0)$ret[] = $v . $k;
	    }

	    return join(' ', $ret);
    }


	public static function time_elapsed_B($secs){
		//6 days 15 hours 48 minutes and 19 seconds ago.
	    $bit = array(
	        ' year'      => $secs / 31556926 % 12,
	        ' week'      => $secs / 604800 % 52,
	        ' day'       => $secs / 86400 % 7,
	        ' hour'      => $secs / 3600 % 24,
	        ' minute'    => $secs / 60 % 60,
	        ' second'    => $secs % 60
	        );

	    foreach($bit as $k => $v){

	        if($v > 1)$ret[] = $v . $k . 's';
	        if($v == 1)$ret[] = $v . $k;
	    }

	    array_splice($ret, count($ret)-1, 0, 'and');

	    $ret[] = 'ago.';

	    return join(' ', $ret);
    }

    public static function uniqid_base36($timestamp = '', $more_entropy = true ) {

	    $s = uniqid($timestamp, $more_entropy);

	    if (!$more_entropy)
	        return base_convert($s, 16, 36);

	    $hex = substr($s, 0, 13);
	    $dec = $s[13] . substr($s, 15);

	    return base_convert($hex, 16, 36) . base_convert($dec, 10, 36);
	}

	public static function checkPermission ($roles, $module, $action = "read") {


		if(Cache::has('permissionRoles') && Cache::has('module')) {

			$data_cache_permission = Cache::get('permissionRoles');
			$data_cache_module = Cache::get('module');
			if($module == '') return true;
			if(isset($data_cache_permission[$roles]) && isset($data_cache_module[$module]) ) {

				if(isset($data_cache_permission[$roles][$data_cache_module[$module]])) {

					if($data_cache_permission[$roles][$data_cache_module[$module]][$action] == 1) {

						return true;
					}
				}
			}
		
		}

		return false;
	}
}