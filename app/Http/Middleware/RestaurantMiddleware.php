<?php

namespace App\Http\Middleware;

use Closure;

class RestaurantMiddleware
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
        if (auth()->check() and auth()->user()->type === 'restaurant')
            return $next($request);

        return redirect()->back();
    }
}
