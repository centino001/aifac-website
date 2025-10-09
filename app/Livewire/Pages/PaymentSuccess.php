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

    public function mount()
    {
        $this->name = request('name');
        $this->email = request('email');
        $this->amount = request('amount');
        $this->type = request('type', 'foundation');
        $this->paymentMethod = request('paymentMethod');
        
        // Generate a mock transaction ID
        $this->transactionId = 'TXN' . strtoupper(uniqid());
    }

    public function render()
    {
        return view('livewire.pages.payment-success')
            ->layout('layouts.website', ['title' => 'Payment Successful - Anyen Iyak Foundation']);
    }
}
