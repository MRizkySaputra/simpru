<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
{
    // Cek setting di database
    $isMaintenance = \App\Models\Setting::where('key', 'maintenance_mode')->value('value') == '1';

    // Jika maintenance aktif DAN bukan admin, alihkan ke halaman maintenance
    if ($isMaintenance && auth()->check() && auth()->user()->role !== 'admin') {
        return response()->view('maintenance'); // Kita perlu buat view ini
    }

    return $next($request);
}
}
