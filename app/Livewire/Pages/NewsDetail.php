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
            $this->news = News::where('title', 'like', '%' . str_replace('-', ' ', $slug) . '%')->first();
        }

        if (!$this->news) {
            abort(404);
        }
    }

    public function render()
    {
        $news = $this->news;
        $prev = News::where('published_date', '<', $news->published_date)
            ->orderBy('published_date', 'desc')
            ->first();
        $next = News::where('published_date', '>', $news->published_date)
            ->orderBy('published_date', 'asc')
            ->first();
        $related = News::where('id', '!=', $news->id)
            ->latest('published_date')
            ->take(3)
            ->get();

        return view('livewire.pages.news-detail', [
            'news' => $news,
            'prev' => $prev,
            'next' => $next,
            'related' => $related,
        ])->layout('layouts.website', [
            'title' => $news->title . ' - AIFAC News',
        ]);
    }
}
