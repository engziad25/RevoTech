<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ThemeMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Get theme from cookie, session, or default to light
        $theme = Cookie::get('theme', session('theme', 'light'));
        
        // Share theme with all views
        view()->share('theme', $theme);
        
        return $next($request);
    }
}