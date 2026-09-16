<?php

namespace App\Livewire\Pages\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Login extends Component
{
    #[Validate('required|email')]
    public $email = '';

    #[Validate('required|min:3')]
    public $password = '';

    public $remember = false;

    public function mount()
    {
        // Create admin user if it doesn't exist (for debugging)
        if (! User::where('email', 'admin@anyeniyakfoundation.org')->exists()) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@anyeniyakfoundation.org',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
                'is_super_admin' => true,
                'email_verified_at' => now(),
            ]);
        }

        // Redirect if already logged in as admin
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect(Auth::user()->defaultAdminPath());
        }
    }

    public function login()
    {
        $this->validate();

        $user = User::where('email', $this->email)->first();
        if (! $user) {
            session()->flash('error', 'User not found with email: '.$this->email);

            return;
        }

        if (! Hash::check($this->password, $user->password)) {
            session()->flash('error', 'Password is incorrect for user: '.$user->name);

            return;
        }

        if (! $user->is_admin) {
            session()->flash('error', 'Access denied. Admin privileges required.');

            return;
        }

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $user = Auth::user();

            if ($user->isAdmin()) {
                session()->regenerate();
                session()->flash('success', 'Welcome back, '.$user->name.'!');

                return redirect($user->defaultAdminPath());
            }

            Auth::logout();
            session()->flash('error', 'Access denied. Admin privileges required.');

            return;
        }

        session()->flash('error', 'Authentication failed. Please try again.');
    }

    public function render()
    {
        return view('livewire.pages.admin.login')
            ->layout('layouts.admin', ['title' => 'Admin Login']);
    }
}
