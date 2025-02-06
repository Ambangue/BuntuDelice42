<?php

namespace App\Http\Middleware;

use Closure;

class DeliveryMiddleware
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
        if (auth()->check() and auth()->user()->restaurant()->first()->services === 'delivery')
            return $next($request);

        return redirect()->back();
    }
}
