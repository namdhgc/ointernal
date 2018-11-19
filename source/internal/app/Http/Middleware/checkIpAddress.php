<?php

namespace App\Http\Middleware;

use Closure;
use Config;

class CheckIpAddress
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

        $client_ip_address = $this->get_client_ip();

        // dd($client_ip_address);

        if (in_array($client_ip_address, Config::get('system.AllowedIpAddress'))) {
                
            return $next($request);
        }
        
        return redirect()->route('404');
    }

        // Function to get the client IP address
        public function get_client_ip() {

        $ipaddress = '';

        if (isset($_SERVER['HTTP_CLIENT_IP']))

            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];

        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))

            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];

        else if(isset($_SERVER['HTTP_X_FORWARDED']))

            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))

            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];

        else if(isset($_SERVER['HTTP_FORWARDED']))

            $ipaddress = $_SERVER['HTTP_FORWARDED'];

        else if(isset($_SERVER['REMOTE_ADDR']))

            $ipaddress = $_SERVER['REMOTE_ADDR'];

        else

            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }
}