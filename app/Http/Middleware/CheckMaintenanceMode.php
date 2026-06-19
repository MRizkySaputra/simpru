<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckMaintenanceMode
{
    public function handle(Request $request, Closure $next)
    {
        $isMaintenance = \App\Models\Setting::where('key', 'maintenance_mode')->value('value') == '1';

        if ($isMaintenance && Auth::check() && Auth::user()->role !== 'admin') {
            return response()->view('maintenance');
        }

        return $next($request);
    }
}
