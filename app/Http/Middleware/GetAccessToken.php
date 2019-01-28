<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Facades\App\Models\Config;

class GetAccessToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $config = Config::getFirst();
        //print_r($config); die();

        return $next($request);
    }
}
