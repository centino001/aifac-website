<div class="min-h-screen bg-black flex" x-data="{ sidebarOpen: false }">
    <x-admin.sidebar active="projects" />

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
                        <h1 class="text-xl lg:text-2xl font-bold text-white">Manage Projects</h1>
                        <p class="text-gray-400 text-sm lg:text-base hidden sm:block">Create and manage foundation projects</p>
                    </div>
                </div>
                <button wire:click="toggleForm" 
                        class="bg-orange-600 hover:bg-orange-700 text-white px-3 lg:px-6 py-2 rounded-lg transition duration-200 flex items-center text-sm lg:text-base">
                    <svg class="h-4 w-4 lg:h-5 lg:w-5 mr-1 lg:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span class="hidden sm:inline">{{ $showForm ? 'Cancel' : 'Add Project' }}</span>
                    <span class="sm:hidden">{{ $showForm ? 'Cancel' : 'Add' }}</span>
                </button>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 p-4 lg:p-6 overflow-y-auto">
            <!-- Add Project Form -->
            @if($showForm)
            <div class="bg-black rounded-lg border border-orange-600 p-4 lg:p-6 mb-6 lg:mb-8">
                <h3 class="text-lg font-bold text-white mb-4">Create New Project</h3>
                <form wire:submit="saveProject" class="space-y-4 lg:space-y-6">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Project Name *</label>
                        <input wire:model="name" type="text" 
                               class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm lg:text-base"
                               placeholder="Enter project name">
                        @error('name') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Project Description *</label>
                        <textarea wire:model="description" rows="6"
                                  class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm lg:text-base"
                                  placeholder="Describe the project in detail..."
                                  style="white-space: pre-wrap;"></textarea>
                        @error('description') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                        <p class="mt-1 text-xs text-gray-500">Tip: Press Enter to create new paragraphs</p>
                    </div>

                    <!-- Images Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Project Images</label>
                        <input wire:model="images" type="file" multiple accept="image/*"
                               class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-orange-600 file:text-white hover:file:bg-orange-700 text-sm lg:text-base">
                        @error('images') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                        
                        @if($images)
                        <div class="mt-4 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 lg:gap-4">
                            @foreach($images as $index => $image)
                            <div class="relative">
                                <img src="{{ $image->temporaryUrl() }}" class="h-20 lg:h-24 w-full object-cover rounded-lg border border-gray-600">
                                <div class="absolute top-1 right-1 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded">
                                    {{ $index + 1 }}
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    <!-- Toggles and Goals in Mobile-Friendly Layout -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
                        <!-- Active Toggle -->
                        <div>
                            <label class="flex items-center">
                                <input wire:model="is_active" type="checkbox" 
                                       class="sr-only peer">
                                <div class="relative w-11 h-6 bg-gray-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-orange-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-600"></div>
                                <span class="ml-3 text-sm font-medium text-gray-300">Project Active</span>
                            </label>
                        </div>

                        <!-- Donations Toggle -->
                        <div>
                            <label class="flex items-center">
                                <input wire:model="accepts_donations" type="checkbox" 
                                       class="sr-only peer">
                                <div class="relative w-11 h-6 bg-gray-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-orange-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-600"></div>
                                <span class="ml-3 text-sm font-medium text-gray-300">Accept Donations</span>
                            </label>
                        </div>
                    </div>

                    <!-- Fundraising Goal -->
                    @if($accepts_donations)
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Fundraising Goal (₦)</label>
                        <input wire:model="goals" type="number" step="0.01" min="0"
                               class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm lg:text-base"
                               placeholder="Enter amount in Naira">
                        @error('goals') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>
                    @endif

                    <!-- Submit Buttons -->
                    <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-4">
                        <button type="button" wire:click="toggleForm"
                                class="w-full sm:w-auto px-4 lg:px-6 py-2 border border-gray-600 text-gray-300 rounded-lg hover:bg-gray-800 transition duration-200 text-sm lg:text-base">
                            Cancel
                        </button>
                        <button type="submit" wire:loading.attr="disabled"
                                class="w-full sm:w-auto px-4 lg:px-6 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg transition duration-200 disabled:opacity-50 text-sm lg:text-base">
                            <span wire:loading.remove>Create Project</span>
                            <span wire:loading>Creating...</span>
                        </button>
                    </div>
                </form>
            </div>
            @endif

            <!-- Projects List -->
            <div class="bg-black rounded-lg border border-orange-600 p-4 lg:p-6">
                <h3 class="text-lg font-bold text-white mb-4">Projects ({{ $projects->count() }})</h3>
                
                @if($projects->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 lg:gap-6">
                    @foreach($projects as $project)
                    <div class="bg-gray-800 rounded-lg overflow-hidden border border-gray-600 hover:border-orange-500 transition duration-200">
                        
                        @if($project->first_image)
                        <div class="h-40 lg:h-48 bg-cover bg-center" style="background-image: url('{{ $project->first_image }}')"></div>
                        @else
                        <div class="h-40 lg:h-48 bg-gradient-to-br from-orange-500 to-red-700 flex items-center justify-center">
                            <svg class="h-12 w-12 lg:h-16 lg:w-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3v3m0 0v3m0-3h3m-3 0h-3"></path>
                            </svg>
                        </div>
                        @endif
                        
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center space-x-2">
                                    @if($project->is_active)
                                    <span class="bg-green-600 text-white text-xs px-2 py-1 rounded">Active</span>
                                    @else
                                    <span class="bg-gray-600 text-white text-xs px-2 py-1 rounded">Inactive</span>
                                    @endif
                                    
                                    @if($project->accepts_donations)
                                    <span class="bg-orange-600 text-white text-xs px-2 py-1 rounded">Donations</span>
                                    @endif
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="flex items-center space-x-2">
                                    <button wire:click="showProjectDetails({{ $project->id }})" 
                                            class="text-blue-400 hover:text-blue-300 transition duration-200 p-1" 
                                            title="View Details">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                    
                                    <button wire:click="confirmDelete({{ $project->id }})" 
                                            class="text-red-400 hover:text-red-300 transition duration-200 p-1" 
                                            title="Delete Project">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <h4 class="text-white font-semibold mb-2 text-sm lg:text-base">{{ $project->name }}</h4>
                            <p class="text-gray-400 text-xs lg:text-sm line-clamp-3">{{ $project->description }}</p>
                            
                            @if($project->image_count > 1)
                            <div class="mt-2 flex items-center text-gray-500 text-xs">
                                <svg class="h-3 w-3 lg:h-4 lg:w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $project->image_count }} images
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8 lg:py-12">
                    <svg class="h-12 w-12 lg:h-16 lg:w-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3v3m0 0v3m0-3h3m-3 0h-3"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-400 mb-2">No projects yet</h3>
                    <p class="text-gray-500 text-sm lg:text-base">Click "Add Project" to get started.</p>
                </div>
                @endif
            </div>
        </main>
    </div>

    <!-- Project Details Modal (Mobile Optimized) -->
    @if($showModal && $selectedProject)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-gray-900 rounded-lg border border-orange-600 max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-4 lg:p-6">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex-1 min-w-0 mr-4">
                        <h3 class="text-lg lg:text-xl font-bold text-white mb-2 break-words">{{ $selectedProject->name }}</h3>
                        <div class="flex flex-wrap gap-2">
                            @if($selectedProject->is_active)
                            <span class="bg-green-600 text-white px-3 py-1 rounded-full text-sm">Active</span>
                            @else
                            <span class="bg-gray-600 text-white px-3 py-1 rounded-full text-sm">Inactive</span>
                            @endif
                            
                            @if($selectedProject->accepts_donations)
                            <span class="bg-orange-600 text-white px-3 py-1 rounded-full text-sm">Accepts Donations</span>
                            @endif
                        </div>
                    </div>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-white transition duration-200 flex-shrink-0">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                @if($selectedProject->image_count > 0)
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-white mb-3">Project Images ({{ $selectedProject->image_count }})</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 lg:gap-4">
                        @foreach($selectedProject->images as $image)
                        <img src="{{ $image }}" alt="{{ $selectedProject->name }}" class="w-full h-32 lg:h-40 object-cover rounded-lg shadow-md">
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-white mb-3">Project Description</h4>
                    <div class="bg-gray-800 rounded-lg p-4 border border-gray-600">
                        <div class="text-gray-300 whitespace-pre-wrap leading-relaxed text-sm lg:text-base">{{ $selectedProject->description }}</div>
                    </div>
                </div>

                @if($selectedProject->accepts_donations && $selectedProject->goals)
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-white mb-3">Fundraising Goal</h4>
                    <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <svg class="h-6 w-6 lg:h-8 lg:w-8 text-orange-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                            <div>
                                <p class="text-xl lg:text-2xl font-bold text-orange-900">{{ $selectedProject->formatted_goals }}</p>
                                <p class="text-sm text-orange-700">Target amount to be raised</p>
                            </div>
                        </div>
                    </div>
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
    @if($showDeleteModal && $projectToDelete)
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
                        <h3 class="text-lg font-bold text-white">Delete Project</h3>
                        <p class="text-gray-400 text-sm">This action cannot be undone</p>
                    </div>
                </div>

                <div class="mb-6">
                    <p class="text-gray-300 text-sm lg:text-base">
                        Are you sure you want to delete the project 
                        <span class="font-semibold text-orange-400 break-words">"{{ $projectToDelete->name }}"</span>?
                    </p>
                    <p class="text-gray-400 text-xs lg:text-sm mt-2">
                        This will permanently remove the project and all its associated data.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-4">
                    <button wire:click="cancelDelete" 
                            class="w-full sm:w-auto px-4 py-2 border border-gray-600 text-gray-300 rounded-lg hover:bg-gray-800 transition duration-200 text-sm lg:text-base">
                        Cancel
                    </button>
                    <button wire:click="deleteProject" wire:loading.attr="disabled"
                            class="w-full sm:w-auto px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition duration-200 disabled:opacity-50 text-sm lg:text-base">
                        <span wire:loading.remove>Delete Project</span>
                        <span wire:loading>Deleting...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div> 