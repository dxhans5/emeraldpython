<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Redirect;
use Request;

class NoSSL
{

    public function handle($request, Closure $next)
    {
        if( App::environment('local') && Request::secure() ){
            return Redirect::to(Request::getRequestUri(), 302, array(), false);
        }

        return $next($request);
    }
}