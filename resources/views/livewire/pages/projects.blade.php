<div>
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-blue-600 to-blue-800 text-white py-12 sm:py-16 md:py-20 overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat opacity-30" 
             style="background-image: url('{{ \App\Helpers\CloudinaryHelper::heroImage('projects-hero') }}');"></div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-4 sm:mb-6 drop-shadow-lg">
                    Our Projects
                </h1>
                <p class="text-lg sm:text-xl md:text-2xl mb-6 sm:mb-8 max-w-3xl mx-auto drop-shadow-md px-4">
                    Discover the impactful initiatives and creative endeavors that embody our mission to preserve, develop, and unify African art and culture.
                </p>
                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center px-4">
                    <a href="#featured-projects" class="bg-orange-600 text-white px-6 sm:px-8 py-3 rounded-lg font-semibold hover:bg-orange-700 transition duration-300 text-center">
                        View Featured Projects
                    </a>
                    <a href="#all-projects" class="border-2 border-white text-white px-6 sm:px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-800 transition duration-300 text-center">
                        Browse All Projects
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Project Categories Section -->
    <section class="py-12 sm:py-16 bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8 sm:mb-12">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-3 sm:mb-4 px-4">Project Categories</h2>
                <p class="text-base sm:text-lg text-gray-300 max-w-3xl mx-auto px-4">
                    Explore our diverse range of projects organized by our core pillars and focus areas.
                </p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                <!-- Cultural Preservation Projects -->
                <div class="bg-gray-800 rounded-lg p-6 hover:bg-gray-700 transition duration-300 cursor-pointer" 
                     onclick="filterProjects('cultural')">
                    <div class="bg-amber-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2 text-center">Cultural Preservation</h3>
                    <p class="text-gray-300 text-center">
                        Projects focused on documenting, preserving, and promoting Akwa Ibom's rich cultural heritage.
                    </p>
                    <div class="mt-4 text-center">
                        <span class="bg-amber-100 text-amber-800 px-3 py-1 rounded-full text-sm font-medium">8 Projects</span>
                    </div>
                </div>

                <!-- Artistic Development Projects -->
                <div class="bg-gray-800 rounded-lg p-6 hover:bg-gray-700 transition duration-300 cursor-pointer" 
                     onclick="filterProjects('artistic')">
                    <div class="bg-rose-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM7 3H5a2 2 0 00-2 2v12a4 4 0 004 4h2a2 2 0 002-2V5a2 2 0 00-2-2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9h.01M9 12h.01M9 15h.01M9 18h.01"></path>
                            <circle cx="16" cy="8" r="2" fill="currentColor"></circle>
                            <circle cx="20" cy="12" r="1.5" fill="currentColor"></circle>
                            <circle cx="18" cy="16" r="1" fill="currentColor"></circle>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2 text-center">Artistic Development</h3>
                    <p class="text-gray-300 text-center">
                        Programs and initiatives supporting artists through training, mentorship, and platform creation.
                    </p>
                    <div class="mt-4 text-center">
                        <span class="bg-rose-100 text-rose-800 px-3 py-1 rounded-full text-sm font-medium">12 Projects</span>
                    </div>
                </div>

                <!-- Unity & Ecosystem Projects -->
                <div class="bg-gray-800 rounded-lg p-6 hover:bg-gray-700 transition duration-300 cursor-pointer" 
                     onclick="filterProjects('unity')">
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
                    <h3 class="text-xl font-semibold text-white mb-2 text-center">Unity & Ecosystem</h3>
                    <p class="text-gray-300 text-center">
                        Collaborative projects building networks and partnerships across Africa's cultural landscape.
                    </p>
                    <div class="mt-4 text-center">
                        <span class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full text-sm font-medium">6 Projects</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Projects Section -->
    <section id="featured-projects" class="py-12 sm:py-16 bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8 sm:mb-12">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-3 sm:mb-4 px-4">Featured Projects</h2>
                <p class="text-base sm:text-lg text-gray-300 max-w-3xl mx-auto px-4">
                    Highlighting our most impactful and innovative initiatives that showcase the depth and breadth of our work.
                </p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                <!-- Featured Project 1 -->
                <div class="bg-gray-900 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition duration-300">
                    <div class="h-48 bg-gradient-to-br from-amber-500 to-amber-700 relative">
                        <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                        <div class="absolute bottom-4 left-4">
                            <span class="bg-amber-600 text-white px-3 py-1 rounded-full text-sm font-medium">Cultural Preservation</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-white mb-2">Ibibio Heritage Documentation</h3>
                        <p class="text-gray-300 mb-4">
                            Comprehensive documentation of Ibibio traditional practices, stories, and cultural expressions through multimedia archives.
                        </p>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-400">Status: Active</span>
                            <a href="#" class="text-amber-400 hover:text-amber-300 font-medium">Learn More →</a>
                        </div>
                    </div>
                </div>

                <!-- Featured Project 2 -->
                <div class="bg-gray-900 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition duration-300">
                    <div class="h-48 bg-gradient-to-br from-rose-500 to-rose-700 relative">
                        <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                        <div class="absolute bottom-4 left-4">
                            <span class="bg-rose-600 text-white px-3 py-1 rounded-full text-sm font-medium">Artistic Development</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-white mb-2">Young Artists Mentorship Program</h3>
                        <p class="text-gray-300 mb-4">
                            Empowering emerging artists through structured mentorship, skill development workshops, and exhibition opportunities.
                        </p>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-400">Status: Ongoing</span>
                            <a href="#" class="text-rose-400 hover:text-rose-300 font-medium">Learn More →</a>
                        </div>
                    </div>
                </div>

                <!-- Featured Project 3 -->
                <div class="bg-gray-900 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition duration-300">
                    <div class="h-48 bg-gradient-to-br from-emerald-500 to-emerald-700 relative">
                        <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                        <div class="absolute bottom-4 left-4">
                            <span class="bg-emerald-600 text-white px-3 py-1 rounded-full text-sm font-medium">Unity & Ecosystem</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-white mb-2">Pan-African Cultural Exchange</h3>
                        <p class="text-gray-300 mb-4">
                            Building bridges between African cultural institutions to facilitate knowledge sharing and collaborative projects.
                        </p>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-400">Status: Planning</span>
                            <a href="#" class="text-emerald-400 hover:text-emerald-300 font-medium">Learn More →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- All Projects Section -->
    <section id="all-projects" class="py-12 sm:py-16 bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8 sm:mb-12">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-4 sm:mb-6 px-4">All Projects</h2>
                <div class="flex flex-wrap justify-center gap-2 sm:gap-3 md:gap-4 mb-6 sm:mb-8 px-4">
                    <button onclick="filterProjects('all')" class="filter-btn active bg-blue-600 text-white px-3 sm:px-4 py-2 rounded-lg text-sm sm:text-base font-medium hover:bg-blue-700 transition duration-300">
                        All Projects
                    </button>
                    <button onclick="filterProjects('cultural')" class="filter-btn bg-gray-700 text-gray-300 px-3 sm:px-4 py-2 rounded-lg text-sm sm:text-base font-medium hover:bg-amber-600 hover:text-white transition duration-300">
                        <span class="hidden sm:inline">Cultural Preservation</span>
                        <span class="sm:hidden">Cultural</span>
                    </button>
                    <button onclick="filterProjects('artistic')" class="filter-btn bg-gray-700 text-gray-300 px-3 sm:px-4 py-2 rounded-lg text-sm sm:text-base font-medium hover:bg-rose-600 hover:text-white transition duration-300">
                        <span class="hidden sm:inline">Artistic Development</span>
                        <span class="sm:hidden">Artistic</span>
                    </button>
                    <button onclick="filterProjects('unity')" class="filter-btn bg-gray-700 text-gray-300 px-3 sm:px-4 py-2 rounded-lg text-sm sm:text-base font-medium hover:bg-emerald-600 hover:text-white transition duration-300">
                        <span class="hidden sm:inline">Unity & Ecosystem</span>
                        <span class="sm:hidden">Unity</span>
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8" id="projects-grid">
                <!-- Project 1 - Cultural -->
                <div class="project-card bg-gray-800 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition duration-300" data-category="cultural">
                    <div class="h-40 bg-gradient-to-br from-amber-400 to-amber-600"></div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="bg-amber-100 text-amber-800 px-2 py-1 rounded-full text-xs font-medium">Cultural</span>
                            <span class="text-xs text-gray-400">2024</span>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">Traditional Music Archive</h3>
                        <p class="text-gray-300 text-sm mb-4">
                            Recording and preserving traditional Akwa Ibom musical compositions and instruments.
                        </p>
                        <a href="#" class="text-amber-400 hover:text-amber-300 text-sm font-medium">View Project →</a>
                    </div>
                </div>

                <!-- Project 2 - Artistic -->
                <div class="project-card bg-gray-800 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition duration-300" data-category="artistic">
                    <div class="h-40 bg-gradient-to-br from-rose-400 to-rose-600"></div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="bg-rose-100 text-rose-800 px-2 py-1 rounded-full text-xs font-medium">Artistic</span>
                            <span class="text-xs text-gray-400">2024</span>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">Digital Art Workshop Series</h3>
                        <p class="text-gray-300 text-sm mb-4">
                            Training local artists in digital art techniques and modern creative tools.
                        </p>
                        <a href="#" class="text-rose-400 hover:text-rose-300 text-sm font-medium">View Project →</a>
                    </div>
                </div>

                <!-- Project 3 - Unity -->
                <div class="project-card bg-gray-800 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition duration-300" data-category="unity">
                    <div class="h-40 bg-gradient-to-br from-emerald-400 to-emerald-600"></div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="bg-emerald-100 text-emerald-800 px-2 py-1 rounded-full text-xs font-medium">Unity</span>
                            <span class="text-xs text-gray-400">2024</span>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">African Artists Network</h3>
                        <p class="text-gray-300 text-sm mb-4">
                            Creating connections between artists across African countries for collaboration.
                        </p>
                        <a href="#" class="text-emerald-400 hover:text-emerald-300 text-sm font-medium">View Project →</a>
                    </div>
                </div>

                <!-- Project 4 - Cultural -->
                <div class="project-card bg-gray-800 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition duration-300" data-category="cultural">
                    <div class="h-40 bg-gradient-to-br from-amber-400 to-amber-600"></div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="bg-amber-100 text-amber-800 px-2 py-1 rounded-full text-xs font-medium">Cultural</span>
                            <span class="text-xs text-gray-400">2023</span>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">Folklore Collection Project</h3>
                        <p class="text-gray-300 text-sm mb-4">
                            Gathering and documenting oral traditions and folktales from elders.
                        </p>
                        <a href="#" class="text-amber-400 hover:text-amber-300 text-sm font-medium">View Project →</a>
                    </div>
                </div>

                <!-- Project 5 - Artistic -->
                <div class="project-card bg-gray-800 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition duration-300" data-category="artistic">
                    <div class="h-40 bg-gradient-to-br from-rose-400 to-rose-600"></div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="bg-rose-100 text-rose-800 px-2 py-1 rounded-full text-xs font-medium">Artistic</span>
                            <span class="text-xs text-gray-400">2023</span>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">Community Art Exhibition</h3>
                        <p class="text-gray-300 text-sm mb-4">
                            Showcasing local artists' work in community spaces and galleries.
                        </p>
                        <a href="#" class="text-rose-400 hover:text-rose-300 text-sm font-medium">View Project →</a>
                    </div>
                </div>

                <!-- Project 6 - Unity -->
                <div class="project-card bg-gray-800 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition duration-300" data-category="unity">
                    <div class="h-40 bg-gradient-to-br from-emerald-400 to-emerald-600"></div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="bg-emerald-100 text-emerald-800 px-2 py-1 rounded-full text-xs font-medium">Unity</span>
                            <span class="text-xs text-gray-400">2023</span>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">Cultural Exchange Program</h3>
                        <p class="text-gray-300 text-sm mb-4">
                            Facilitating cultural exchanges between different African communities.
                        </p>
                        <a href="#" class="text-emerald-400 hover:text-emerald-300 text-sm font-medium">View Project →</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="py-12 sm:py-16 bg-gradient-to-r from-blue-600 to-purple-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-3 sm:mb-4 px-4">
                Want to Collaborate on a Project?
            </h2>
            <p class="text-base sm:text-lg md:text-xl text-blue-100 mb-6 sm:mb-8 max-w-3xl mx-auto px-4">
                We're always looking for passionate individuals and organizations to partner with us in preserving and promoting African art and culture.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center px-4">
                <a href="#" class="bg-white text-blue-600 px-6 sm:px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300 text-center">
                    Propose a Project
                </a>
                <a href="#" class="border-2 border-white text-white px-6 sm:px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition duration-300 text-center">
                    Contact Us
                </a>
            </div>
        </div>
    </section>

    <!-- JavaScript for filtering -->
    <script>
        function filterProjects(category) {
            const cards = document.querySelectorAll('.project-card');
            const buttons = document.querySelectorAll('.filter-btn');
            
            // Update button states
            buttons.forEach(btn => {
                btn.classList.remove('active', 'bg-blue-600', 'bg-amber-600', 'bg-rose-600', 'bg-emerald-600');
                btn.classList.add('bg-gray-700', 'text-gray-300');
            });
            
            // Set active button
            const activeBtn = event.target;
            activeBtn.classList.remove('bg-gray-700', 'text-gray-300');
            activeBtn.classList.add('active', 'text-white');
            
            if (category === 'cultural') {
                activeBtn.classList.add('bg-amber-600');
            } else if (category === 'artistic') {
                activeBtn.classList.add('bg-rose-600');
            } else if (category === 'unity') {
                activeBtn.classList.add('bg-emerald-600');
            } else {
                activeBtn.classList.add('bg-blue-600');
            }
            
            // Filter cards
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
