<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class Home extends Component
{
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

    public function render()
    {
        return view('livewire.pages.home')
            ->layout('layouts.website', ['title' => 'Home']);
    }
}
