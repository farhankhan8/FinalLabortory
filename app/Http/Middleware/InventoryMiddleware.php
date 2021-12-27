<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class InventoryMiddleware
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
        if(auth::check() && Auth::user()->role == 'admin' || Auth::user()->role == 'manager' || Auth::user()->role == 'technician'){
            return $next($request);
         }
         else {
            return redirect()->route('login');
         }
    }
}
