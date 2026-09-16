<?php

namespace App\Livewire\Pages\Admin;

use App\Livewire\Concerns\AuthorizesAdminAccess;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ManageStaff extends Component
{
    use AuthorizesAdminAccess;

    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    /** @var list<string> */
    public array $selectedPermissions = [];

    public bool $showForm = false;

    public ?int $editingId = null;

    public bool $showDeleteModal = false;

    public ?int $staffToDelete = null;

    public function mount()
    {
        if ($redirect = $this->authorizeAdmin('manage_staff')) {
            return $redirect;
        }
    }

    public function toggleForm(): void
    {
        $this->showForm = ! $this->showForm;
        if (! $this->showForm) {
            $this->resetForm();
        }
    }

    public function resetForm(): void
    {
        $this->reset([
            'name',
            'email',
            'password',
            'password_confirmation',
            'selectedPermissions',
            'editingId',
        ]);
        $this->resetValidation();
    }

    public function editStaff(int $staffId): void
    {
        $staff = User::query()
            ->where('is_admin', true)
            ->where('is_super_admin', false)
            ->findOrFail($staffId);

        $this->editingId = $staff->id;
        $this->name = $staff->name;
        $this->email = $staff->email;
        $this->password = '';
        $this->password_confirmation = '';
        $this->selectedPermissions = $staff->permissions ?? [];
        $this->showForm = true;
        $this->resetValidation();
    }

    public function saveStaff(): void
    {
        $permissionKeys = array_keys(config('admin_permissions', []));

        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->editingId),
            ],
            'selectedPermissions' => 'required|array|min:1',
            'selectedPermissions.*' => Rule::in($permissionKeys),
        ];

        if ($this->editingId) {
            $rules['password'] = 'nullable|string|min:6|confirmed';
        } else {
            $rules['password'] = 'required|string|min:6|confirmed';
        }

        $this->validate($rules);

        $payload = [
            'name' => $this->name,
            'email' => $this->email,
            'is_admin' => true,
            'is_super_admin' => false,
            'permissions' => array_values(array_unique($this->selectedPermissions)),
        ];

        if ($this->password !== '') {
            $payload['password'] = Hash::make($this->password);
        }

        if ($this->editingId) {
            $staff = User::query()
                ->where('is_admin', true)
                ->where('is_super_admin', false)
                ->findOrFail($this->editingId);

            // Prevent editing yourself into a lockout of manage_staff accidentally is ok;
            // only staff accounts are editable here.
            $staff->update($payload);
            session()->flash('success', 'Staff member updated successfully.');
        } else {
            $payload['email_verified_at'] = now();
            User::create($payload);
            session()->flash('success', 'Staff member created successfully.');
        }

        $this->resetForm();
        $this->showForm = false;
    }

    public function confirmDelete(int $staffId): void
    {
        $this->staffToDelete = $staffId;
        $this->showDeleteModal = true;
    }

    public function cancelDelete(): void
    {
        $this->staffToDelete = null;
        $this->showDeleteModal = false;
    }

    public function deleteStaff(): void
    {
        if (! $this->staffToDelete) {
            return;
        }

        if ($this->staffToDelete === Auth::id()) {
            session()->flash('error', 'You cannot delete your own account.');
            $this->cancelDelete();

            return;
        }

        $staff = User::query()
            ->where('is_admin', true)
            ->where('is_super_admin', false)
            ->find($this->staffToDelete);

        if ($staff) {
            $name = $staff->name;
            $staff->delete();
            session()->flash('success', "Staff member '{$name}' removed.");
        }

        $this->cancelDelete();
    }

    public function render()
    {
        $staff = User::query()
            ->where('is_admin', true)
            ->where('is_super_admin', false)
            ->orderBy('name')
            ->get();

        $availablePermissions = config('admin_permissions', []);

        return view('livewire.pages.admin.manage-staff', [
            'staff' => $staff,
            'availablePermissions' => $availablePermissions,
        ])->layout('layouts.admin', ['title' => 'Manage Staff']);
    }
}
