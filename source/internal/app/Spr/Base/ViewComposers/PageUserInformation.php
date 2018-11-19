<?php
// Đây là file cung cấp data cho các file được include mà route ko thể tác động
namespace Spr\Base\ViewComposers;

use Illuminate\Contracts\View\View;
// use Illuminate\Users\Repository as UserRepository;
use App\Http\Models\Agency as ModelAgency;
use Config;
use Cache;
use Lang;
use Auth;
class PageUserInformation
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

    	$table = 'agency';
    	$where = [
    		[
    			'fields'	=> 'deleted_at',
    			'operator'	=> 'null'
    		]
    	];

    	$ModelAgency 	= new ModelAgency();
    	$results 		= $ModelAgency->selectData($table, $where);

        $view->with('data_user', array(
        	'agency' => $results
        ));
    }
};
?>