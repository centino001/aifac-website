<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            // If this is an AJAX/Livewire request, return JSON response
            if ($request->expectsJson() || $request->header('X-Livewire')) {
                return response()->json([
                    'message' => 'Session expired. Please login again.',
                    'redirect' => '/admin/login'
                ], 401);
            }
            
            // For regular requests, redirect to admin login
            return redirect()->route('admin.login')
                ->with('error', 'Your session has expired. Please login again.');
        }

        // Check if user has admin privileges
        if (!Auth::user()->isAdmin()) {
            // If this is an AJAX/Livewire request, return JSON response
            if ($request->expectsJson() || $request->header('X-Livewire')) {
                return response()->json([
                    'message' => 'Access denied. Admin privileges required.',
                    'redirect' => '/'
                ], 403);
            }
            
            // For regular requests, redirect to home page
            return redirect('/')
                ->with('error', 'Access denied. Admin privileges required.');
        }

        return $next($request);
    }
}
