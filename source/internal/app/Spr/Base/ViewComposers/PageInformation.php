<?php
// Đây là file cung cấp data cho các file được include mà route ko thể tác động
namespace Spr\Base\ViewComposers;

use Illuminate\Contracts\View\View;
// use Illuminate\Users\Repository as UserRepository;
use App\Http\Models\User as  ModelsUser;
// use App\Http\Models\Message as ModelMessage;
use Auth;
use Cache;
use Config;
use Lang;
use Spr\Base\Controllers\Helper as HelperController;

class PageInformation
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $users;

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
    	$data = array(

	    	'hor-menu' => [
	    			[
	    				'id'	=> '',
	    				'use' 	=> true,
			    		'name' 	=> Lang::get('menu.dashboard'),
			    		'slug'	=> 'dashboard',
			    		'url'	=> 'dashboard',
			    		'icon'	=> 'icon-home',
			    		'route' => 'auth-get-dashboard',
			    		'sub'	=> ''
			    	],
			    	[
	    				'id'	=> '',
	    				'use' 	=> false,
			    		'name' 	=> Lang::get('menu.register-user'),
			    		'slug'	=> 'register-user',
			    		'url'	=> 'register-user',
			    		'icon'	=> 'icon-user',
			    		'route' => 'auth-get-register-user',
			    		'sub'	=> ''
			    	],
		    	],
			'top-menu' => [
			]

	    );


		$count = COUNT($data['hor-menu']);
        for ($i=0; $i < $count; $i++) {

        	$slug = $data['hor-menu'][$i]['slug'];
        	$permission = HelperController::checkPermission(Auth::guard('web')->user()->roles, $slug, 'read');

			if($permission){

                $data['hor-menu'][$i]['use'] = true;

                if($data['hor-menu'][$i]['sub'] != ''){

                	$count_sub = COUNT($data['hor-menu'][$i]['sub']);

                	for ($j=0; $j < $count_sub; $j++) {

                		$sub_slug 	= $data['hor-menu'][$i]['sub'][$j]['slug'];
                		$permission = HelperController::checkPermission(Auth::guard('web')->user()->roles, $sub_slug, 'read');

						if($permission){

            				$data['hor-menu'][$i]['sub'][$j]['use'] = true;
            			}else {

            				$data['hor-menu'][$i]['sub'][$j]['use'] = false;
            			}
                	}
                }
            }else {

                // $data['hor-menu'][$i]['use'] = false;   // temporarily comment for testing
                $data['hor-menu'][$i]['use'] = true;
            }

        }

		$actual_link = $_SERVER['REQUEST_URI'];
		$list_segment = explode('/', $actual_link);
		// $ModelsUser = new ModelsUser();
		// $dataUser = $ModelsUser->getDataById(Auth::user()->id);
        $view->with('data', array(
        	'data' => $data,
        	'actual_link' => $actual_link,
        	'list_segment' => $list_segment,
        	// 'user'	=> $dataUser['response'][0],
        ));
    }
};
?>