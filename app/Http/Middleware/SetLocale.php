<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\LanguageHelper;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if locale is set in session
        if (session()->has('locale')) {
            app()->setLocale(session()->get('locale'));
        } else {
            // Set default locale
            app()->setLocale('ar');
            session()->put('locale', 'ar');
        }

        return $next($request);
    }
}
