<?php

namespace Spr\Base\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Auth;
use Redirect;
class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        if (Auth::guard($guard)->guest()) {
            if($request->is('api/*')){

                return response()->json(array(

                    'meta' => array(
                        'code' => '401',
                        'msg'  => Lang::get('message.error.00016'),
                        'success' => false
                    ),
                    'response' => null
                ));
            } else {

                return redirect('/login');
            }
        }

        return $next($request);
    }
}
