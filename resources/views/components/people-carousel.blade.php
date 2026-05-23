<div class="relative" x-data="peopleCarousel()" x-init="init()">
    <div class="relative">
        {{-- Edge fades hint that more content exists --}}
        <div x-show="canScrollLeft" x-transition.opacity
             class="absolute left-0 top-0 bottom-4 w-12 sm:w-20 bg-gradient-to-r from-black via-black/80 to-transparent pointer-events-none z-[1]"
             aria-hidden="true"></div>
        <div x-show="canScrollRight" x-transition.opacity
             class="absolute right-0 top-0 bottom-4 w-12 sm:w-20 bg-gradient-to-l from-black via-black/80 to-transparent pointer-events-none z-[1]"
             aria-hidden="true"></div>

        <button type="button"
                @click="scrollPrev()"
                :disabled="!canScrollLeft"
                :class="canScrollLeft ? 'opacity-100 hover:bg-orange-600 hover:border-orange-500' : 'opacity-30 cursor-not-allowed'"
                class="absolute left-0 sm:left-1 top-1/2 -translate-y-1/2 z-10 w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-gray-900/95 border border-gray-600 text-white flex items-center justify-center transition duration-200 shadow-lg"
                aria-label="Previous">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>

        <button type="button"
                @click="scrollNext()"
                :disabled="!canScrollRight"
                :class="canScrollRight ? 'opacity-100 hover:bg-orange-600 hover:border-orange-500' : 'opacity-30 cursor-not-allowed'"
                class="absolute right-0 sm:right-1 top-1/2 -translate-y-1/2 z-10 w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-gray-900/95 border border-gray-600 text-white flex items-center justify-center transition duration-200 shadow-lg"
                aria-label="Next">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>

        <div x-ref="track"
             @scroll.passive="updateButtons()"
             class="overflow-x-auto pb-4 scrollbar-hide scroll-smooth px-10 sm:px-12">
            {{ $slot }}
        </div>
    </div>
</div>
