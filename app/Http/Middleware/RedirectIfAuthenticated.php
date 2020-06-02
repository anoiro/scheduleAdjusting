<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        //追記。マルチログイン
        switch ($guard) {
            case 'admin':
                $redirectPath = '/admin/index';
                break;
            default:
                $redirectPath = '/index';
                break;
        }
        if (Auth::guard($guard)->check()) {
            //return redirect('/home');
            //変更。マルチログイン
            return redirect($redirectPath);
        }

        return $next($request);
    }
}
