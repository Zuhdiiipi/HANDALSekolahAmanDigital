<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSchoolProfile
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jika user adalah school tapi profilnya tidak ada di database
        if (Auth::check() && Auth::user()->role === 'school' && !Auth::user()->school) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Profil sekolah Anda belum dibuat oleh validator.');
        }

        return $next($request);
    }
}
