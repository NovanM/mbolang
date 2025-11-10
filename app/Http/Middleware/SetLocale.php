<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
        // Check if locale is in session, otherwise use default
        $locale = session('locale', config('app.locale'));
        
        // Validate locale
        if (!in_array($locale, ['en', 'id'])) {
            $locale = config('app.locale');
        }
        
        // Set application locale
        app()->setLocale($locale);
        
        return $next($request);
    }
}
