<?php

namespace App\Livewire\Pages\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use App\Models\News;
use App\Helpers\CloudinaryHelper;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ManageNews extends Component
{
    use WithFileUploads;

    // Form fields
    #[Validate('required|string|max:255')]
    public $title = '';
    
    #[Validate('required|string')]
    public $content = '';
    
    #[Validate('nullable|array')]
    public $images = [];
    
    #[Validate('required|date')]
    public $published_date = '';

    // Component state
    public $showForm = false;
    public $selectedNews = null;
    public $showModal = false;
    public $showDeleteModal = false;
    public $newsToDelete = null;

    public function mount()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect('/admin/login');
        }
        
        // Set default published date to today
        $this->published_date = Carbon::today()->format('Y-m-d');
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
        if (!$this->showForm) {
            $this->resetForm();
        }
    }

    public function resetForm()
    {
        $this->reset(['title', 'content', 'images']);
        $this->published_date = Carbon::today()->format('Y-m-d');
        $this->resetValidation();
    }

    public function saveNews()
    {
        $this->validate();

        $imageUrls = [];
        if ($this->images && is_array($this->images)) {
            foreach ($this->images as $image) {
                try {
                    $imageUrls[] = CloudinaryHelper::uploadNewsImage($image);
                } catch (\Exception $e) {
                    session()->flash('error', 'Failed to upload image: ' . $e->getMessage());
                    return;
                }
            }
        }

        News::create([
            'title' => $this->title,
            'content' => $this->content,
            'images' => $imageUrls,
            'published_date' => $this->published_date,
        ]);

        session()->flash('success', 'News article added successfully!');
        $this->resetForm();
        $this->showForm = false;
    }

    public function showNewsDetails($newsId)
    {
        $this->selectedNews = News::find($newsId);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedNews = null;
    }

    public function confirmDelete($newsId)
    {
        $this->newsToDelete = News::find($newsId);
        $this->showDeleteModal = true;
    }

    public function deleteNews()
    {
        if ($this->newsToDelete) {
            $newsTitle = $this->newsToDelete->title;
            $this->newsToDelete->delete();
            
            session()->flash('success', "News article '{$newsTitle}' deleted successfully!");
            
            $this->newsToDelete = null;
            $this->showDeleteModal = false;
        }
    }

    public function cancelDelete()
    {
        $this->newsToDelete = null;
        $this->showDeleteModal = false;
    }

    public function render()
    {
        $news = News::latest('published_date')->get();
        
        return view('livewire.pages.admin.manage-news', compact('news'))
            ->layout('layouts.admin', ['title' => 'Manage News']);
    }
} 