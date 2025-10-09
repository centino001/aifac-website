<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\News;

class NewsDetail extends Component
{
    public $news;
    public $slug;

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->news = News::where('slug', $slug)->first();
        
        if (!$this->news) {
            abort(404);
        }
    }

    public function render()
    {
        return view('livewire.pages.news-detail', [
            'news' => $this->news
        ])->layout('layouts.website', [
            'title' => $this->news->title . ' - AIFAC News'
        ]);
    }
}
