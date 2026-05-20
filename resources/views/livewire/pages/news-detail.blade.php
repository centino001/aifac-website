<div>
    <article class="bg-black">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
            <!-- Breadcrumb -->
            <nav class="text-sm text-gray-400 mb-6">
                <a href="{{ url('/') }}" class="hover:text-orange-400 transition">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ url('/news') }}" class="hover:text-orange-400 transition">News</a>
                <span class="mx-2">/</span>
                <span class="text-gray-300 truncate max-w-[200px] sm:max-w-md inline-block align-bottom">{{ $news->title }}</span>
            </nav>

            <!-- Categories -->
            @if($news->categories && count($news->categories) > 0)
            <div class="flex flex-wrap gap-2 mb-4">
                @foreach($news->categories as $cat)
                <span class="text-sm font-medium text-orange-400">{{ $cat }}</span>
                @endforeach
            </div>
            @endif

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-6 leading-tight">
                {{ $news->title }}
            </h1>

            <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-gray-400 text-sm mb-8">
                @if($news->author)
                <span>{{ $news->author }}</span>
                @endif
                <span>{{ $news->long_date }}</span>
                <span>— {{ $news->read_time }} min read</span>
            </div>

            <!-- Featured image -->
            @if($news->featured_image)
            <div class="rounded-xl overflow-hidden mb-8 border border-gray-800">
                <img src="{{ $news->featured_image }}" alt="{{ $news->title }}" class="w-full h-auto object-cover">
            </div>
            @endif

            <!-- Body -->
            <div class="prose prose-invert prose-lg max-w-none prose-headings:text-white prose-p:text-gray-300 prose-a:text-orange-400 prose-strong:text-white prose-li:text-gray-300">
                {!! $news->content !!}
            </div>

            <!-- Share -->
            <div class="mt-10 pt-8 border-t border-gray-800">
                <p class="text-sm font-medium text-gray-400 mb-3">Share this post</p>
                <div class="flex gap-3">
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($news->title) }}"
                       target="_blank" rel="noopener" class="text-gray-400 hover:text-orange-400 transition">
                        <span class="sr-only">Twitter</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}"
                       target="_blank" rel="noopener" class="text-gray-400 hover:text-orange-400 transition">
                        <span class="sr-only">LinkedIn</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                    <button type="button" onclick="navigator.clipboard.writeText('{{ url()->current() }}'); alert('Link copied!');" class="text-gray-400 hover:text-orange-400 transition">
                        <span class="sr-only">Copy link</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-3M8 5a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Prev / Next -->
            <div class="mt-10 pt-8 border-t border-gray-800 grid grid-cols-1 sm:grid-cols-2 gap-6">
                @if($prev)
                <a href="{{ url('/news/' . $prev->slug) }}" class="group block p-4 rounded-lg border border-gray-800 hover:border-orange-500/50 transition">
                    <p class="text-xs text-gray-500 mb-1">Older post</p>
                    <p class="text-white font-semibold group-hover:text-orange-400 transition line-clamp-2">{{ $prev->title }}</p>
                </a>
                @else
                <div></div>
                @endif
                @if($next)
                <a href="{{ url('/news/' . $next->slug) }}" class="group block p-4 rounded-lg border border-gray-800 hover:border-orange-500/50 transition sm:text-right">
                    <p class="text-xs text-gray-500 mb-1">Newer post</p>
                    <p class="text-white font-semibold group-hover:text-orange-400 transition line-clamp-2">{{ $next->title }}</p>
                </a>
                @endif
            </div>
        </div>
    </article>

    <!-- You might also like -->
    @if($related->count() > 0)
    <section class="py-12 sm:py-16 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-white mb-8">You might also like</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($related as $article)
                <a href="{{ url('/news/' . ($article->slug ?? \Str::slug($article->title))) }}" class="group block">
                    @if($article->featured_image)
                    <div class="aspect-video rounded-lg overflow-hidden mb-3">
                        <img src="{{ $article->featured_image }}" alt="" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    </div>
                    @endif
                    <h3 class="text-lg font-semibold text-white group-hover:text-orange-400 transition line-clamp-2">{{ $article->title }}</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ $article->formatted_date }}</p>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Subscribe -->
    <section class="py-12 sm:py-16 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl font-bold text-white mb-2">Subscribe to our newsletter</h2>
            <p class="text-gray-400 mb-6 max-w-xl mx-auto">Get the latest news and updates delivered to your inbox.</p>
            <form method="POST" action="{{ route('newsletter.subscribe') }}" class="max-w-md mx-auto flex flex-col sm:flex-row gap-3" id="newsletter-form-detail">
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
