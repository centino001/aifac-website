<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class PaymentGateway extends Component
{
    public $name;
    public $email;
    public $phone;
    public $amount;
    public $type;
    public $projectId;

    public function mount()
    {
        $this->name = request('name');
        $this->email = request('email');
        $this->phone = request('phone');
        $this->amount = request('amount');
        $this->type = request('type', 'foundation');
        $this->projectId = request('projectId');
    }

    public function render()
    {
        return view('livewire.pages.payment-gateway')
            ->layout('layouts.website', ['title' => 'Payment Gateway - Anyen Iyak Foundation']);
    }
}
