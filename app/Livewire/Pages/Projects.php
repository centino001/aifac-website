<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class Projects extends Component
{
    public function render()
    {
        return view('livewire.pages.projects')
            ->layout('layouts.website', ['title' => 'Our Projects - Anyen Iyak Foundation']);
    }
}
