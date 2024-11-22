<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class EnsureAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        // Abaikan route API
        if ($request->is('api/*')) {
            return $next($request);
        }

        // Abaikan halaman login
        if ($request->routeIs('login')) {
            return $next($request);
        }

        // Jika tidak ada token di session, redirect ke login
        if (!session()->has('token')) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }
        if ($request->is('api/v1/login') && $request->method() === 'GET') {
            \Log::error('GET request made to api/v1/login');
        }

        return $next($request);
    }
}