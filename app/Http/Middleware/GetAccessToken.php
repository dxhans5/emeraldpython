<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
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
        if ($config->user_token) {
            $start_time = Carbon::now();
            $end_time = $config->user_token_expires_at;

            print_r($start_time . " ==== " . Carbon::createFromTimestamp($end_time)); die();
        } else {
            Token::validate($request);
        }

        return $next($request);
    }
}
