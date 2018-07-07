<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class UserMiddleware
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
        if(Auth::check() && Auth::user()->status == 1){
            if(Auth::user()->role == 2){
                return $next($request);
            }
            return redirect('/adminDash');

        }else{
            Auth::logout();
            return redirect('/login');
        }
    }
}
