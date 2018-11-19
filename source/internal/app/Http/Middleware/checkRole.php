<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Response\Response;
use App\Http\Models\User;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next,$guard = null)
    {

        $dataRoles = $this->getDataRoles()['response'];

        // dd( $dataRoles );

        // if ( Auth::check() && Auth::user()->isAdmin())
        if ( Auth::check() && $dataRoles[0]->roleId == '1')
        {
            return $next($request);
        }
        return redirect()->route('user-index');

    }

    private function getDataRoles() {

        $table = 'employee_role_relationship';

        try {

            $data       = DB::table($table)->where('id', '=', Auth::user()->id)
                                            ->get();
            $results    = Response::response(200, '', $data, true);

        } catch (Exception $e) {

            $results['meta']['success'] = false;
            $results['meta']['msg']     = $e->getMessage();
        }

        return $results;

    }
}