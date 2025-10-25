<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Pages\Home;
use App\Livewire\Pages\Projects;
use App\Livewire\Pages\News;
use App\Livewire\Pages\About;
use App\Livewire\Pages\PaymentGateway;
use App\Livewire\Pages\PaymentSuccess;
use App\Livewire\Pages\ProjectDetail;
use App\Livewire\Pages\Admin\Login as AdminLogin;
use App\Livewire\Pages\Admin\Dashboard as AdminDashboard;
use App\Livewire\Pages\Admin\ManagePeople;
use App\Livewire\Pages\Admin\ManageProjects;
use App\Livewire\Pages\Admin\ManageNews;
use App\Http\Controllers\NewsletterController;

// Public Routes
Route::get('/', Home::class);
Route::get('/projects', Projects::class);
Route::get('/news', News::class);
Route::get('/about', About::class);
Route::get('/payment-gateway', PaymentGateway::class);
Route::get('/payment-success', PaymentSuccess::class)->name('payment.success');
Route::get('/projects/{slug}', ProjectDetail::class);
Route::post('/newsletter/subscribe', [NewsletterController::class, 'store'])->name('newsletter.subscribe');

// Payment routes
Route::post('/payment/initialize', [\App\Http\Controllers\PaymentController::class, 'initialize'])->name('payment.initialize');
Route::get('/payment/callback', [\App\Http\Controllers\PaymentController::class, 'callback'])->name('payment.callback');
Route::post('/payment/webhook', [\App\Http\Controllers\PaymentController::class, 'webhook'])->name('payment.webhook');
Route::get('/payment/verify/{transactionId}', [\App\Http\Controllers\PaymentController::class, 'verify'])->name('payment.verify');
Route::get('/payment/failed', function () {
    return view('livewire.pages.payment-failed');
})->name('payment.failed');

// Fallback login route (redirects to admin login)
Route::get('/login', function () {
    return redirect('/admin/login');
})->name('login');

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', AdminLogin::class)->name('admin.login');
    
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', AdminDashboard::class)->name('admin.dashboard');
        Route::get('/people', ManagePeople::class)->name('admin.people');
        Route::get('/projects', ManageProjects::class)->name('admin.projects');
        Route::get('/news', ManageNews::class)->name('admin.news');
        
        // Logout route
        Route::post('/logout', function () {
            auth()->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            
            return redirect('/admin/login')->with('success', 'You have been logged out successfully.');
        })->name('admin.logout');
    });
});
