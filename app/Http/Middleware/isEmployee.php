<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class isEmployee
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
        if(auth()->check() && $request->user()->level == 'Karyawan'){
            return $next($request);
        }
        
        return redirect()->guest('/');
    }
}
