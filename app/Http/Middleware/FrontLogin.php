<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class FrontLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(empty(Session::has('frontSession'))){
            return redirect()->route('get.user_login');
        }
        return $next($request);
    }
}