<?php

namespace App\Livewire\Pages\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use App\Models\Project;
use App\Helpers\CloudinaryHelper;
use Illuminate\Support\Facades\Auth;

class ManageProjects extends Component
{
    use WithFileUploads;

    // Form fields
    #[Validate('required|string|max:255')]
    public $name = '';
    
    #[Validate('required|string')]
    public $description = '';
    
    #[Validate('nullable|array')]
    public $images = [];
    
    #[Validate('nullable|numeric|min:0')]
    public $goals = '';
    
    public $is_active = true;
    public $accepts_donations = false;

    // Component state
    public $showForm = false;
    public $selectedProject = null;
    public $showModal = false;
    public $showDeleteModal = false;
    public $projectToDelete = null;

    public function mount()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect('/admin/login');
        }
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
        $this->reset(['name', 'description', 'images', 'goals', 'is_active', 'accepts_donations']);
        $this->resetValidation();
    }

    public function updatedAcceptsDonations()
    {
        if (!$this->accepts_donations) {
            $this->goals = '';
        }
    }

    public function saveProject()
    {
        $this->validate();

        $imageUrls = [];
        if ($this->images && is_array($this->images)) {
            foreach ($this->images as $image) {
                try {
                    $imageUrls[] = CloudinaryHelper::uploadProjectImage($image);
                } catch (\Exception $e) {
                    session()->flash('error', 'Failed to upload image: ' . $e->getMessage());
                    return;
                }
            }
        }

        Project::create([
            'name' => $this->name,
            'description' => $this->description,
            'images' => $imageUrls,
            'is_active' => $this->is_active,
            'accepts_donations' => $this->accepts_donations,
            'goals' => $this->accepts_donations && $this->goals ? (float) $this->goals : null,
        ]);

        session()->flash('success', 'Project added successfully!');
        $this->resetForm();
        $this->showForm = false;
    }

    public function showProjectDetails($projectId)
    {
        $this->selectedProject = Project::find($projectId);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedProject = null;
    }

    public function confirmDelete($projectId)
    {
        $this->projectToDelete = Project::find($projectId);
        $this->showDeleteModal = true;
    }

    public function deleteProject()
    {
        if ($this->projectToDelete) {
            $projectName = $this->projectToDelete->name;
            $this->projectToDelete->delete();
            
            session()->flash('success', "Project '{$projectName}' deleted successfully!");
            
            $this->projectToDelete = null;
            $this->showDeleteModal = false;
        }
    }

    public function cancelDelete()
    {
        $this->projectToDelete = null;
        $this->showDeleteModal = false;
    }

    public function render()
    {
        $projects = Project::latest()->get();
        
        return view('livewire.pages.admin.manage-projects', compact('projects'))
            ->layout('layouts.admin', ['title' => 'Manage Projects']);
    }
} 