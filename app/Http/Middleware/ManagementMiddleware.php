<?php

namespace App\Http\Middleware;

use Closure;

use Auth;

class ManagementMiddleware
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
		if(Auth::user()->hasRole('Management'))
			return $next($request);
		else
			return back();
    }
}
