<?php

namespace App\Http\Middleware;

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
        $this->validateClientToken($request);
        $this->validateUserToken($request);

        return $next($request);
    }

    private function validateClientToken(Request $request) {
        print_r('here');
    }
}
