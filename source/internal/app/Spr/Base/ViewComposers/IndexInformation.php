<?php
// Đây là file cung cấp data cho các file được include mà route ko thể tác động
namespace Spr\Base\ViewComposers;

use Illuminate\Contracts\View\View;
// use Illuminate\Users\Repository as UserRepository;
use App\Http\Models\Banner as  ModelsBanner;
use App\Http\Controllers\CityController;
// use App\Http\Models\Message as ModelMessage;
use Auth;
use Cache;
use Config;
use Lang;
class IndexInformation
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
    	$ModelsBanner = new ModelsBanner();
    	$data = $ModelsBanner->getData();

        $view->with('banner', $data['response']);
    }
};
?>