<?php

namespace Spr\Base\Controllers\Permission;

use Spr\Base\Models\Media as ModelMediaLibrary;
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

/**
* 
*/
class Media extends Controller
{
	
	function __construct()
	{
		# code...
	}

	public function getData($data_output_validate_param) {

        
    }
}