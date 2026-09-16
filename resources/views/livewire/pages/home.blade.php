<div>
    @if($showSummitBanner)
        <!-- GBSAAC 2026 Announcement Banner (auto-hides after 1 November 2026, Lagos time) -->
        <section class="bg-black summit-banner mb-16" wire:ignore>
            <video
                id="summit-banner-video"
                class="block w-full h-auto"
                src="{{ $summitBannerUrl }}"
                autoplay
                muted
                loop
                playsinline
                preload="auto"
                aria-label="The 2nd Global Biennial Summit for African Art &amp; Culture 2026 — Chasing The Wind While Losing Daylight. New Culture Studios, Ibadan. October 21 - 22, 2026"
            ></video>

            <div class="bg-black px-4 py-6 sm:py-8 flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4">
                <button type="button"
                   onclick="openTicketTypeModal()"
                   class="inline-flex min-w-[10.5rem] items-center justify-center bg-[#f3ead8] text-[#1a120c] px-6 py-2.5 sm:px-8 sm:py-3 text-sm sm:text-base font-semibold tracking-wide uppercase hover:bg-white transition duration-300">
                    Buy Ticket
                </button>
                <a href="{{ $summitExploreUrl }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="inline-flex min-w-[10.5rem] items-center justify-center border border-[#f3ead8] text-[#f3ead8] px-6 py-2.5 sm:px-8 sm:py-3 text-sm sm:text-base font-semibold tracking-wide uppercase hover:bg-[#f3ead8] hover:text-[#1a120c] transition duration-300">
                    Explore Event
                </a>
            </div>
        </section>
        <script>
            (function () {
                function playSummitBanner() {
                    const video = document.getElementById('summit-banner-video');
                    if (!video) return;
                    video.muted = true;
                    video.loop = true;
                    video.playsInline = true;
                    const attempt = video.play();
                    if (attempt && typeof attempt.catch === 'function') {
                        attempt.catch(() => {});
                    }
                }

                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', playSummitBanner);
                } else {
                    playSummitBanner();
                }

                document.addEventListener('livewire:navigated', playSummitBanner);
            })();
        </script>
    @endif

    <!-- Hero Multimedia Slider Section -->
    <section class="relative overflow-hidden hero-slider" style="height: 80vh; min-height: 600px;">
        <!-- Slides Container -->
        <div class="relative w-full h-full">
            @foreach($slides as $index => $slide)
                <div class="absolute inset-0 transition-opacity duration-1000 {{ $currentSlide === $index ? 'opacity-100' : 'opacity-0' }}"
                     wire:key="slide-{{ $index }}">
                    
                    @if($slide['type'] === 'video')
                        <!-- Video Slide -->
                        <video 
                            class="w-full h-full object-cover"
                            autoplay 
                            muted 
                            loop
                            playsinline
                            onended="window.livewire.find('{{ $this->getId() }}').call('nextSlide')"
                            {{ $currentSlide === $index ? '' : 'style=display:none' }}
                        >
                            <source src="{{ $slide['src'] }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @else
                        <!-- Image Slide -->
                        <div class="w-full h-full bg-cover bg-center bg-no-repeat"
                             style="background-image: url('{{ $slide['src'] }}')">
        </div>
                    @endif
        
        <!-- Content Overlay -->
                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                        <div class="text-center text-white px-4 max-w-4xl mx-auto">
                            <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold mb-6 drop-shadow-lg">
                                {{ $slide['title'] }}
                </h1>
                            <p class="text-lg sm:text-xl md:text-2xl lg:text-3xl mb-8 max-w-3xl mx-auto drop-shadow-md">
                                {{ $slide['description'] }}
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                 <a href="/projects" class="bg-orange-600 text-white px-8 py-4 rounded-lg font-semibold hover:bg-orange-700 transition duration-300 text-lg shadow-lg">
                        View Our Projects
                    </a>
                                 {{-- <button onclick="openDonationTypeModal()" class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-black transition duration-300 text-lg shadow-lg">
                        Make a Donation
                                 </button> --}}
                             </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Navigation Arrows -->
        <button wire:click="previousSlide" 
                class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white bg-black bg-opacity-50 hover:bg-opacity-75 rounded-full p-4 transition-all z-20 group">
            <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>
        
        <button wire:click="nextSlide"
                class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white bg-black bg-opacity-50 hover:bg-opacity-75 rounded-full p-4 transition-all z-20 group">
            <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>
        
        <!-- Slide Indicators -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-3 z-20">
            @foreach($slides as $index => $slide)
                <button wire:click="goToSlide({{ $index }})"
                        class="w-4 h-4 rounded-full transition-all {{ $currentSlide === $index ? 'bg-white scale-110' : 'bg-white bg-opacity-50 hover:bg-opacity-75' }}">
                </button>
            @endforeach
            </div>
        
        <!-- Progress Bar for Current Slide -->
        <div class="absolute bottom-16 left-1/2 transform -translate-x-1/2 w-64 bg-white bg-opacity-20 rounded-full h-1 z-20">
            <div class="bg-white h-full rounded-full transition-all duration-300 slide-progress" 
                 data-slide-type="{{ $slides[$currentSlide]['type'] ?? 'image' }}"
                 data-duration="{{ $slides[$currentSlide]['duration'] ?? 5000 }}"></div>
        </div>
    </section>

    <!-- Auto-advance and Progress JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let autoSlideTimer;
            let progressTimer;
            let progressBar;
            
            function updateProgressBar() {
                progressBar = document.querySelector('.slide-progress');
                if (!progressBar) return;
                
                const slideType = progressBar.getAttribute('data-slide-type');
                const duration = parseInt(progressBar.getAttribute('data-duration'));
                
                // Reset progress
                progressBar.style.width = '0%';
                progressBar.style.transition = 'none';
                
                // Start progress animation for images
                if (slideType === 'image') {
                    setTimeout(() => {
                        progressBar.style.transition = `width ${duration}ms linear`;
                        progressBar.style.width = '100%';
                    }, 50);
                }
            }
            
            function startAutoSlide() {
                clearInterval(autoSlideTimer);
                clearTimeout(progressTimer);
                
                // Update progress bar
                updateProgressBar();
                
                // Auto-advance timer for images only
                const currentSlideData = @json($slides)[@this.currentSlide];
                if (currentSlideData && currentSlideData.type === 'image') {
                    progressTimer = setTimeout(() => {
                        @this.call('nextSlide');
                    }, currentSlideData.duration);
                }
            }
            
            function stopAutoSlide() {
                clearInterval(autoSlideTimer);
                clearTimeout(progressTimer);
            }
            
            // Initialize
            startAutoSlide();
            
            // Listen for Livewire updates
            Livewire.on('slideChanged', () => {
                setTimeout(startAutoSlide, 100);
            });
            
            // Restart timer when slide changes
            document.addEventListener('livewire:updated', function() {
                setTimeout(startAutoSlide, 100);
            });
            
            // Pause on hover
            const heroSlider = document.querySelector('.hero-slider');
            if (heroSlider) {
                heroSlider.addEventListener('mouseenter', stopAutoSlide);
                heroSlider.addEventListener('mouseleave', startAutoSlide);
            }
        });
    </script>

    <!-- Mobile Responsive Styles -->
    <style>
        .hero-slider {
            background: #000;
        }
        
        /* Mobile optimizations */
        @media (max-width: 768px) {
            .hero-slider {
                height: 70vh;
                min-height: 500px;
            }
        }
        
        @media (max-width: 480px) {
            .hero-slider {
                height: 60vh;
                min-height: 400px;
            }
        }
        
        /* Landscape mobile */
        @media (max-width: 767px) and (orientation: landscape) {
            .hero-slider {
                height: 100vh;
                min-height: 400px;
            }
        }
        
        /* Enhanced hover effects */
        .hero-slider button:hover {
            transform: scale(1.1);
        }
        
        /* Smooth video transitions */
        .hero-slider video {
            transition: opacity 0.5s ease-in-out;
        }
    </style>

    <!-- Our Mission Section -->
    <section class="py-16 bg-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">The Pillars Of Anyen Iyak Foundation Of Art And Culture</h2>
                {{-- <p class="text-lg text-gray-300 max-w-3xl mx-auto">
                    We are dedicated to creating sustainable solutions that address community needs, 
                    foster innovation, and build lasting partnerships for positive social impact.
                </p> --}}
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-amber-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Cultural Regeneration, Preservation, And Continuity</h3>
                    <p class="text-gray-300 text-justify">
                        Preserving And Passing Down The Unique Traditions, Customs, And Values Of Akwa Ibom's Indigenous Communities Is Vital For Sustaining Its Cultural Identity. This Pillar Is Dedicated To Discovering, Showing, And Maintaining These Cultural Elements Through Targeted Research Initiatives And Comprehensive Documentation Efforts, Ensuring They Remain Relevant And Accessible For Both Present And Future Generations.
                    </p>
                </div>
                <div class="text-center">
                    <div class="bg-emerald-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M8 9c0-2.21 1.79-4 4-4s4 1.79 4 4-1.79 4-4 4-4-1.79-4-4z"></path>
                            <circle cx="9" cy="7" r="1" fill="white"></circle>
                            <circle cx="15" cy="7" r="1" fill="white"></circle>
                            <circle cx="12" cy="11" r="1" fill="white"></circle>
                            <path stroke="white" stroke-width="0.5" d="M9 7l3 4m0-4l-3 4m6-4l-6 4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Unification Of The African Art And Culture Ecosystem</h3>
                    <p class="text-gray-300 text-justify">
                        This Pillar Focuses On Building A Connected Network For Individuals Within Africa's Art And Culture Ecosystem, Fostering Collaboration, Knowledge-Sharing, And Mutual Growth. It Aims To Break Down Silos By Encouraging Partnerships And Instilling A Shared Sense Of Responsibility To Uplift And Support One Another.
                    </p>
                </div>
                <div class="text-center">
                    <div class="bg-rose-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM7 3H5a2 2 0 00-2 2v12a4 4 0 004 4h2a2 2 0 002-2V5a2 2 0 00-2-2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9h.01M9 12h.01M9 15h.01M9 18h.01"></path>
                            <circle cx="16" cy="8" r="2" fill="currentColor"></circle>
                            <circle cx="20" cy="12" r="1.5" fill="currentColor"></circle>
                            <circle cx="18" cy="16" r="1" fill="currentColor"></circle>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Artistic Development</h3>
                    <p class="text-gray-300 text-justify">
                        This Pillar Is Dedicated To Supporting And Empowering Artists Within And Beyond Akwa Ibom State By Fostering A Vibrant Environment For Creativity And Expression. It Focuses On The Holistic Development Of Artists By Equipping Them With The Skills, Knowledge, And Tools To Realize Their Great Work, Providing Platforms To Amplify Their Voice And Showcase Their Work To Local And Global Audiences.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Preview Section -->
    <section class="py-16 bg-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Our Projects</h2>
                <p class="text-lg text-gray-300">
                    Discover the initiatives we're working on to make a difference in communities worldwide.
                </p>
            </div>
            
            <!-- Project Cards Placeholder -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
                {{-- <div class="bg-black rounded-lg shadow-md overflow-hidden border border-gray-700">
                    <div class="h-48 bg-gradient-to-br from-blue-400 to-blue-600"></div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-white mb-2">Clean Water Initiative</h3>
                        <p class="text-gray-300 mb-4">Providing access to clean water in underserved communities through sustainable infrastructure.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-blue-400 font-medium">₦2,500,000 raised</span>
                            <a href="#" class="text-blue-400 hover:text-blue-300 font-medium">Learn More</a>
                        </div>
                    </div>
                </div> --}}
                
                <div class="bg-black rounded-lg shadow-md overflow-hidden border border-gray-700">
                    <div class="h-48 bg-cover bg-center bg-no-repeat" style="background-image: url('https://res.cloudinary.com/dgsctl247/image/upload/v1759218155/ekonke_b8v34s.jpg')"></div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-white mb-2">Ekonke</h3>
                        <p class="text-gray-300 mb-4">Story telling and folklore</p>
                        <div class="flex justify-between items-center">
                            {{-- <span class="text-sm text-green-400 font-medium">₦1,800,000 raised</span> --}}
                            <a href="/projects/ekonke" class="text-green-400 hover:text-green-300 font-medium">Learn More</a>
                        </div>
                    </div>
                </div>
                
                {{-- <div class="bg-black rounded-lg shadow-md overflow-hidden border border-gray-700">
                    <div class="h-48 bg-gradient-to-br from-purple-400 to-purple-600"></div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-white mb-2">Healthcare Access</h3>
                        <p class="text-gray-300 mb-4">Establishing mobile clinics and health centers in remote communities.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-purple-400 font-medium">₦3,200,000 raised</span>
                            <a href="#" class="text-purple-400 hover:text-purple-300 font-medium">Learn More</a>
                        </div>
                    </div>
                </div> --}}
            </div>
            
            <div class="text-center">
                <a href="/projects" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition duration-150">
                    View All Projects
                </a>
            </div>
        </div>
    </section>

    <!-- News Section -->
    {{-- <section class="py-16 bg-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Latest News</h2>
                <p class="text-lg text-gray-300">
                    Stay updated with our recent activities, achievements, and upcoming events.
                </p>
            </div>
            
            <!-- News Cards Placeholder -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
                <article class="bg-black border border-gray-700 rounded-lg overflow-hidden hover:shadow-md transition duration-150">
                    <div class="h-48 bg-gradient-to-br from-orange-400 to-red-500"></div>
                    <div class="p-6">
                        <time class="text-sm text-gray-400">November 15, 2024</time>
                        <h3 class="text-xl font-semibold text-white mb-2 mt-1">New Partnership Announcement</h3>
                        <p class="text-gray-300 mb-4">We're excited to announce our new partnership with local organizations to expand our reach...</p>
                        <a href="#" class="text-blue-400 hover:text-blue-300 font-medium">Read More</a>
                    </div>
                </article>
                
                <article class="bg-black border border-gray-700 rounded-lg overflow-hidden hover:shadow-md transition duration-150">
                    <div class="h-48 bg-gradient-to-br from-teal-400 to-blue-500"></div>
                    <div class="p-6">
                        <time class="text-sm text-gray-400">November 10, 2024</time>
                        <h3 class="text-xl font-semibold text-white mb-2 mt-1">Milestone Achievement</h3>
                        <p class="text-gray-300 mb-4">Our Clean Water Initiative has successfully reached 1,000 families in rural communities...</p>
                        <a href="#" class="text-blue-400 hover:text-blue-300 font-medium">Read More</a>
                    </div>
                </article>
                
                <article class="bg-black border border-gray-700 rounded-lg overflow-hidden hover:shadow-md transition duration-150">
                    <div class="h-48 bg-gradient-to-br from-pink-400 to-purple-500"></div>
                    <div class="p-6">
                        <time class="text-sm text-gray-400">November 5, 2024</time>
                        <h3 class="text-xl font-semibold text-white mb-2 mt-1">Community Event Success</h3>
                        <p class="text-gray-300 mb-4">Our recent community outreach event brought together over 500 volunteers and raised...</p>
                        <a href="#" class="text-blue-400 hover:text-blue-300 font-medium">Read More</a>
                    </div>
                </article>
            </div>
            
            <div class="text-center">
                <a href="/news" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition duration-150">
                    Read All News
                </a>
            </div>
        </div>
    </section> --}}

    <!-- Coming Soon Section (Conditional) -->
    <section class="py-16 bg-black text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Something Big is Coming</h2>
            <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                We're working on an exciting new initiative that will transform how we approach community development. 
                Stay tuned for updates!
            </p>
            {{-- <a href="/membership" class="bg-orange-600 hover:bg-orange-700 text-white px-8 py-3 rounded-lg font-semibold transition duration-150">
                Join Our Community
            </a> --}}
        </div>
    </section>
</div>
