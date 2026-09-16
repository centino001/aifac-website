<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Pages\Home;
use App\Livewire\Pages\Projects;
use App\Livewire\Pages\News;
use App\Livewire\Pages\About;
use App\Livewire\Pages\PaymentGateway;
use App\Livewire\Pages\PaymentSuccess;
use App\Livewire\Pages\ProjectDetail;
use App\Livewire\Pages\NewsDetail;
use App\Livewire\Pages\Admin\Login as AdminLogin;
use App\Livewire\Pages\Admin\Dashboard as AdminDashboard;
use App\Livewire\Pages\Admin\ManagePeople;
use App\Livewire\Pages\Admin\ManageProjects;
use App\Livewire\Pages\Admin\ManageNews;
use App\Livewire\Pages\Admin\TicketRecords;
use App\Livewire\Pages\Admin\ManageStaff;
use App\Livewire\Pages\Admin\Profile as AdminProfile;
use App\Http\Controllers\NewsletterController;

// Public Routes
Route::get('/', Home::class);
Route::get('/projects', Projects::class);
Route::get('/news', News::class);
Route::get('/news/{slug}', NewsDetail::class);
Route::get('/about', About::class);
Route::get('/payment-gateway', PaymentGateway::class);
Route::get('/payment-success', PaymentSuccess::class)->name('payment.success');
Route::get('/projects/{slug}', ProjectDetail::class);
Route::post('/newsletter/subscribe', [NewsletterController::class, 'store'])->name('newsletter.subscribe');

// Payment routes
Route::post('/payment/initialize', [\App\Http\Controllers\PaymentController::class, 'initialize'])
    ->middleware('gbs.cors')
    ->name('payment.initialize');
Route::options('/payment/initialize', fn () => response('', 204))->middleware('gbs.cors');
Route::get('/payment/callback', [\App\Http\Controllers\PaymentController::class, 'callback'])->name('payment.callback');
Route::post('/payment/webhook', [\App\Http\Controllers\PaymentController::class, 'webhook'])->name('payment.webhook');
Route::get('/payment/verify/{transactionId}', [\App\Http\Controllers\PaymentController::class, 'verify'])->name('payment.verify');
Route::get('/payment/failed', function () {
    return view('livewire.pages.payment-failed');
})->name('payment.failed');

// Ticket catalogue for GBS2026 React microsite (CORS)
Route::middleware('gbs.cors')->group(function () {
    Route::get('/api/tickets/catalogue', [\App\Http\Controllers\PaymentController::class, 'ticketCatalogue'])
        ->name('tickets.catalogue');
    Route::options('/api/tickets/catalogue', fn () => response('', 204));
});

// Fallback login route (redirects to admin login)
Route::get('/login', function () {
    return redirect('/admin/login');
})->name('login');

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', AdminLogin::class)->name('admin.login');
    
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', AdminDashboard::class)
            ->middleware('permission:dashboard')
            ->name('admin.dashboard');
        Route::get('/people', ManagePeople::class)
            ->middleware('permission:people')
            ->name('admin.people');
        Route::get('/projects', ManageProjects::class)
            ->middleware('permission:projects')
            ->name('admin.projects');
        Route::get('/news', ManageNews::class)
            ->middleware('permission:news')
            ->name('admin.news');
        Route::get('/tickets', \App\Livewire\Pages\Admin\TicketCheckIn::class)
            ->middleware('permission:ticket_checkin')
            ->name('admin.tickets');
        Route::get('/ticket-records', TicketRecords::class)
            ->middleware('permission:ticket_records')
            ->name('admin.ticket-records');
        Route::get('/staff', ManageStaff::class)
            ->middleware('permission:manage_staff')
            ->name('admin.staff');
        Route::get('/profile', AdminProfile::class)
            ->middleware('permission:profile')
            ->name('admin.profile');

        Route::post('/logout', function () {
            auth()->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();

            return redirect('/admin/login')->with('success', 'You have been logged out successfully.');
        })->name('admin.logout');
    });
});
