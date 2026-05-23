<div>
    <!-- Video Section -->
    <section class="py-4 sm:py-8 bg-black">
        <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8">
            <div class="relative w-full">
                <video 
                    class="w-full rounded-lg shadow-2xl mobile-video"
                    autoplay 
                    muted 
                    loop 
                    playsinline
                    controls
                >
                    <source src="https://res.cloudinary.com/dgsctl247/video/upload/v1758799454/about_us_eyqz1j.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </section>

    <style>
        .mobile-video {
            /* Mobile-first approach - fit to viewport height on small screens */
            height: 50vh;
            object-fit: cover;
            max-height: 400px;
        }
        
        /* Tablet and small desktop */
        @media (min-width: 640px) {
            .mobile-video {
                height: 60vh;
                max-height: 500px;
            }
        }
        
        /* Desktop */
        @media (min-width: 1024px) {
            .mobile-video {
                height: 600px;
                max-height: 600px;
            }
        }
        
        /* Landscape orientation on mobile devices */
        @media (max-width: 767px) and (orientation: landscape) {
            .mobile-video {
                height: 80vh;
                max-height: none;
            }
        }
        
        /* Very small screens */
        @media (max-width: 375px) {
            .mobile-video {
                height: 45vh;
                border-radius: 8px;
            }
        }
    </style>

    <!-- Our Story Section -->
    <section class="py-12 sm:py-16 bg-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8 sm:mb-12">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-3 sm:mb-4 px-4">Our Story</h2>
            </div>
            <div class="max-w-4xl mx-auto">
                <div class="bg-black rounded-lg p-6 sm:p-8 border border-gray-700">
                    <p class="text-base sm:text-lg text-gray-300 mb-6 leading-relaxed">
                        Anyen Iyak Foundation for Art and Culture Is A Non-Profit Organisation Dedicated To Capturing, Preserving, And Sharing The Rich Heritage Of Akwa Ibom's Indigenous People. All Through Its Programs And Initiatives, The Foundation Seeks To Support, Encourage, And Promote Akwa Ibom's Art And Culture Locally And Globally.

                    </p>
                    <p class="text-base sm:text-lg text-gray-300 mb-6 leading-relaxed">
                        "Anyen Iyak," Meaning "Fish Eye" In Ibibio, Symbolizes Unwavering Vision And Awareness. Just As A Fish's Eyes Remain Open In Life And Death, The Foundation Remains Steadfast In Connecting The Past With The Present To Carry It Forward Into The Future. With Unwavering Focus, It Serves As A Guardian Of Heritage, Ensuring That The Culture Of Akwa Ibom Endures And Thrives.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision Section -->
    {{-- <section id="mission-vision" class="py-12 sm:py-16 bg-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8 sm:mb-12">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-3 sm:mb-4 px-4">Mission & Vision</h2>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 sm:gap-12">
                <!-- Mission -->
                <div class="bg-black rounded-lg p-6 sm:p-8 border border-gray-700">
                    <div class="flex items-center mb-6">
                        <div class="bg-orange-600 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-bold text-white">Our Mission</h3>
                    </div>
                    <p class="text-base sm:text-lg text-gray-300 leading-relaxed">
                        To preserve, promote, and perpetuate the rich cultural heritage of Akwa Ibom State and Africa through comprehensive documentation, artistic development programs, and the creation of sustainable platforms that connect artists, cultural institutions, and communities across the continent.
                    </p>
                </div>

                <!-- Vision -->
                <div class="bg-black rounded-lg p-6 sm:p-8 border border-gray-700">
                    <div class="flex items-center mb-6">
                        <div class="bg-blue-600 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-bold text-white">Our Vision</h3>
                    </div>
                    <p class="text-base sm:text-lg text-gray-300 leading-relaxed">
                        To be the leading catalyst for African cultural renaissance, creating a unified ecosystem where traditional wisdom and contemporary creativity converge to inspire global appreciation and ensure the continuity of our cultural legacy for future generations.
                    </p>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- Core Values Section -->
    <section class="py-12 sm:py-16 bg-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8 sm:mb-12">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-3 sm:mb-4 px-4">AT THE HEART OF EVERYTHING WE DO ARE OUR FUNDAMENTAL VALUES</h2>
                <p class="text-base sm:text-lg text-gray-300 max-w-3xl mx-auto px-4">
                    The principles that guide our work and define our commitment to cultural preservation and artistic excellence.
                </p>
            </div>
            <!-- First Row: 3 Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 mb-6 sm:mb-8">
                <!-- Teamwork -->
                <div class="bg-black rounded-lg p-6 border border-gray-700 text-center">
                    <div class="bg-green-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Teamwork</h3>
                    <p class="text-gray-300 text-sm">
                        Collaboration Is Key - Every Effort, Big Or Small, Adds To The Bigger Picture.
                    </p>
                </div>

                <!-- Leadership -->
                <div class="bg-black rounded-lg p-6 border border-gray-700 text-center">
                    <div class="bg-purple-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Leadership</h3>
                    <p class="text-gray-300 text-sm">
                        Leadership Is Not Just For The Few; It Is For Everyone. We Empower Individuals To Inspire Change And Lead With Intention.
                    </p>
                </div>

                <!-- Integrity -->
                <div class="bg-black rounded-lg p-6 border border-gray-700 text-center">
                    <div class="bg-yellow-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Integrity</h3>
                    <p class="text-gray-300 text-sm">
                        Our Actions Are Built On Honesty And Transparency, Earning Us Trust Through Consistent Integrity.
                    </p>
                </div>
            </div>

            <!-- Second Row: 2 Cards Centered -->
            <div class="flex justify-center">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 sm:gap-8 max-w-3xl">
                    <!-- Mutual Respect -->
                    <div class="bg-black rounded-lg p-6 border border-gray-700 text-center">
                        <div class="bg-yellow-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7 8H17M7 8C4.79086 8 3 9.79086 3 12V17C3 19.2091 4.79086 21 7 21H8C10.2091 21 12 19.2091 12 17V12C12 9.79086 10.2091 8 8 8H7ZM7 8V7C7 4.79086 8.79086 3 11 3H12M17 8C19.2091 8 21 9.79086 21 12V17C21 19.2091 19.2091 21 17 21H16C13.7909 21 12 19.2091 12 17V12C12 9.79086 13.7909 8 16 8H17ZM17 8V7C17 4.79086 15.2091 3 13 3H12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">Mutual Respect</h3>
                        <p class="text-gray-300 text-sm">
                            Fostering mutual respect among diverse cultural groups to promote harmony and collaboration in the African art and culture ecosystem.
                        </p>
                    </div>

                    <!-- Resilience -->
                    <div class="bg-black rounded-lg p-6 border border-gray-700 text-center">
                        <div class="bg-red-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">Resilience</h3>
                        <p class="text-gray-300 text-sm">
                            Challenges Are Opportunities For Growth, So We Face Them Head-On While Staying Focused On Our Mission.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our People Section -->
    <section id="our-people" class="py-12 sm:py-16 bg-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8 sm:mb-12">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-3 sm:mb-4 px-4">Our People</h2>
                {{-- <p class="text-base sm:text-lg text-gray-300 max-w-3xl mx-auto px-4">
                    Meet the dedicated individuals who drive our mission forward through their expertise, passion, and commitment to African cultural preservation.
                </p> --}}
            </div>

            <!-- Board of Directors -->
            <div class="mb-12 sm:mb-16">
                <div class="text-center mb-8">
                    <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-2">Board of Directors</h3>
                    <p class="text-gray-300">Strategic leadership guiding our foundation's vision and governance.</p>
                </div>
                
                <!-- Unified Slider for Both Mobile and Desktop -->
                <x-people-carousel>
                    <div class="flex gap-4 lg:gap-6">
                        <!-- Board Member 1 -->
                        <div class="flex-shrink-0 w-64 lg:w-72 bg-black rounded-lg overflow-hidden shadow-lg border border-gray-700 group">
                            <div class="h-80 bg-cover bg-no-repeat relative overflow-hidden" style="background-image: url('https://res.cloudinary.com/dgsctl247/image/upload/v1760006193/michelle_gwfazs.jpg'); background-position: center 30%;">
                                <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                                
                                <!-- Bio Overlay - Only covers image area -->
                                <div class="absolute inset-0 bg-orange-600 bg-opacity-70 transform translate-y-full group-hover:translate-y-0 transition-all duration-500 ease-in-out flex items-center justify-center p-6">
                                    <div class="text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 delay-200">
                                        <h4 class="text-lg font-bold text-white mb-3">Michele Trimarchi</h4>
                                        <p class="text-sm text-white leading-relaxed text-justify">
                                            Michele Trimarchi, Ph.D., is professor of Public Economics (Magna Graecia Catanzaro), teaches Cultural Economics (IUAV Venice) and Arts Management (IED Florence). He has extensively published on cultural economics and policy.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 lg:p-4">
                                <h4 class="text-base lg:text-lg font-semibold text-white mb-1">Michele Trimarchi</h4>
                                {{-- <p class="text-orange-400 text-xs font-medium mb-2">Chairman, Board of Directors</p> --}}
                               
                                 <div class="flex space-x-2">
                                    <a href="https://www.linkedin.com/in/michele-trimarchi-5767776/" target="_blank" rel="noopener noreferrer" class="text-blue-400 hover:text-blue-300 relative z-10">
                                        <svg class="w-4 h-4 lg:w-5 lg:h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                        </svg>
                                    </a>
                                 </div>
                            </div>
                        </div>

                        <!-- Board Member 2 -->
                        <div class="flex-shrink-0 w-64 lg:w-72 bg-black rounded-lg overflow-hidden shadow-lg border border-gray-700 group">
                            <div class="h-80 bg-cover bg-center bg-no-repeat relative overflow-hidden" style="background-image: url('https://res.cloudinary.com/dgsctl247/image/upload/e_grayscale/v1760006191/aisha_vx2ose.jpg')">
                                <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                                
                                <!-- Bio Overlay - Only covers image area -->
                                <div class="absolute inset-0 bg-orange-600 bg-opacity-70 transform translate-y-full group-hover:translate-y-0 transition-all duration-500 ease-in-out flex items-center justify-center p-6">
                                    <div class="text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 delay-200">
                                        <h4 class="text-lg font-bold text-white mb-3">Aisha Aliyu-Bima</h4>
                                        <p class="text-sm text-white leading-relaxed text-justify">
                                            Writer, curator, photographer, researcher, and archivist with a keen interest in Northern Nigerian Social Anthropology.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 lg:p-4">
                                <h4 class="text-base lg:text-lg font-semibold text-white mb-1">Aisha Aliyu-Bima</h4>
                                {{-- <p class="text-orange-400 text-xs font-medium mb-2">Vice Chairman</p> --}}
                                <div class="flex space-x-2">
                                    <a href="https://www.linkedin.com/in/aisha-aliyu-bima-696a83287/" target="_blank" rel="noopener noreferrer" class="text-blue-400 hover:text-blue-300">
                                        <svg class="w-4 h-4 lg:w-5 lg:h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Board Member 3 -->
                        
                        <div class="flex-shrink-0 w-64 lg:w-72 bg-black rounded-lg overflow-hidden shadow-lg border border-gray-700 group">
                            <div class="h-80 bg-cover bg-center bg-no-repeat relative overflow-hidden" style="background-image: url('https://res.cloudinary.com/dgsctl247/image/upload/v1760006191/victor_oq8f8u.jpg')">
                                <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                                
                                <!-- Bio Overlay - Only covers image area -->
                                <div class="absolute inset-0 bg-orange-600 bg-opacity-70 transform translate-y-full group-hover:translate-y-0 transition-all duration-500 ease-in-out flex items-center justify-center p-6">
                                    <div class="text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 delay-200">
                                        <h4 class="text-lg font-bold text-white mb-3">Victor Ekpuk</h4>
                                        <p class="text-sm text-white leading-relaxed text-justify">
                                            Victor Ekpuk is an internationally renowned Nigerian-American artist based in Washington, D.C. His paintings, drawings, and sculptures reimagine the aesthetics of ancient Nigerian graphic communication system.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 lg:p-4">
                                <h4 class="text-base lg:text-lg font-semibold text-white mb-1">Victor Ekpuk</h4>
                                {{-- <p class="text-orange-400 text-xs font-medium mb-2">Board Member</p> --}}
                                <div class="flex space-x-2">
                                    <a href="https://www.linkedin.com/in/victorekpuk/" target="_blank" rel="noopener noreferrer" class="text-blue-400 hover:text-blue-300">
                                        <svg class="w-4 h-4 lg:w-5 lg:h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                   
                        <!-- Board Member 4 -->
                        
                        <div class="flex-shrink-0 w-64 lg:w-72 bg-black rounded-lg overflow-hidden shadow-lg border border-gray-700 group">
                            <div class="h-80 bg-cover bg-center bg-no-repeat relative overflow-hidden" style="background-image: url('https://res.cloudinary.com/dgsctl247/image/upload/e_grayscale/v1760006190/clive_v1qr7l.jpg')">
                                <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                                
                                <!-- Bio Overlay - Only covers image area -->
                                <div class="absolute inset-0 bg-orange-600 bg-opacity-70 transform translate-y-full group-hover:translate-y-0 transition-all duration-500 ease-in-out flex items-center justify-center p-6">
                                    <div class="text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 delay-200">
                                        <h4 class="text-lg font-bold text-white mb-3">Clive Allanso</h4>
                                        <p class="text-sm text-white leading-relaxed text-justify">
                                            Experienced business consultant with a demonstrated history of working on change and efficiency savings in the health wellness and fitness industry.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 lg:p-4">
                                <h4 class="text-base lg:text-lg font-semibold text-white mb-1">Clive Allanso</h4>
                                {{-- <p class="text-orange-400 text-xs font-medium mb-2">Board Member</p> --}}
                                <div class="flex space-x-2">
                                    <a href="https://www.linkedin.com/in/cliveallanso/" target="_blank" rel="noopener noreferrer" class="text-blue-400 hover:text-blue-300">
                                        <svg class="w-4 h-4 lg:w-5 lg:h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                   
                        <!-- Board Member 5 -->
                        
                        <div class="flex-shrink-0 w-64 lg:w-72 bg-black rounded-lg overflow-hidden shadow-lg border border-gray-700 group">
                            <div class="h-80 bg-cover bg-center bg-no-repeat relative overflow-hidden" style="background-image: url('https://res.cloudinary.com/dgsctl247/image/upload/e_grayscale/v1779528711/olivia_djwsr6.jpg')">
                                <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                                
                                <!-- Bio Overlay - Only covers image area -->
                                <div class="absolute inset-0 bg-orange-600 bg-opacity-70 transform translate-y-full group-hover:translate-y-0 transition-all duration-500 ease-in-out flex items-center justify-center p-6">
                                    <div class="text-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 delay-200">
                                        <h4 class="text-lg font-bold text-white mb-3">Olivia Umoren Ezeuko</h4>
                                        <p class="text-sm text-white leading-relaxed text-justify">
                                            Olivia is a Federal Government Affairs Director in Washington, DC where she develops and maintains relationships with federal agencies and Congressional offices and directs efforts
                                             to influence aging and health policy. Established in 2017, also the creator of Kaa Di Culture, an Instagram platform and initiative dedicated to preserving Akwa Ibom and Cross River
                                              culture, language, and history. 
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 lg:p-4">
                                <h4 class="text-base lg:text-lg font-semibold text-white mb-1">Olivia Umoren Ezeuko</h4>
                                {{-- <p class="text-orange-400 text-xs font-medium mb-2">Board Member</p> --}}
                                <div class="flex space-x-2">
                                    <a href="https://www.linkedin.com/in/oliviaumoren/" target="_blank" rel="noopener noreferrer" class="text-blue-400 hover:text-blue-300">
                                        <svg class="w-4 h-4 lg:w-5 lg:h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                   
                    </div>
                </x-people-carousel>
            </div>

            <!-- Executive Leadership -->
            <div class="mb-12 sm:mb-16">
                <div class="text-center mb-8">
                    <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-2">Executive Leadership</h3>
                    <p class="text-gray-300">Operational leaders driving our day-to-day mission and programs.</p>
                </div>
                
                <!-- Unified Slider for Both Mobile and Desktop -->
                <x-people-carousel>
                    <div class="flex gap-4 lg:gap-6">
                        <!-- Executive 1 -->
                        <div class="flex-shrink-0 w-64 lg:w-72 bg-black rounded-lg overflow-hidden shadow-lg border border-gray-700">
                            <div class="h-80 bg-cover bg-center bg-no-repeat relative" style="background-image: url('https://res.cloudinary.com/dgsctl247/image/upload/v1755792993/people/ccklw0vmqcxzkadpubfs.jpg')">
                                <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                            </div>
                            <div class="p-3 lg:p-4">
                                <h4 class="text-base lg:text-lg font-semibold text-white mb-1">Christopher Udoh</h4>
                                <p class="text-orange-400 text-xs font-medium mb-2">Executive Director</p>
                               
                                {{-- <div class="flex space-x-2">
                                    <a href="#" class="text-blue-400 hover:text-blue-300">
                                        <svg class="w-4 h-4 lg:w-5 lg:h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                        </svg>
                                    </a>
                                </div> --}}
                            </div>
                        </div>

                        <!-- Executive 2 -->
                        <div class="flex-shrink-0 w-64 lg:w-72 bg-black rounded-lg overflow-hidden shadow-lg border border-gray-700">
                            <div class="h-80 bg-cover bg-center bg-no-repeat relative" style="background-image: url('https://res.cloudinary.com/dgsctl247/image/upload/e_grayscale/v1755815846/people/j4jlngk2dsb2tpreaglc.jpg')">
                                <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                            </div>
                            <div class="p-3 lg:p-4">
                                <h4 class="text-base lg:text-lg font-semibold text-white mb-1">Germaine Umanah</h4>
                                <p class="text-orange-400 text-xs font-medium mb-2">Executive Secretary</p>
                               
                                {{-- <div class="flex space-x-2">
                                    <a href="#" class="text-blue-400 hover:text-blue-300">
                                        <svg class="w-4 h-4 lg:w-5 lg:h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                        </svg>
                                    </a>
                                </div> --}}
                            </div>
                        </div>

                        <!-- Executive 3 -->
                        <div class="flex-shrink-0 w-64 lg:w-72 bg-black rounded-lg overflow-hidden shadow-lg border border-gray-700">
                            <div class="h-80 bg-cover bg-center bg-no-repeat relative" style="background-image: url('https://res.cloudinary.com/dgsctl247/image/upload/v1755815538/people/q0izjq5sdziyyys9irdk.jpg')">
                                <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                            </div>
                            <div class="p-3 lg:p-4">
                                <h4 class="text-base lg:text-lg font-semibold text-white mb-1">Ahma Mendie</h4>
                                <p class="text-orange-400 text-xs font-medium mb-2">Director of Communications</p>
                                
                                {{-- <div class="flex space-x-2">
                                    <a href="#" class="text-blue-400 hover:text-blue-300">
                                        <svg class="w-4 h-4 lg:w-5 lg:h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                        </svg>
                                    </a>
                                </div> --}}
                            </div>
                        </div>

                        <!-- Executive 4 -->
                        <div class="flex-shrink-0 w-64 lg:w-72 bg-black rounded-lg overflow-hidden shadow-lg border border-gray-700">
                            <div class="h-80 bg-cover bg-center bg-no-repeat relative" style="background-image: url('https://res.cloudinary.com/dgsctl247/image/upload/e_grayscale/v1755816064/people/siuoi72zjsjfdptqme8n.jpg')">
                                <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                            </div>
                            <div class="p-3 lg:p-4">
                                <h4 class="text-base lg:text-lg font-semibold text-white mb-1">Edikan Udofia</h4>
                                <p class="text-orange-400 text-xs font-medium mb-2">Director of Finance</p>
                                
                                {{-- <div class="flex space-x-2">
                                    <a href="#" class="text-blue-400 hover:text-blue-300">
                                        <svg class="w-4 h-4 lg:w-5 lg:h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                        </svg>
                                    </a>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </x-people-carousel>
            </div>

            <!-- Expert Advisors -->
            <div class="mb-8">
                <div class="text-center mb-8">
                    <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-2">Expert Advisors</h3>
                    <p class="text-gray-300">Specialized consultants providing expertise in various aspects of cultural preservation and artistic development.</p>
                </div>
                
                <!-- Unified Slider for Both Mobile and Desktop -->
                <x-people-carousel>
                    <div class="flex gap-4 lg:gap-6">
                        <!-- Advisor 1 -->
                        <div class="flex-shrink-0 w-64 lg:w-72 bg-black rounded-lg overflow-hidden shadow-lg border border-gray-700">
                            <div class="h-80 bg-cover bg-center bg-no-repeat relative" style="background-image: url('https://res.cloudinary.com/dgsctl247/image/upload/v1760006193/louise_ngc3jc.jpg')">
                                <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                            </div>
                            <div class="p-3 lg:p-4">
                                <h4 class="text-base lg:text-lg font-semibold text-white mb-1">Louise Rytter</h4>
                                {{-- <p class="text-orange-400 text-xs font-medium mb-2">Cultural Anthropologist</p> --}}
                                
                            </div>
                        </div>
{{-- 
                        <!-- Advisor 2 -->
                        <div class="flex-shrink-0 w-64 lg:w-72 bg-black rounded-lg overflow-hidden shadow-lg border border-gray-700">
                            <div class="h-80 bg-cover bg-center bg-no-repeat relative" style="background-image: url('https://res.cloudinary.com/dgsctl247/image/upload/v1755792253/people/i29nyloiovn9ppmuans7.jpg')">
                                <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                            </div>
                            <div class="p-3 lg:p-4">
                                <h4 class="text-base lg:text-lg font-semibold text-white mb-1">Okon Effiong</h4>
                                <p class="text-orange-400 text-xs font-medium mb-2">Master Craftsman</p>
                                
                            </div>
                        </div>

                        <!-- Advisor 3 -->
                        <div class="flex-shrink-0 w-64 lg:w-72 bg-black rounded-lg overflow-hidden shadow-lg border border-gray-700">
                            <div class="h-80 bg-cover bg-center bg-no-repeat relative" style="background-image: url('https://res.cloudinary.com/dgsctl247/image/upload/v1755792253/people/i29nyloiovn9ppmuans7.jpg')">
                                <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                            </div>
                            <div class="p-3 lg:p-4">
                                <h4 class="text-base lg:text-lg font-semibold text-white mb-1">Nsikak Udoh</h4>
                                <p class="text-orange-400 text-xs font-medium mb-2">Digital Archivist</p>
                                
                            </div>
                        </div>

                        <!-- Advisor 4 -->
                        <div class="flex-shrink-0 w-64 lg:w-72 bg-black rounded-lg overflow-hidden shadow-lg border border-gray-700">
                            <div class="h-80 bg-cover bg-center bg-no-repeat relative" style="background-image: url('https://res.cloudinary.com/dgsctl247/image/upload/v1755792253/people/i29nyloiovn9ppmuans7.jpg')">
                                <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                            </div>
                            <div class="p-3 lg:p-4">
                                <h4 class="text-base lg:text-lg font-semibold text-white mb-1">Arit Okpo</h4>
                                <p class="text-orange-400 text-xs font-medium mb-2">Community Liaison</p>
                                
                            </div>
                        </div> --}}
                    </div>
                </x-people-carousel>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    {{-- <section class="py-12 sm:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-3 sm:mb-4 px-4">
                Join Our Mission
            </h2>
            <p class="text-base sm:text-lg md:text-xl text-gray-300 mb-6 sm:mb-8 max-w-3xl mx-auto px-4">
                Be part of our journey to preserve, promote, and celebrate African art and culture. Together, we can ensure our rich heritage thrives for generations to come.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center px-4">
                <a href="/projects" class="bg-orange-600 text-white px-6 sm:px-8 py-3 rounded-lg font-semibold hover:bg-orange-700 transition duration-300 text-center">
                    View Our Projects
                </a>
                <a href="#" class="border-2 border-white text-white px-6 sm:px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-black transition duration-300 text-center">
                    Get Involved
                </a>
            </div>
        </div>
    </section> --}}

    <!-- Custom CSS for smooth scrolling -->
    <style>
        .scrollbar-hide {
            -ms-overflow-style: none;  /* Internet Explorer 10+ */
            scrollbar-width: none;  /* Firefox */
        }
        .scrollbar-hide::-webkit-scrollbar { 
            display: none;  /* Safari and Chrome */
        }
        
        /* Smooth scrolling behavior */
        .overflow-x-auto {
            scroll-behavior: smooth;
        }
    </style>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('peopleCarousel', () => ({
                canScrollLeft: false,
                canScrollRight: false,
                init() {
                    this.$nextTick(() => {
                        this.updateButtons();
                        window.addEventListener('resize', () => this.updateButtons());
                    });
                },
                scrollNext() {
                    const track = this.$refs.track;
                    if (!track) return;
                    track.scrollBy({ left: this.scrollAmount(track), behavior: 'smooth' });
                    setTimeout(() => this.updateButtons(), 350);
                },
                scrollPrev() {
                    const track = this.$refs.track;
                    if (!track) return;
                    track.scrollBy({ left: -this.scrollAmount(track), behavior: 'smooth' });
                    setTimeout(() => this.updateButtons(), 350);
                },
                scrollAmount(track) {
                    const card = track.querySelector('.flex-shrink-0');
                    const row = track.querySelector('.flex');
                    const gap = row ? parseInt(getComputedStyle(row).gap) || 16 : 16;
                    return card ? card.offsetWidth + gap : 280;
                },
                updateButtons() {
                    const track = this.$refs.track;
                    if (!track) return;
                    const maxScroll = track.scrollWidth - track.clientWidth;
                    this.canScrollLeft = track.scrollLeft > 8;
                    this.canScrollRight = maxScroll > 8 && track.scrollLeft < maxScroll - 8;
                },
            }));
        });
    </script>
</div>
