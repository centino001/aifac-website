<div class="min-h-screen bg-black flex" x-data="{ sidebarOpen: false }">
    <x-admin.sidebar active="manage_staff" />

    <div class="flex-1 flex flex-col min-w-0">
        <header class="bg-black shadow-lg border-b border-orange-600 px-4 lg:px-6 py-3 lg:py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" class="lg:hidden text-gray-400 hover:text-white mr-3" type="button">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <div>
                        <h1 class="text-xl lg:text-2xl font-bold text-white">Manage Staff</h1>
                        <p class="text-gray-400 text-sm lg:text-base hidden sm:block">Create staff accounts and assign menu access</p>
                    </div>
                </div>
                <button wire:click="toggleForm"
                        type="button"
                        class="bg-orange-600 hover:bg-orange-700 text-white px-3 lg:px-6 py-2 rounded-lg transition duration-200 flex items-center text-sm lg:text-base">
                    <svg class="h-4 w-4 lg:h-5 lg:w-5 mr-1 lg:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span class="hidden sm:inline">{{ $showForm ? 'Cancel' : ($editingId ? 'Cancel Edit' : 'Add Staff') }}</span>
                    <span class="sm:hidden">{{ $showForm ? 'Cancel' : 'Add' }}</span>
                </button>
            </div>
        </header>

        <main class="flex-1 p-4 lg:p-6 overflow-y-auto">
            @if ($showForm)
                <div class="bg-black rounded-lg border border-orange-600 p-4 lg:p-6 mb-6 lg:mb-8">
                    <h3 class="text-lg font-bold text-white mb-4">
                        {{ $editingId ? 'Edit Staff Member' : 'Add Staff Member' }}
                    </h3>
                    <form wire:submit="saveStaff" class="space-y-4 lg:space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Full Name *</label>
                                <input wire:model="name" type="text"
                                       class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500"
                                       placeholder="Staff name">
                                @error('name') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Email *</label>
                                <input wire:model="email" type="email"
                                       class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500"
                                       placeholder="staff@example.com">
                                @error('email') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">
                                    Password {{ $editingId ? '(leave blank to keep current)' : '*' }}
                                </label>
                                <input wire:model="password" type="password"
                                       class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500"
                                       placeholder="••••••••">
                                @error('password') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Confirm Password</label>
                                <input wire:model="password_confirmation" type="password"
                                       class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500"
                                       placeholder="••••••••">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-3">Menu Access *</label>
                            <p class="text-xs text-gray-400 mb-3">Only checked items will appear in this staff member’s sidebar.</p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                @foreach ($availablePermissions as $key => $item)
                                    <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-700 bg-gray-900/50 cursor-pointer hover:border-orange-600 transition">
                                        <input type="checkbox"
                                               wire:model="selectedPermissions"
                                               value="{{ $key }}"
                                               class="rounded border-gray-600 bg-gray-800 text-orange-600 focus:ring-orange-500">
                                        <span class="text-sm text-gray-200">{{ $item['label'] }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('selectedPermissions') <p class="mt-2 text-sm text-red-400">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex justify-end gap-3">
                            <button type="button" wire:click="toggleForm"
                                    class="px-4 py-2 rounded-lg border border-gray-600 text-gray-300 hover:bg-gray-800">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 rounded-lg bg-orange-600 hover:bg-orange-700 text-white">
                                {{ $editingId ? 'Update Staff' : 'Create Staff' }}
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            <div class="bg-black rounded-lg border border-orange-600 overflow-hidden">
                <div class="px-4 py-3 border-b border-orange-600">
                    <h3 class="font-semibold text-white">Staff Accounts ({{ $staff->count() }})</h3>
                </div>

                @if ($staff->isEmpty())
                    <div class="p-8 text-center text-gray-400">
                        No staff members yet. Add someone and assign the menu pages they can use.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-800">
                            <thead class="bg-gray-900/60">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase">Name</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase">Email</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase">Access</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-400 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-800">
                                @foreach ($staff as $member)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-white">{{ $member->name }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-300">{{ $member->email }}</td>
                                        <td class="px-4 py-3">
                                            <div class="flex flex-wrap gap-1">
                                                @forelse ($member->getPermissionsList() as $perm)
                                                    <span class="inline-flex px-2 py-0.5 text-xs rounded bg-orange-900/50 text-orange-300 border border-orange-700/50">
                                                        {{ $availablePermissions[$perm]['label'] ?? $perm }}
                                                    </span>
                                                @empty
                                                    <span class="text-xs text-gray-500">None</span>
                                                @endforelse
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-right whitespace-nowrap">
                                            <button wire:click="editStaff({{ $member->id }})" type="button"
                                                    class="text-orange-400 hover:text-orange-300 text-sm mr-3">Edit</button>
                                            <button wire:click="confirmDelete({{ $member->id }})" type="button"
                                                    class="text-red-400 hover:text-red-300 text-sm">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <p class="mt-4 text-xs text-gray-500">
                Super admins always have full access and are not listed here. My Profile is available to every staff member automatically.
            </p>
        </main>
    </div>

    @if ($showDeleteModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 p-4">
            <div class="w-full max-w-md rounded-lg border border-orange-600 bg-black p-6">
                <h3 class="text-lg font-bold text-white mb-2">Remove staff?</h3>
                <p class="text-gray-400 text-sm mb-6">This account will no longer be able to log into the admin panel.</p>
                <div class="flex justify-end gap-3">
                    <button wire:click="cancelDelete" type="button"
                            class="px-4 py-2 rounded-lg border border-gray-600 text-gray-300">Cancel</button>
                    <button wire:click="deleteStaff" type="button"
                            class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white">Delete</button>
                </div>
            </div>
        </div>
    @endif
</div>
