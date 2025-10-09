<div class="min-h-screen bg-black flex" x-data="{ sidebarOpen: false }">
    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0" 
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100" 
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-30 bg-black bg-opacity-50 lg:hidden" 
         @click="sidebarOpen = false"></div>

    <!-- Sidebar -->
    <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
         class="fixed inset-y-0 left-0 z-40 w-64 bg-black border-r border-orange-600 flex flex-col transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0">
        
        <div class="p-4 border-b border-orange-600">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <img src="https://res.cloudinary.com/dgsctl247/image/upload/v1758843246/aifac_logo_wjjkzk.png" 
                         alt="AIFAC Logo" class="h-8 w-8 lg:h-10 lg:w-10 object-contain">
                    <div class="ml-3">
                        <h1 class="text-sm lg:text-lg font-bold text-white">Admin Panel</h1>
                        <p class="text-xs text-gray-400 hidden lg:block">AIFAC Dashboard</p>
                    </div>
                </div>
                <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-white">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <nav class="flex-1 p-2 lg:p-4 space-y-1 lg:space-y-2 overflow-y-auto">
            <a href="/admin/dashboard" @click="sidebarOpen = false" class="flex items-center px-3 lg:px-4 py-2 lg:py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition duration-200">
                <svg class="h-4 w-4 lg:h-5 lg:w-5 mr-2 lg:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2H3z"></path>
                </svg>
                <span class="text-sm lg:text-base">Dashboard</span>
            </a>

            <a href="/admin/projects" @click="sidebarOpen = false" class="flex items-center px-3 lg:px-4 py-2 lg:py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition duration-200">
                <svg class="h-4 w-4 lg:h-5 lg:w-5 mr-2 lg:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3v3m0 0v3m0-3h3m-3 0h-3"></path>
                </svg>
                <span class="text-sm lg:text-base">Manage Projects</span>
            </a>

            <a href="/admin/news" @click="sidebarOpen = false" class="flex items-center px-3 lg:px-4 py-2 lg:py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition duration-200">
                <svg class="h-4 w-4 lg:h-5 lg:w-5 mr-2 lg:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span class="text-sm lg:text-base">Manage News</span>
            </a>

            <a href="/admin/people" @click="sidebarOpen = false" class="flex items-center px-3 lg:px-4 py-2 lg:py-3 text-white bg-orange-600 rounded-lg">
                <svg class="h-4 w-4 lg:h-5 lg:w-5 mr-2 lg:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span class="text-sm lg:text-base">Manage People</span>
            </a>

            <a href="#" @click="sidebarOpen = false" class="flex items-center px-3 lg:px-4 py-2 lg:py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition duration-200">
                <svg class="h-4 w-4 lg:h-5 lg:w-5 mr-2 lg:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span class="text-sm lg:text-base">Manage Staff</span>
            </a>

            <!-- Divider -->
            <div class="border-t border-orange-600 my-2 lg:my-4"></div>

            <!-- Settings -->
            <a href="#" @click="sidebarOpen = false" class="flex items-center px-3 lg:px-4 py-2 lg:py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition duration-200">
                <svg class="h-4 w-4 lg:h-5 lg:w-5 mr-2 lg:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span class="text-sm lg:text-base">Settings</span>
            </a>
        </nav>

        <div class="p-2 lg:p-4 border-t border-orange-600">
            <div class="flex items-center justify-between">
                <div class="flex items-center min-w-0 flex-1">
                    <div class="bg-orange-600 p-2 rounded-full flex-shrink-0">
                        <svg class="h-3 w-3 lg:h-4 lg:w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div class="ml-2 lg:ml-3 min-w-0 flex-1">
                        <p class="text-xs lg:text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400 hidden lg:block">Administrator</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}" class="inline ml-2">
                    @csrf
                    <button type="submit" class="text-gray-400 hover:text-red-400 transition duration-200 p-1" title="Logout">
                        <svg class="h-4 w-4 lg:h-5 lg:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- Header -->
        <header class="bg-black shadow-lg border-b border-orange-600 px-4 lg:px-6 py-3 lg:py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" class="lg:hidden text-gray-400 hover:text-white mr-3">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <div>
                        <h1 class="text-xl lg:text-2xl font-bold text-white">Manage People</h1>
                        <p class="text-gray-400 text-sm lg:text-base hidden sm:block">Manage team members and staff</p>
                    </div>
                </div>
                <button wire:click="toggleForm" 
                        class="bg-orange-600 hover:bg-orange-700 text-white px-3 lg:px-6 py-2 rounded-lg transition duration-200 flex items-center text-sm lg:text-base">
                    <svg class="h-4 w-4 lg:h-5 lg:w-5 mr-1 lg:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span class="hidden sm:inline">{{ $showForm ? 'Cancel' : 'Add Person' }}</span>
                    <span class="sm:hidden">{{ $showForm ? 'Cancel' : 'Add' }}</span>
                </button>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 p-4 lg:p-6 overflow-y-auto">
            <!-- Add Person Form -->
            @if($showForm)
            <div class="bg-black rounded-lg border border-orange-600 p-4 lg:p-6 mb-6 lg:mb-8">
                <h3 class="text-lg font-bold text-white mb-4">Add New Person</h3>
                <form wire:submit="savePerson" class="space-y-4 lg:space-y-6">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Full Name *</label>
                        <input wire:model="name" type="text" 
                               class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm lg:text-base"
                               placeholder="Enter full name">
                        @error('name') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <!-- Position -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Position/Role *</label>
                        <input wire:model="position" type="text" 
                               class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm lg:text-base"
                               placeholder="e.g., Executive Director, Program Manager">
                        @error('position') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Category *</label>
                        <select wire:model="category" 
                                class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm lg:text-base">
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                        </select>
                        @error('category') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <!-- LinkedIn URL -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">LinkedIn Profile (Optional)</label>
                        <input wire:model="linkedin_url" type="url" 
                               class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm lg:text-base"
                               placeholder="https://linkedin.com/in/username">
                        @error('linkedin_url') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <!-- Profile Image -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Profile Image</label>
                        <input wire:model="image" type="file" accept="image/*"
                               class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-orange-600 file:text-white hover:file:bg-orange-700 text-sm lg:text-base">
                        @error('image') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                        
                        @if($image)
                        <div class="mt-4">
                            <p class="text-sm text-gray-400 mb-2">Preview:</p>
                            <img src="{{ $image->temporaryUrl() }}" class="h-24 lg:h-32 w-24 lg:w-32 object-cover rounded-lg border border-gray-600">
                        </div>
                        @endif
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-4">
                        <button type="button" wire:click="toggleForm"
                                class="w-full sm:w-auto px-4 lg:px-6 py-2 border border-gray-600 text-gray-300 rounded-lg hover:bg-gray-800 transition duration-200 text-sm lg:text-base">
                            Cancel
                        </button>
                        <button type="submit" wire:loading.attr="disabled"
                                class="w-full sm:w-auto px-4 lg:px-6 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg transition duration-200 disabled:opacity-50 text-sm lg:text-base">
                            <span wire:loading.remove>Add Person</span>
                            <span wire:loading>Adding...</span>
                        </button>
                    </div>
                </form>
            </div>
            @endif

            <!-- People List -->
            <div class="bg-black rounded-lg border border-orange-600 p-4 lg:p-6">
                <h3 class="text-lg font-bold text-white mb-4">Team Members ({{ $people->count() }})</h3>
                
                @if($people->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 lg:gap-6">
                    @foreach($people as $person)
                    <div class="bg-gray-800 rounded-lg overflow-hidden border border-gray-600 hover:border-orange-500 transition duration-200">
                        
                        @if($person->image_url)
                        <div class="h-48 lg:h-56 bg-cover bg-center" style="background-image: url('{{ $person->image_url }}')"></div>
                        @else
                        <div class="h-48 lg:h-56 bg-gradient-to-br from-purple-500 to-blue-700 flex items-center justify-center">
                            <svg class="h-16 w-16 lg:h-20 lg:w-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        @endif
                        
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="text-white font-semibold text-sm lg:text-base truncate flex-1 mr-2">{{ $person->name }}</h4>
                                
                                <!-- Action Buttons -->
                                <div class="flex items-center space-x-2 flex-shrink-0">
                                    <button wire:click="showPersonDetails({{ $person->id }})" 
                                            class="text-blue-400 hover:text-blue-300 transition duration-200 p-1" 
                                            title="View Details">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                    
                                    <button wire:click="confirmDelete({{ $person->id }})" 
                                            class="text-red-400 hover:text-red-300 transition duration-200 p-1" 
                                            title="Delete Person">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <p class="text-gray-400 text-xs lg:text-sm mb-3">{{ $person->position }}</p>
                            
                            @if($person->linkedin_url)
                            <div class="mt-2">
                                <a href="{{ $person->linkedin_url }}" 
                                   target="_blank" 
                                   class="inline-flex items-center text-xs text-blue-400 hover:text-blue-300 transition duration-200">
                                    <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                    </svg>
                                    LinkedIn
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8 lg:py-12">
                    <svg class="h-12 w-12 lg:h-16 lg:w-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-400 mb-2">No team members yet</h3>
                    <p class="text-gray-500 text-sm lg:text-base">Click "Add Person" to get started.</p>
                </div>
                @endif
            </div>
        </main>
    </div>

    <!-- Person Details Modal (Mobile Optimized) -->
    @if($showModal && $selectedPerson)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-gray-900 rounded-lg border border-orange-600 max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-4 lg:p-6">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex-1 min-w-0 mr-4">
                        <h3 class="text-lg lg:text-xl font-bold text-white mb-1 break-words">{{ $selectedPerson->name }}</h3>
                        <p class="text-orange-400 text-sm lg:text-base">{{ $selectedPerson->position }}</p>
                        @if($selectedPerson->category)
                        <p class="text-gray-400 text-xs lg:text-sm mt-1">{{ $selectedPerson->category }}</p>
                        @endif
                    </div>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-white transition duration-200 flex-shrink-0">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                @if($selectedPerson->image_url)
                <div class="mb-6">
                    <img src="{{ $selectedPerson->image_url }}" 
                         alt="{{ $selectedPerson->name }}" 
                         class="w-full max-w-sm mx-auto h-64 lg:h-80 object-cover rounded-lg shadow-md">
                </div>
                @endif

                @if($selectedPerson->linkedin_url)
                <div class="mb-6 text-center">
                    <a href="{{ $selectedPerson->linkedin_url }}" 
                       target="_blank" 
                       class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200">
                        <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                        View LinkedIn Profile
                    </a>
                </div>
                @endif

                <div class="flex justify-end">
                    <button wire:click="closeModal" 
                            class="w-full sm:w-auto px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition duration-200">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Delete Confirmation Modal (Mobile Optimized) -->
    @if($showDeleteModal && $personToDelete)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-gray-900 rounded-lg border border-red-600 max-w-md w-full">
            <div class="p-4 lg:p-6">
                <div class="flex items-center mb-4">
                    <div class="bg-red-600 p-2 lg:p-3 rounded-full mr-3 lg:mr-4 flex-shrink-0">
                        <svg class="h-5 w-5 lg:h-6 lg:w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-lg font-bold text-white">Delete Person</h3>
                        <p class="text-gray-400 text-sm">This action cannot be undone</p>
                    </div>
                </div>

                <div class="mb-6">
                    <p class="text-gray-300 text-sm lg:text-base">
                        Are you sure you want to delete 
                        <span class="font-semibold text-orange-400 break-words">"{{ $personToDelete->name }}"</span>?
                    </p>
                    <p class="text-gray-400 text-xs lg:text-sm mt-2">
                        This will permanently remove this person from your team directory.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-4">
                    <button wire:click="cancelDelete" 
                            class="w-full sm:w-auto px-4 py-2 border border-gray-600 text-gray-300 rounded-lg hover:bg-gray-800 transition duration-200 text-sm lg:text-base">
                        Cancel
                    </button>
                    <button wire:click="deletePerson" wire:loading.attr="disabled"
                            class="w-full sm:w-auto px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition duration-200 disabled:opacity-50 text-sm lg:text-base">
                        <span wire:loading.remove>Delete Person</span>
                        <span wire:loading>Deleting...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div> 