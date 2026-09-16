<?php

namespace App\Livewire\Concerns;

use Illuminate\Support\Facades\Auth;

trait AuthorizesAdminAccess
{
    protected function authorizeAdmin(?string $permission = null): mixed
    {
        if (! Auth::check() || ! Auth::user()->isAdmin()) {
            return redirect('/admin/login');
        }

        if ($permission && ! Auth::user()->hasPermission($permission)) {
            return redirect(Auth::user()->defaultAdminPath())
                ->with('error', 'You do not have permission to access that page.');
        }

        return null;
    }
}
