<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if (! $user || ! ($user->is_admin ?? false)) {
            $message = 'Akses ditolak — halaman ini hanya untuk admin.';
            if ($request->wantsJson()) {
                return response()->json(['message' => $message], 403);
            }

            // redirect to dashboard (or home) with flash message
            if (Route::has('dashboard')) {
                return redirect()->route('dashboard')->with('error', $message);
            }

            return redirect('/')->with('error', $message);
        }

        return $next($request);
    }
}
