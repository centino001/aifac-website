<?php

namespace App\Livewire\Pages\Admin;

use App\Livewire\Concerns\AuthorizesAdminAccess;
use App\Models\Payment;
use App\Models\Ticket;
use Livewire\Component;

class Dashboard extends Component
{
    use AuthorizesAdminAccess;

    public function mount()
    {
        if ($redirect = $this->authorizeAdmin('dashboard')) {
            return $redirect;
        }
    }

    public function render()
    {
        $ticketsSold = Ticket::whereIn('status', [Ticket::STATUS_PAID, Ticket::STATUS_CHECKED_IN])->count();
        $ticketsCheckedIn = Ticket::where('status', Ticket::STATUS_CHECKED_IN)->count();
        $ticketRevenue = (float) Payment::query()
            ->where('donation_type', 'ticket')
            ->where('status', 'successful')
            ->sum('amount');

        return view('livewire.pages.admin.dashboard', [
            'ticketsSold' => $ticketsSold,
            'ticketsCheckedIn' => $ticketsCheckedIn,
            'ticketRevenue' => $ticketRevenue,
        ])->layout('layouts.admin', ['title' => 'Admin Dashboard']);
    }
}
