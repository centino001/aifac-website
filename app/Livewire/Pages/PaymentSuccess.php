<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class PaymentSuccess extends Component
{
    public $name;
    public $email;
    public $amount;
    public $type;
    public $paymentMethod;
    public $transactionId;
    public $ticketType;
    public $ticketCode;
    public $passName;

    public function mount()
    {
        $this->name = request('name');
        $this->email = request('email');
        $this->amount = request('amount');
        $this->type = request('type', 'foundation');
        $this->paymentMethod = request('paymentMethod');
        $this->transactionId = request('transactionId', 'TXN' . strtoupper(uniqid()));
        $this->ticketType = request('ticketType');
        $this->ticketCode = request('ticketCode');
        $this->passName = request('passName');
    }

    public function isTicket(): bool
    {
        return $this->type === 'ticket';
    }

    public function render()
    {
        return view('livewire.pages.payment-success')
            ->layout('layouts.website', ['title' => $this->isTicket()
                ? 'Ticket Confirmed - GBSAAC 2026'
                : 'Payment Successful - Anyen Iyak Foundation']);
    }
}
