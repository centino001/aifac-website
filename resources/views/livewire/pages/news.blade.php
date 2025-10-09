<div>
    <!-- Hero Section -->
    <section class="relative text-white py-12 sm:py-16 md:py-20 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat opacity-30" 
             style="background-image: url('{{ \App\Helpers\CloudinaryHelper::heroImage('news-hero') }}');"></div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-4 sm:mb-6 drop-shadow-lg">
                    Latest News
                </h1>
                <p class="text-lg sm:text-xl md:text-2xl mb-6 sm:mb-8 max-w-3xl mx-auto drop-shadow-md px-4">
                    Stay updated with the latest developments, events, and achievements from the Anyen Iyak Foundation and the African art and culture community.
                </p>
                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center px-4">
                    <a href="#featured-news" class="bg-orange-600 text-white px-6 sm:px-8 py-3 rounded-lg font-semibold hover:bg-orange-700 transition duration-300 text-center">
                        Featured Stories
                    </a>
                    <a href="#all-news" class="border-2 border-white text-white px-6 sm:px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-800 transition duration-300 text-center">
                        Browse All News
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- News Categories Section -->
    <section class="py-12 sm:py-16 bg-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8 sm:mb-12">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-3 sm:mb-4 px-4">News Categories</h2>
                <p class="text-base sm:text-lg text-gray-300 max-w-3xl mx-auto px-4">
                    Explore news and updates organized by different areas of our work and community impact.
                </p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
                <!-- Foundation News -->
                <div class="bg-black rounded-lg p-6 hover:bg-gray-700 transition duration-300 border border-gray-700 cursor-pointer" 
                     onclick="filterNews('foundation')">
                    <div class="bg-blue-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2 text-center">Foundation News</h3>
                    <p class="text-gray-300 text-center">
                        Updates about our foundation's activities, milestones, and organizational developments.
                    </p>
                </div>

                <!-- Events & Programs -->
                <div class="bg-black rounded-lg p-6 hover:bg-gray-700 transition duration-300 border border-gray-700 cursor-pointer" 
                     onclick="filterNews('events')">
                    <div class="bg-green-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2 text-center">Events & Programs</h3>
                    <p class="text-gray-300 text-center">
                        Announcements and coverage of our cultural events, workshops, and educational programs.
                    </p>
                </div>

                <!-- Artist Spotlights -->
                <div class="bg-black rounded-lg p-6 hover:bg-gray-700 transition duration-300 border border-gray-700 cursor-pointer" 
                     onclick="filterNews('artists')">
                    <div class="bg-purple-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2 text-center">Artist Spotlights</h3>
                    <p class="text-gray-300 text-center">
                        Features and interviews with talented artists in our community and network.
                    </p>
                </div>

                <!-- Community Impact -->
                <div class="bg-black rounded-lg p-6 hover:bg-gray-700 transition duration-300 border border-gray-700 cursor-pointer" 
                     onclick="filterNews('community')">
                    <div class="bg-yellow-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2 text-center">Community Impact</h3>
                    <p class="text-gray-300 text-center">
                        Stories about our community outreach, partnerships, and the impact of our initiatives.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured News Section -->
    <section id="featured-news" class="py-12 sm:py-16 bg-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8 sm:mb-12">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-3 sm:mb-4 px-4">Featured News</h2>
                <p class="text-base sm:text-lg text-gray-300 max-w-3xl mx-auto px-4">
                    Our most important announcements and impactful stories from the world of African art and culture.
                </p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                <!-- Featured News 1 -->
                <div class="bg-black rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition duration-300 border border-gray-700">
                    <div class="h-48 bg-gradient-to-br from-blue-500 to-blue-700 relative">
                        <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                        <div class="absolute bottom-4 left-4">
                            <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-medium">Foundation News</span>
                        </div>
                        <div class="absolute top-4 right-4">
                            <span class="bg-black bg-opacity-50 text-white px-2 py-1 rounded text-xs">Dec 15, 2024</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-white mb-2">Foundation Launches New Cultural Archive Initiative</h3>
                        <p class="text-gray-300 mb-4">
                            We're excited to announce the launch of our comprehensive digital archive project to preserve Akwa Ibom's cultural heritage for future generations.
                        </p>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-400">By Admin Team</span>
                            <a href="#" class="text-blue-400 hover:text-blue-300 font-medium">Read More →</a>
                        </div>
                    </div>
                </div>

                <!-- Featured News 2 -->
                <div class="bg-black rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition duration-300 border border-gray-700">
                    <div class="h-48 bg-gradient-to-br from-green-500 to-green-700 relative">
                        <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                        <div class="absolute bottom-4 left-4">
                            <span class="bg-green-600 text-white px-3 py-1 rounded-full text-sm font-medium">Events & Programs</span>
                        </div>
                        <div class="absolute top-4 right-4">
                            <span class="bg-black bg-opacity-50 text-white px-2 py-1 rounded text-xs">Dec 10, 2024</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-white mb-2">Annual Cultural Festival Draws Record Attendance</h3>
                        <p class="text-gray-300 mb-4">
                            Our 2024 Cultural Festival welcomed over 5,000 visitors, featuring traditional performances, art exhibitions, and cultural workshops.
                        </p>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-400">By Events Team</span>
                            <a href="#" class="text-green-400 hover:text-green-300 font-medium">Read More →</a>
                        </div>
                    </div>
                </div>

                <!-- Featured News 3 -->
                <div class="bg-black rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition duration-300 border border-gray-700">
                    <div class="h-48 bg-gradient-to-br from-purple-500 to-purple-700 relative">
                        <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                        <div class="absolute bottom-4 left-4">
                            <span class="bg-purple-600 text-white px-3 py-1 rounded-full text-sm font-medium">Artist Spotlights</span>
                        </div>
                        <div class="absolute top-4 right-4">
                            <span class="bg-black bg-opacity-50 text-white px-2 py-1 rounded text-xs">Dec 8, 2024</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-white mb-2">Rising Star: Meet Contemporary Artist Emem Udoh</h3>
                        <p class="text-gray-300 mb-4">
                            Discover the inspiring journey of Emem Udoh, whose innovative blend of traditional and modern techniques is gaining international recognition.
                        </p>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-400">By Culture Team</span>
                            <a href="#" class="text-purple-400 hover:text-purple-300 font-medium">Read More →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- All News Section -->
    <section id="all-news" class="py-12 sm:py-16 bg-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8 sm:mb-12">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-4 sm:mb-6 px-4">All News</h2>
                <div class="flex flex-wrap justify-center gap-2 sm:gap-3 md:gap-4 mb-6 sm:mb-8 px-4">
                    <button onclick="filterNews('all')" class="filter-btn bg-blue-600 text-white px-3 sm:px-4 py-2 rounded-lg text-sm sm:text-base font-medium hover:bg-blue-700 transition duration-300">
                        All News
                    </button>
                    <button onclick="filterNews('foundation')" class="filter-btn bg-blue-600 text-white px-3 sm:px-4 py-2 rounded-lg text-sm sm:text-base font-medium hover:bg-blue-400 hover:text-black transition duration-300">
                        <span class="hidden sm:inline">Foundation News</span>
                        <span class="sm:hidden">Foundation</span>
                    </button>
                    <button onclick="filterNews('events')" class="filter-btn bg-green-600 text-white px-3 sm:px-4 py-2 rounded-lg text-sm sm:text-base font-medium hover:bg-green-400 hover:text-black transition duration-300">
                        <span class="hidden sm:inline">Events & Programs</span>
                        <span class="sm:hidden">Events</span>
                    </button>
                    <button onclick="filterNews('artists')" class="filter-btn bg-purple-600 text-white px-3 sm:px-4 py-2 rounded-lg text-sm sm:text-base font-medium hover:bg-purple-400 hover:text-black transition duration-300">
                        <span class="hidden sm:inline">Artist Spotlights</span>
                        <span class="sm:hidden">Artists</span>
                    </button>
                    <button onclick="filterNews('community')" class="filter-btn bg-yellow-600 text-white px-3 sm:px-4 py-2 rounded-lg text-sm sm:text-base font-medium hover:bg-yellow-400 hover:text-black transition duration-300">
                        <span class="hidden sm:inline">Community Impact</span>
                        <span class="sm:hidden">Community</span>
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8" id="news-grid">
                <!-- News Article 1 - Foundation -->
                <div class="news-card bg-black rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition duration-300 border border-gray-700" data-category="foundation">
                    <div class="h-40 bg-gradient-to-br from-blue-400 to-blue-600"></div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">Foundation</span>
                            <span class="text-xs text-gray-400">Dec 12, 2024</span>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">New Partnership with Local Universities</h3>
                        <p class="text-gray-300 text-sm mb-4">
                            Expanding our educational outreach through strategic partnerships with regional academic institutions.
                        </p>
                        <a href="#" class="text-blue-400 hover:text-blue-300 text-sm font-medium">Read Article →</a>
                    </div>
                </div>

                <!-- News Article 2 - Events -->
                <div class="news-card bg-black rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition duration-300 border border-gray-700" data-category="events">
                    <div class="h-40 bg-gradient-to-br from-green-400 to-green-600"></div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">Events</span>
                            <span class="text-xs text-gray-400">Dec 5, 2024</span>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">Traditional Dance Workshop Series</h3>
                        <p class="text-gray-300 text-sm mb-4">
                            Join our monthly workshop series celebrating traditional Ibibio dance forms and cultural expressions.
                        </p>
                        <a href="#" class="text-green-400 hover:text-green-300 text-sm font-medium">Read Article →</a>
                    </div>
                </div>

                <!-- News Article 3 - Artists -->
                <div class="news-card bg-black rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition duration-300 border border-gray-700" data-category="artists">
                    <div class="h-40 bg-gradient-to-br from-purple-400 to-purple-600"></div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-xs font-medium">Artists</span>
                            <span class="text-xs text-gray-400">Nov 28, 2024</span>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">Sculptor Wins National Art Prize</h3>
                        <p class="text-gray-300 text-sm mb-4">
                            Local artist Ime Bassey receives prestigious recognition for contemporary sculpture work.
                        </p>
                        <a href="#" class="text-purple-400 hover:text-purple-300 text-sm font-medium">Read Article →</a>
                    </div>
                </div>

                <!-- News Article 4 - Community -->
                <div class="news-card bg-black rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition duration-300 border border-gray-700" data-category="community">
                    <div class="h-40 bg-gradient-to-br from-yellow-400 to-yellow-600"></div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-medium">Community</span>
                            <span class="text-xs text-gray-400">Nov 25, 2024</span>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">Youth Art Program Graduation</h3>
                        <p class="text-gray-300 text-sm mb-4">
                            Celebrating 50 young artists who completed our comprehensive art education program.
                        </p>
                        <a href="#" class="text-yellow-400 hover:text-yellow-300 text-sm font-medium">Read Article →</a>
                    </div>
                </div>

                <!-- News Article 5 - Foundation -->
                <div class="news-card bg-black rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition duration-300 border border-gray-700" data-category="foundation">
                    <div class="h-40 bg-gradient-to-br from-blue-400 to-blue-600"></div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">Foundation</span>
                            <span class="text-xs text-gray-400">Nov 20, 2024</span>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">Annual Report 2024 Released</h3>
                        <p class="text-gray-300 text-sm mb-4">
                            Review our achievements, impact metrics, and financial transparency in our comprehensive annual report.
                        </p>
                        <a href="#" class="text-blue-400 hover:text-blue-300 text-sm font-medium">Read Article →</a>
                    </div>
                </div>

                <!-- News Article 6 - Events -->
                <div class="news-card bg-black rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition duration-300 border border-gray-700" data-category="events">
                    <div class="h-40 bg-gradient-to-br from-green-400 to-green-600"></div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">Events</span>
                            <span class="text-xs text-gray-400">Nov 15, 2024</span>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">Cultural Heritage Exhibition Opens</h3>
                        <p class="text-gray-300 text-sm mb-4">
                            New exhibition showcasing 200 years of Akwa Ibom cultural artifacts and contemporary interpretations.
                        </p>
                        <a href="#" class="text-green-400 hover:text-green-300 text-sm font-medium">Read Article →</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Signup Section -->
    <section class="py-12 sm:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-3 sm:mb-4 px-4">
                Stay Updated
            </h2>
            <p class="text-base sm:text-lg md:text-xl text-gray-300 mb-6 sm:mb-8 max-w-3xl mx-auto px-4">
                Subscribe to our newsletter to receive the latest news, event announcements, and updates from the Anyen Iyak Foundation.
            </p>
            <div class="max-w-md mx-auto flex flex-col sm:flex-row gap-3 sm:gap-4 px-4">
                <input type="email" placeholder="Enter your email address" class="flex-1 px-4 py-3 rounded-lg border border-gray-600 bg-gray-800 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                <button class="bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-orange-700 transition duration-300 text-center">
                    Subscribe
                </button>
            </div>
        </div>
    </section>

    <!-- JavaScript for filtering -->
    <script>
        function filterNews(category) {
            const cards = document.querySelectorAll('.news-card');
            
            // Filter cards - no button styling changes
            cards.forEach(card => {
                if (category === 'all' || card.dataset.category === category) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
</div>
