<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckRetailer
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
        if(Auth::user()->user_type > 50) {
            return redirect('/');
        }
        return $next($request);
    }
}
