<div class="min-h-screen bg-black flex" x-data="{ sidebarOpen: false }">
    <x-admin.sidebar active="profile" />

    <div class="flex-1 flex flex-col min-w-0">
        <header class="bg-black shadow-lg border-b border-orange-600 px-4 lg:px-6 py-3 lg:py-4">
            <div class="flex items-center">
                <button @click="sidebarOpen = true" class="lg:hidden text-gray-400 hover:text-white mr-3" type="button">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <div>
                    <h1 class="text-xl lg:text-2xl font-bold text-white">My Profile</h1>
                    <p class="text-gray-400 text-sm lg:text-base hidden sm:block">Update your account details</p>
                </div>
            </div>
        </header>

        <main class="flex-1 p-4 lg:p-6 overflow-y-auto space-y-6">
            <div class="bg-black rounded-lg border border-orange-600 p-4 lg:p-6 max-w-2xl">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-white">Account</h3>
                    <span class="text-xs px-2 py-1 rounded bg-orange-900/40 text-orange-300 border border-orange-700/50">
                        {{ $user->roleLabel() }}
                    </span>
                </div>

                <form wire:submit="updateProfile" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Full Name</label>
                        <input wire:model="name" type="text"
                               class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                        @error('name') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                        <input wire:model="email" type="email"
                               class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                        @error('email') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 rounded-lg bg-orange-600 hover:bg-orange-700 text-white">
                            Save Profile
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-black rounded-lg border border-orange-600 p-4 lg:p-6 max-w-2xl">
                <h3 class="text-lg font-bold text-white mb-4">Change Password</h3>
                <form wire:submit="updatePassword" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Current Password</label>
                        <input wire:model="current_password" type="password"
                               class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                        @error('current_password') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">New Password</label>
                        <input wire:model="password" type="password"
                               class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                        @error('password') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Confirm New Password</label>
                        <input wire:model="password_confirmation" type="password"
                               class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 rounded-lg bg-orange-600 hover:bg-orange-700 text-white">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>

            @unless ($user->isSuperAdmin())
                <div class="bg-black rounded-lg border border-gray-700 p-4 lg:p-6 max-w-2xl">
                    <h3 class="text-lg font-bold text-white mb-3">Your Access</h3>
                    <div class="flex flex-wrap gap-2">
                        @forelse ($user->getPermissionsList() as $perm)
                            <span class="inline-flex px-2 py-1 text-xs rounded bg-gray-800 text-gray-300 border border-gray-600">
                                {{ config("admin_permissions.{$perm}.label", $perm) }}
                            </span>
                        @empty
                            <span class="text-sm text-gray-500">No menu permissions assigned yet.</span>
                        @endforelse
                    </div>
                </div>
            @endunless
        </main>
    </div>
</div>
