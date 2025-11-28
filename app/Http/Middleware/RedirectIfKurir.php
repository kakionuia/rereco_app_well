<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfKurir
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->is_kurir) {
            // Jika kurir, redirect ke dashboard kurir kecuali sudah di dashboard kurir
            if (! $request->routeIs('kurir.dashboard')) {
                return redirect()->route('kurir.dashboard');
            }
        }
        return $next($request);
    }
}
