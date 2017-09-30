<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Entrust
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!preg_match('((index|create|edit|show)$)', Route::currentRouteName())) {
            if (!Auth::user()->hasRole("admin") && Auth::user()->email != Auth::user()->admin_email())
                if (!Auth::user()->hasPerm(Route::currentRouteName())) {
                    return redirect()->back()->withErrors('没有权限！');
                }
        }
        return $next($request);
    }
}
