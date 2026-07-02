<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLevel
{
    /**
     * Handle an incoming request.
     * Contoh penggunaan di route: middleware('checkLevel:1,2') artinya hanya level 1 dan 2 yg boleh akses
     */
    public function handle(Request $request, Closure $next, ...$levels): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $userLevel = auth()->user()->id_level;

        // Admin (Level 1) can access everything
        if ($userLevel == 1) {
            return $next($request);
        }

        if (!in_array($userLevel, $levels)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
