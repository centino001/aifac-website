<?php

namespace App\Livewire\Pages\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use App\Livewire\Concerns\AuthorizesAdminAccess;
use App\Models\News;
use App\Helpers\CloudinaryHelper;
use Carbon\Carbon;

class ManageNews extends Component
{
    use AuthorizesAdminAccess;
    use WithFileUploads;

    #[Validate('required|string|max:255')]
    public $title = '';

    #[Validate('required|string|max:255')]
    public $slug = '';

    #[Validate('nullable|string|max:255')]
    public $author = '';

    #[Validate('required|string')]
    public $content = '';

    #[Validate('nullable|string')]
    public $excerpt = '';

    /** Comma-separated categories for form */
    public $categoriesInput = '';

    #[Validate('nullable|image|max:5120')]
    public $thumbnail = null;

    /** Existing thumbnail URL when editing */
    public $thumbnail_url = null;

    #[Validate('nullable|array')]
    public $images = [];

    #[Validate('required|date')]
    public $published_date = '';

    public $showForm = false;
    public $editingId = null;
    public $selectedNews = null;
    public $showModal = false;
    public $showDeleteModal = false;
    public $newsToDelete = null;

    public function mount()
    {
        if ($redirect = $this->authorizeAdmin('news')) {
            return $redirect;
        }
        $this->published_date = Carbon::today()->format('Y-m-d');
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
        $this->editingId = null;
        if (!$this->showForm) {
            $this->resetForm();
        }
    }

    public function editArticle($id)
    {
        $article = News::find($id);
        if (!$article) {
            return;
        }
        $this->editingId = $article->id;
        $this->title = $article->title;
        $this->slug = $article->slug ?? \Str::slug($article->title);
        $this->author = $article->author ?? '';
        $this->content = $article->content ?? '';
        $this->excerpt = $article->getRawOriginal('excerpt') ?? '';
        $this->categoriesInput = is_array($article->categories) ? implode(', ', $article->categories) : '';
        $this->thumbnail_url = $article->thumbnail ?? $article->first_image;
        $this->thumbnail = null;
        $this->images = [];
        $this->published_date = $article->published_date->format('Y-m-d');
        $this->showForm = true;
        $this->resetValidation();
    }

    public function resetForm()
    {
        $this->reset([
            'title', 'slug', 'author', 'content', 'excerpt', 'categoriesInput',
            'thumbnail', 'thumbnail_url', 'images', 'editingId'
        ]);
        $this->published_date = Carbon::today()->format('Y-m-d');
        $this->resetValidation();
    }

    public function updatedTitle($value)
    {
        if ($this->editingId === null && empty($this->slug)) {
            $this->slug = \Str::slug($value);
        }
    }

    public function saveNews($contentFromEditor = null)
    {
        try {
            if ($contentFromEditor !== null) {
                $this->content = $contentFromEditor;
            }

            $this->validate([
                'title' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:news,slug,' . (int) $this->editingId,
                'author' => 'nullable|string|max:255',
                'content' => 'required|string',
                'excerpt' => 'nullable|string',
                'thumbnail' => 'nullable|sometimes|file|image|max:5120',
                'images' => 'nullable|array',
                'published_date' => 'required|date',
            ]);

            $categories = array_filter(array_map('trim', explode(',', $this->categoriesInput ?? '')));

            $thumbnailUrl = $this->thumbnail_url;
            if ($this->thumbnail) {
                $thumbnailUrl = CloudinaryHelper::uploadNewsImage($this->thumbnail);
            }

            $imageUrls = [];
            if ($this->images && is_array($this->images)) {
                foreach ($this->images as $image) {
                    $imageUrls[] = CloudinaryHelper::uploadNewsImage($image);
                }
            }

            if ($this->editingId) {
                $article = News::find($this->editingId);
                if (!$article) {
                    session()->flash('error', 'Article not found.');
                    return;
                }
                $article->update([
                    'title' => $this->title,
                    'slug' => $this->slug,
                    'author' => $this->author ?: null,
                    'content' => $this->content,
                    'excerpt' => $this->excerpt ?: null,
                    'categories' => $categories ?: null,
                    'thumbnail' => $thumbnailUrl,
                    'published_date' => $this->published_date,
                ]);
                if (!empty($imageUrls)) {
                    $existing = $article->images ?? [];
                    $article->update(['images' => array_merge($existing, $imageUrls)]);
                }
                session()->flash('success', 'News article updated successfully!');
            } else {
                News::create([
                    'title' => $this->title,
                    'slug' => $this->slug,
                    'author' => $this->author ?: null,
                    'content' => $this->content,
                    'excerpt' => $this->excerpt ?: null,
                    'categories' => $categories ?: null,
                    'thumbnail' => $thumbnailUrl,
                    'images' => $imageUrls,
                    'published_date' => $this->published_date,
                ]);
                session()->flash('success', 'News article added successfully!');
            }

            $this->resetForm();
            $this->showForm = false;
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to save: ' . $e->getMessage());
            \Log::error('ManageNews saveNews error', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
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
