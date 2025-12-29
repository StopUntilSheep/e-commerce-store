<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Check if user has admin role
        if (Auth::user()->role !== 'admin') {
            // Redirect non-admins with error message
            return redirect()->route('home')
                ->with('error', 'You do not have permission to access this page.');
            
            // OR return 403 Forbidden
            // abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}