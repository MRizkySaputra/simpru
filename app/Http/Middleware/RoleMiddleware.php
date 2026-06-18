<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        if (!Auth::check() || !in_array(Auth::user()->role, $roles)) {
            if (Auth::check()) {
                return Auth::user()->role === 'admin'
                    ? redirect('/admin/dashboard')
                    : redirect('/user/dashboard');
            }

            return redirect('/login');
        }

        return $next($request);
    }
}
