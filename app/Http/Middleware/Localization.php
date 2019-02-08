<?php

namespace App\Http\Middleware;

use Closure;

class Localization
{
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            if (!session()->has('localization')) {
                session(['localization' => auth()->user()->language]);
            }
            \App::setLocale(session('localization'));
        }

        return $next($request);
    }
}
