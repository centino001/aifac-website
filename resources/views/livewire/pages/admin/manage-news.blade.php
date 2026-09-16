<div class="min-h-screen bg-black flex" x-data="{ sidebarOpen: false }">
    <x-admin.sidebar active="news" />

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
                        <h1 class="text-xl lg:text-2xl font-bold text-white">Manage News</h1>
                        <p class="text-gray-400 text-sm lg:text-base hidden sm:block">Create and manage news articles and blog posts</p>
                    </div>
                </div>
                <button wire:click="toggleForm" 
                        class="bg-orange-600 hover:bg-orange-700 text-white px-3 lg:px-6 py-2 rounded-lg transition duration-200 flex items-center text-sm lg:text-base">
                    <svg class="h-4 w-4 lg:h-5 lg:w-5 mr-1 lg:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span class="hidden sm:inline">{{ $showForm ? 'Cancel' : 'Add News Article' }}</span>
                    <span class="sm:hidden">{{ $showForm ? 'Cancel' : 'Add' }}</span>
                </button>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 p-4 lg:p-6 overflow-y-auto">
            <!-- Add/Edit News Form -->
            @if($showForm)
            <div class="bg-black rounded-lg border border-orange-600 p-4 lg:p-6 mb-6 lg:mb-8" wire:key="news-form-{{ $editingId ?? 'new' }}" x-data="newsForm()" x-init="init()">
                <h3 class="text-lg font-bold text-white mb-4">{{ $editingId ? 'Edit News Article' : 'Create New News Article' }}</h3>
                <form @submit.prevent="submitForm" class="space-y-4 lg:space-y-6" id="news-form">
                    <input type="hidden" id="news-content-input" wire:model="content">

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Article Title *</label>
                        <input wire:model="title" type="text"
                               class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm lg:text-base"
                               placeholder="Enter article title">
                        @error('title') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">URL Slug *</label>
                        <input wire:model="slug" type="text"
                               class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm lg:text-base"
                               placeholder="article-url-slug">
                        @error('slug') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                        <p class="mt-1 text-xs text-gray-500">Used in URL: /news/<span class="text-orange-400">{{ $slug ?: 'your-slug' }}</span></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Author</label>
                        <input wire:model="author" type="text"
                               class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm lg:text-base"
                               placeholder="e.g. AIFAC Team">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Article Content *</label>
                        <div id="quill-editor-{{ $editingId ?? 'new' }}" class="min-h-[240px] bg-gray-800 border border-gray-600 rounded-lg text-gray-200 quill-editor-wrap"></div>
                        @error('content') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Excerpt (optional)</label>
                        <textarea wire:model="excerpt" rows="3"
                                  class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm lg:text-base"
                                  placeholder="Short summary for listing cards. Leave blank to auto-generate from content."></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Categories (comma-separated)</label>
                        <input wire:model="categoriesInput" type="text"
                               class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm lg:text-base"
                               placeholder="e.g. News, Technology, Events">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Featured image (thumbnail)</label>
                        <input wire:model="thumbnail" type="file" accept="image/*"
                               class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-orange-600 file:text-white hover:file:bg-orange-700 text-sm lg:text-base">
                        @error('thumbnail') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                        {{-- Preview when user just selected a file --}}
                        @if($thumbnail && is_object($thumbnail) && method_exists($thumbnail, 'temporaryUrl'))
                        <p class="mt-2 text-xs text-gray-400">New image selected:</p>
                        <img src="{{ $thumbnail->temporaryUrl() }}" alt="" class="mt-1 h-32 w-auto max-w-full object-cover rounded border border-gray-600">
                        @elseif($thumbnail_url)
                        <p class="mt-2 text-xs text-gray-400">Current:</p>
                        <img src="{{ $thumbnail_url }}" alt="" class="mt-1 h-32 w-auto max-w-full object-cover rounded border border-gray-600">
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Additional article images</label>
                        <input wire:model="images" type="file" multiple accept="image/*"
                               class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-orange-600 file:text-white hover:file:bg-orange-700 text-sm lg:text-base">
                        @if($images)
                        <div class="mt-4 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 lg:gap-4">
                            @foreach($images as $index => $image)
                            <div class="relative">
                                <img src="{{ $image->temporaryUrl() }}" class="h-20 lg:h-24 w-full object-cover rounded-lg border border-gray-600">
                                <div class="absolute top-1 right-1 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded">{{ $index + 1 }}</div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Publication Date *</label>
                        <input wire:model="published_date" type="date"
                               class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm lg:text-base">
                        @error('published_date') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-4">
                        <button type="button" wire:click="toggleForm"
                                class="w-full sm:w-auto px-4 lg:px-6 py-2 border border-gray-600 text-gray-300 rounded-lg hover:bg-gray-800 transition duration-200 text-sm lg:text-base">
                            Cancel
                        </button>
                        <button type="submit" wire:loading.attr="disabled" wire:target="saveNews"
                                class="w-full sm:w-auto px-4 lg:px-6 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg transition duration-200 disabled:opacity-50 text-sm lg:text-base">
                            <span wire:loading.remove wire:target="saveNews">{{ $editingId ? 'Update Article' : 'Publish Article' }}</span>
                            <span wire:loading wire:target="saveNews">Uploading...</span>
                        </button>
                    </div>
                </form>
            </div>
            @endif

            <!-- News List -->
            <div class="bg-black rounded-lg border border-orange-600 p-4 lg:p-6">
                <h3 class="text-lg font-bold text-white mb-4">News Articles ({{ $news->count() }})</h3>
                
                @if($news->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 lg:gap-6">
                    @foreach($news as $article)
                    <div class="bg-gray-800 rounded-lg overflow-hidden border border-gray-600 hover:border-orange-500 transition duration-200">
                        
                        @if($article->featured_image)
                        <div class="h-40 lg:h-48 bg-cover bg-center" style="background-image: url('{{ $article->featured_image }}')"></div>
                        @else
                        <div class="h-40 lg:h-48 bg-gradient-to-br from-blue-500 to-purple-700 flex items-center justify-center">
                            <svg class="h-12 w-12 lg:h-16 lg:w-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        @endif
                        
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded">{{ $article->formatted_date }}</span>
                                
                                <!-- Action Buttons -->
                                <div class="flex items-center space-x-2">
                                    <a href="/news/{{ $article->slug }}" target="_blank" rel="noopener"
                                       class="text-gray-400 hover:text-white transition duration-200 p-1" title="View on site">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                    </a>
                                    <button wire:click="editArticle({{ $article->id }})"
                                            class="text-amber-400 hover:text-amber-300 transition duration-200 p-1" title="Edit">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <button wire:click="showNewsDetails({{ $article->id }})"
                                            class="text-blue-400 hover:text-blue-300 transition duration-200 p-1" title="Preview">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                    <button wire:click="confirmDelete({{ $article->id }})"
                                            class="text-red-400 hover:text-red-300 transition duration-200 p-1" title="Delete">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <h4 class="text-white font-semibold mb-2 text-sm lg:text-base">{{ $article->title }}</h4>
                            <p class="text-gray-400 text-xs lg:text-sm line-clamp-3">{{ $article->excerpt }}</p>
                            
                            @if($article->images && count($article->images) > 1)
                            <div class="mt-2 flex items-center text-gray-500 text-xs">
                                <svg class="h-3 w-3 lg:h-4 lg:w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ count($article->images) }} images
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8 lg:py-12">
                    <svg class="h-12 w-12 lg:h-16 lg:w-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-400 mb-2">No news articles yet</h3>
                    <p class="text-gray-500 text-sm lg:text-base">Click "Add News Article" to get started.</p>
                </div>
                @endif
            </div>
        </main>
    </div>

    <!-- News Details Modal (Mobile Optimized) -->
    @if($showModal && $selectedNews)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-gray-900 rounded-lg border border-orange-600 max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-4 lg:p-6">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex-1 min-w-0 mr-4">
                        <h3 class="text-lg lg:text-xl font-bold text-white mb-2 break-words">{{ $selectedNews->title }}</h3>
                        <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-sm">{{ $selectedNews->formatted_date }}</span>
                    </div>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-white transition duration-200 flex-shrink-0">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Images Gallery -->
                @if($selectedNews->images && count($selectedNews->images) > 0)
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-white mb-3">Article Images ({{ count($selectedNews->images) }})</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 lg:gap-4">
                        @foreach($selectedNews->images as $image)
                        <img src="{{ $image }}" alt="Article Image" class="w-full h-32 lg:h-48 object-cover rounded-lg border border-gray-600">
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Content -->
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-white mb-3">Article Content</h4>
                    <div class="bg-gray-800 rounded-lg p-4 border border-gray-600 prose prose-invert prose-sm max-w-none">
                        {!! $selectedNews->content !!}
                    </div>
                </div>

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
    @if($showDeleteModal && $newsToDelete)
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
                        <h3 class="text-lg font-bold text-white">Delete News Article</h3>
                        <p class="text-gray-400 text-sm">This action cannot be undone</p>
                    </div>
                </div>

                <div class="mb-6">
                    <p class="text-gray-300 text-sm lg:text-base">
                        Are you sure you want to delete the article 
                        <span class="font-semibold text-orange-400 break-words">"{{ $newsToDelete->title }}"</span>?
                    </p>
                    <p class="text-gray-400 text-xs lg:text-sm mt-2">
                        This will permanently remove the article and all its associated content.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-4">
                    <button wire:click="cancelDelete" 
                            class="w-full sm:w-auto px-4 py-2 border border-gray-600 text-gray-300 rounded-lg hover:bg-gray-800 transition duration-200 text-sm lg:text-base">
                        Cancel
                    </button>
                    <button wire:click="deleteNews" wire:loading.attr="disabled"
                            class="w-full sm:w-auto px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition duration-200 disabled:opacity-50 text-sm lg:text-base">
                        <span wire:loading.remove>Delete Article</span>
                        <span wire:loading>Deleting...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@push('styles')
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<style>
    .quill-editor-wrap .ql-editor { min-height: 200px; }
    .quill-editor-wrap .ql-container, .quill-editor-wrap .ql-editor { font-size: 1rem; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
document.addEventListener('alpine:init', function() {
    Alpine.data('newsForm', function() {
        return {
            quillInited: false,
            init() {
                var self = this;
                this.$nextTick(function() { self.initQuill(); });
            },
            initQuill() {
                var editorId = 'quill-editor-new';
                var formEl = document.getElementById('news-form');
                if (formEl) {
                    var wrap = formEl.querySelector('[id^="quill-editor-"]');
                    if (wrap) editorId = wrap.id;
                }
                var el = document.getElementById(editorId);
                if (!el) return;
                // If this container already has a Quill toolbar, reuse it (don't create a second one)
                if (el.querySelector('.ql-toolbar')) {
                    window.quillEditor = Quill.find(el);
                    var input = document.getElementById('news-content-input');
                    if (window.quillEditor && input && input.value) {
                        window.quillEditor.root.innerHTML = input.value;
                    }
                    return;
                }
                el.innerHTML = '';
                window.quillEditor = new Quill('#' + editorId, {
                    theme: 'snow',
                    placeholder: 'Write your article content...',
                    modules: {
                        toolbar: [
                            [{ header: [1, 2, 3, false] }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{ list: 'ordered'}, { list: 'bullet' }],
                            ['blockquote', 'link', 'image'],
                            ['clean']
                        ]
                    }
                });
                var input = document.getElementById('news-content-input');
                if (input && input.value) {
                    window.quillEditor.root.innerHTML = input.value;
                }
            },
            submitForm() {
                var html = window.quillEditor && window.quillEditor.root ? window.quillEditor.root.innerHTML : '';
                @this.call('saveNews', html);
            }
        };
    });
});
</script>
@endpush 