<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // التحقق من وجود لغة محفوظة في الجلسة
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        } else {
            // استخدام اللغة الافتراضية
            App::setLocale('en');
        }

        return $next($request);
    }
}
