<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\News as NewsModel;

class News extends Component
{
    public function render()
    {
        $news = NewsModel::latest('published_date')->paginate(12);
        return view('livewire.pages.news', compact('news'))
            ->layout('layouts.website', ['title' => 'Latest News - Anyen Iyak Foundation']);
    }
}
