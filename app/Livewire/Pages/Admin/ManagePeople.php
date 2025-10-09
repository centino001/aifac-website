<?php

namespace App\Livewire\Pages\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use App\Models\Person;
use App\Helpers\CloudinaryHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ManagePeople extends Component
{
    use WithFileUploads;

    // Form fields
    #[Validate('required|string|max:255')]
    public $name = '';
    
    #[Validate('required|string|max:255')]
    public $position = '';
    
    #[Validate('required|string')]
    public $category = '';
    
    #[Validate('nullable|url')]
    public $linkedin_url = '';
    
    #[Validate('nullable|image|max:2048')]
    public $image;

    // Component state
    public $showForm = false;
    public $selectedPerson = null;
    public $showModal = false;
    public $showDeleteModal = false;
    public $personToDelete = null;

    public $categories = [
        'Board of Directors',
        'Executive Leadership', 
        'Expert Advisors',
        'Core Team'
    ];

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
        $this->reset(['name', 'position', 'category', 'linkedin_url', 'image']);
        $this->resetValidation();
    }

    public function savePerson()
    {
        try {
            // Validate all fields
            $this->validate([
                'name' => 'required|string|max:255',
                'position' => 'required|string|max:255',
                'category' => 'required|string',
                'linkedin_url' => 'nullable|url',
                'image' => 'nullable|image|max:2048'
            ]);

            $imageUrl = null;
            if ($this->image) {
                try {
                    $imageUrl = CloudinaryHelper::uploadPersonImage($this->image);
                } catch (\Exception $e) {
                    session()->flash('error', 'Failed to upload image to Cloudinary. Please try again.');
                    return;
                }
            }

            // Create person record
            $person = Person::create([
                'name' => $this->name,
                'position' => $this->position,
                'category' => $this->category,
                'linkedin_url' => $this->linkedin_url,
                'image_url' => $imageUrl,
            ]);

            session()->flash('success', 'Person added successfully!');
            $this->resetForm();
            $this->showForm = false;

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Re-throw validation exceptions to show field errors
            throw $e;
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to save person: ' . $e->getMessage());
        }
    }

    public function showPersonDetails($personId)
    {
        $this->selectedPerson = Person::find($personId);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedPerson = null;
    }

    public function confirmDelete($personId)
    {
        $this->personToDelete = Person::find($personId);
        $this->showDeleteModal = true;
    }

    public function deletePerson()
    {
        if ($this->personToDelete) {
            $personName = $this->personToDelete->name;
            $this->personToDelete->delete();
            
            session()->flash('success', "Person '{$personName}' deleted successfully!");
            
            $this->personToDelete = null;
            $this->showDeleteModal = false;
        }
    }

    public function cancelDelete()
    {
        $this->personToDelete = null;
        $this->showDeleteModal = false;
    }

    public function render()
    {
        $people = Person::latest()->get();
        
        return view('livewire.pages.admin.manage-people', compact('people'))
            ->layout('layouts.admin', ['title' => 'Manage People']);
    }
}
