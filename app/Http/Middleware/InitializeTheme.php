<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class InitializeTheme
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Initialize theme in session if not already set
        if (!session()->has('theme')) {
            session(['theme' => 'light']);
        }
        
        return $next($request);
    }
}
