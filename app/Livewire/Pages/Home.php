<?php

namespace App\Livewire\Pages;

use Illuminate\Support\Carbon;
use Livewire\Component;

class Home extends Component
{
    /**
     * GBSAAC 2026 announcement banner. Shown above the hero slider until the
     * cut-off below, after which the home page renders exactly as it did before.
     */
    private const SUMMIT_BANNER_ID = 'Introduction_orblrv.mp4';
    // private const SUMMIT_BANNER_ID = 'GBSAAC_HERO_nj6piu.png';
    private const SUMMIT_BANNER_TIMEZONE = 'Africa/Lagos';
    private const SUMMIT_BANNER_ENDS_AT = '2026-11-02 00:00:00';
    private const SUMMIT_TICKET_URL = '#';
    // Explore Event points at the React microsite (local Vite or production subdomain).
    // Buy Ticket opens an on-page modal — these constants are kept for clarity.

    public $currentSlide = 0;
    public $slides = [];

    public function mount()
    {
        // Define multimedia slides with provided assets
        $this->slides = [
            [
                'type' => 'video',
                'src' => 'https://res.cloudinary.com/dgsctl247/video/upload/v1758814286/ekpo_dance_pjvrtq.mp4',
                'duration' => null, // Video duration auto-detected
                'title' => 'Cultural Heritage Dance',
                'description' => 'Preserving and celebrating traditional Ekpo dance forms'
            ],
            [
                'type' => 'video',
                'src' => 'https://res.cloudinary.com/dgsctl247/video/upload/v1758814279/aifac_logo_hqkjra.mp4',
                'duration' => null, // Video duration auto-detected
                'title' => 'Our Eyes Will Never Be Shut In Life Or Death.',
                'description' => 'Like The Eyes Of A Fish That Never Closes In Life Or Death, We See Our Past As We Bring It To The Present In Order To Carry It Forth To The Future.',
            ],
            [
                'type' => 'image',
                'src' => 'https://res.cloudinary.com/dgsctl247/image/upload/v1754786067/aif_hzhjf7.jpg',
                'duration' => 5000, // 5 seconds
                'title' => 'Our Tradition Is Our Future.',
                'description' => 'We Are The Future Of Our Tradition.'
            ]
        ];
    }

    public function nextSlide()
    {
        $this->currentSlide = ($this->currentSlide + 1) % count($this->slides);
    }

    public function previousSlide()
    {
        $this->currentSlide = $this->currentSlide > 0 ? $this->currentSlide - 1 : count($this->slides) - 1;
    }

    public function goToSlide($index)
    {
        $this->currentSlide = $index;
    }

    public function summitBannerIsVisible(): bool
    {
        return Carbon::now(self::SUMMIT_BANNER_TIMEZONE)
            ->lessThan(Carbon::parse(self::SUMMIT_BANNER_ENDS_AT, self::SUMMIT_BANNER_TIMEZONE));
    }

    public function summitBannerUrl(): string
    {
        // Use the raw mp4 delivery URL — Cloudinary f_auto/q_auto can return an
        // empty response while the transformed asset is still being generated.
        return 'https://res.cloudinary.com/dgsctl247/video/upload/'
            . self::SUMMIT_BANNER_ID;
    }

    public function render()
    {
        return view('livewire.pages.home', [
            'showSummitBanner' => $this->summitBannerIsVisible(),
            'summitBannerUrl' => $this->summitBannerUrl(),
            'summitTicketUrl' => self::SUMMIT_TICKET_URL,
            'summitExploreUrl' => config('services.gbs2026.url', 'http://localhost:5173'),
        ])->layout('layouts.website', ['title' => 'Home']);
    }
}
