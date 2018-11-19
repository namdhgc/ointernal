<?php
// Đây là file cung cấp data cho các file được include mà route ko thể tác động
namespace Spr\Base\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Http\Models\News as ModelNews;
use App\Http\Models\NewsCategories as ModelNewsCategories;
use Config;
use Cache;
use Lang;
use Auth;
class AsideUserInformation
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

        $table_news_category    = 'news_category';
    	$table_news             = 'news';
        $key_search             = '';

        $ModelNewsCategories       = new ModelNewsCategories();
        $ModelNews                 = new ModelNews();

    	$where = [
    		[
    			'fields'	=> 'deleted_at',
    			'operator'	=> 'null'
    		]
    	];


        $results_news_category     = $ModelNewsCategories->getAllCategory();
        $results_news              = $ModelNews->getNewsForCategory();

        $view->with('data_aside_user_information', array(
            'category'  => $results_news_category,
        	'news'      => $results_news,
        ));
    }
};
?>