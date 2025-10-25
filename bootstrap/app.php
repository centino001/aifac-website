<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
        ]);
        
        // Exclude Flutterwave webhook from CSRF verification
        $middleware->validateCsrfTokens(except: [
            'payment/webhook',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Handle authentication exceptions for admin routes
        $exceptions->render(function (AuthenticationException $e, $request) {
            // Check if the request is for an admin route
            if ($request->is('admin/*')) {
                // If it's an AJAX/Livewire request, return JSON
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
            
            // For non-admin routes, use default behavior
            return redirect()->guest(route('login'));
        });
    })->create();
