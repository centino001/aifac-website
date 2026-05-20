<div>
    <!-- Hero -->
    <section class="relative text-white py-16 md:py-24 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat opacity-30"
             style="background-image: url('{{ \App\Helpers\CloudinaryHelper::heroImage('news-hero') }}');"></div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-4 drop-shadow-lg">
                Latest News & Insights
            </h1>
            <p class="text-lg sm:text-xl text-gray-200 mb-8 max-w-2xl mx-auto drop-shadow-md">
                Stories and updates from the Anyen Iyak Foundation and the African art and culture community.
            </p>
            <a href="#posts" class="inline-block bg-orange-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-orange-700 transition duration-300">
                Explore stories
            </a>
        </div>
    </section>

    <!-- Posts grid -->
    <section id="posts" class="py-12 sm:py-16 bg-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-white mb-8">See what we've written lately</h2>

            @if($news->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($news as $article)
                <article class="group bg-gray-900 rounded-xl overflow-hidden border border-gray-800 hover:border-orange-500/50 transition duration-300">
                    <a href="{{ url('/news/' . ($article->slug ?? \Str::slug($article->title))) }}" class="block">
                        @if($article->featured_image)
                        <div class="aspect-[16/10] bg-gray-800 overflow-hidden">
                            <img src="{{ $article->featured_image }}" alt="{{ $article->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                        @else
                        <div class="aspect-[16/10] bg-gradient-to-br from-orange-900/40 to-gray-800 flex items-center justify-center">
                            <svg class="w-14 h-14 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        @endif
                        <div class="p-5 sm:p-6">
                            @if($article->categories && count($article->categories) > 0)
                            <div class="flex flex-wrap gap-2 mb-3">
                                @foreach(array_slice($article->categories, 0, 3) as $cat)
                                <span class="text-xs font-medium text-orange-400">{{ $cat }}</span>
                                @endforeach
                            </div>
                            @endif
                            <h3 class="text-lg sm:text-xl font-bold text-white mb-2 group-hover:text-orange-400 transition duration-200 line-clamp-2">
                                {{ $article->title }}
                            </h3>
                            <p class="text-gray-400 text-sm line-clamp-3 mb-4">
                                {{ $article->excerpt }}
                            </p>
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                @if($article->author)
                                <span>{{ $article->author }}</span>
                                @else
                                <span>AIFAC</span>
                                @endif
                                <span>{{ $article->formatted_date }}</span>
                            </div>
                        </div>
                    </a>
                </article>
                @endforeach
            </div>

            <div class="mt-12 flex justify-center">
                {{ $news->links() }}
            </div>
            @else
            <div class="text-center py-16">
                <p class="text-gray-400 text-lg">No articles yet. Check back soon.</p>
            </div>
            @endif
        </div>
    </section>

    <!-- Newsletter -->
    <section class="py-12 sm:py-16 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl font-bold text-white mb-2">Stay updated</h2>
            <p class="text-gray-400 mb-6 max-w-xl mx-auto">
                Subscribe to our newsletter for the latest news, events, and updates from the Anyen Iyak Foundation.
            </p>
            <form method="POST" action="{{ route('newsletter.subscribe') }}" class="max-w-md mx-auto flex flex-col sm:flex-row gap-3" id="newsletter-form">
                @csrf
                <input type="email" name="email" placeholder="Enter your email" required
                       class="flex-1 px-4 py-3 rounded-lg border border-gray-600 bg-gray-800 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500">
                <button type="submit" class="bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-orange-700 transition duration-300">
                    Subscribe
                </button>
            </form>
        </div>
    </section>
</div>
