<?php

namespace App\Http\Middleware;


use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class ProtectAdminRole
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
        $user = new  User();
        if (Auth::user()->email == $user->admin_email()) {
            return $next($request);
        }

        return redirect()->back()->with('warning', '不是后台管理员');
    }
}
