<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocalizationMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // 1. Cek apakah user sudah punya Session bahasa
        if (Session::has('locale')) {
            // 2. Jika ya, atur bahasa aplikasi sesuai Session
            App::setLocale(Session::get('locale'));
        }

        // Lanjutkan request
        return $next($request);
    }
}
