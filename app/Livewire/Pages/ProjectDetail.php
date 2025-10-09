<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class ProjectDetail extends Component
{
    public $project;
    public $slug;

    public function mount($slug)
    {
        $this->slug = $slug;
        
        // Handle Ekonke project specifically
        if ($slug === 'ekonke') {
            $this->project = (object) [
                'name' => 'Ekonke',
                'slug' => 'ekonke',
                'description' => 'Ekonke is designed to sustain the tradition of storytelling, a core aspect of Akwa Ibom\'s cultural heritage. By transforming Ibibio folktales into comic books, illustrated storybooks, podcasts, and interactive learning tools, this initiative: Strengthens the use of the Ibibio language, supporting the Ministry\'s goal of promoting indigenous languages. Preserves traditional values by teaching morality, history, and communal living in a relatable way. Enhances indigenous language education in schools, improving retention and fluency among children. Showcases Akwa Ibom\'s cultural richness on global platforms, creating opportunities for cultural tourism and academic research',
                'image' => 'https://res.cloudinary.com/dgsctl247/image/upload/v1759218155/ekonke_b8v34s.jpg',
                'status' => 'Active',
                'category' => 'Cultural Preservation'
            ];
        } else {
            // For other projects, you can add more cases or use database lookup
            abort(404);
        }
    }

    public function render()
    {
        return view('livewire.pages.project-detail', [
            'project' => $this->project
        ])->layout('layouts.website', [
            'title' => $this->project->name . ' - AIFAC Project'
        ]);
    }
}
