<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class News extends Component
{
    public function render()
    {
        return view('livewire.pages.news')
            ->layout('layouts.website', ['title' => 'Latest News - Anyen Iyak Foundation']);
    }
}
