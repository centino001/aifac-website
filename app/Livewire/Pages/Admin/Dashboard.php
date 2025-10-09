<?php

namespace App\Livewire\Pages\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public function mount()
    {
        // Ensure user is authenticated and is admin
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect('/admin/login');
        }
    }

    public function render()
    {
        return view('livewire.pages.admin.dashboard')
            ->layout('layouts.admin', ['title' => 'Admin Dashboard']);
    }
}
