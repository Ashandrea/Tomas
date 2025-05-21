<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get locale from the following sources in order of priority:
        // 1. URL parameter (if any)
        // 2. User's preference (from database)
        // 3. Session
        // 4. Cookie
        // 5. Fallback to config
        
        $locale = $request->query('lang') 
                   ?? (Auth::check() ? Auth::user()->language : null)
                   ?? Session::get('locale')
                   ?? $request->cookie('locale')
                   ?? config('app.locale');
        
        // Ensure the locale is supported
        if (in_array($locale, ['en', 'id'])) {
            App::setLocale($locale);
            // Store in session for future requests
            Session::put('locale', $locale);
        }
        
        return $next($request);
    }
}
