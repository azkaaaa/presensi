<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class isManager
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
        if(auth()->check() && $request->user()->level == 'manager'){
            return $next($request);
        }
        
        return redirect()->guest('/');
    }
}
