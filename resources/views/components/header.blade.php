<header class="bg-black shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-24">
            <!-- Logo Section -->
            <div class="flex-shrink-0 flex items-center">
                <a href="/" class="flex items-center">
                    <!-- Logo placeholder - replace with actual logo -->
                    <img src="https://res.cloudinary.com/dgsctl247/image/upload/v1758843914/aifac_logo_nloews.png" alt="Anyen Iyak Foundation Logo" class="h-24 w-24 md:h-28 md:w-28 object-contain transition-transform hover:scale-105 border-0">
                    {{-- <span class="ml-4 text-xl md:text-2xl font-bold text-white hidden sm:block">{{ config('app.name', 'LiveWire') }}</span> --}}
                </a>
            </div>

            <!-- Desktop Navigation and Donate Button -->
            <div class="hidden md:flex items-center">
                <!-- Navigation Links -->
                <nav class="flex space-x-8 mr-6">
                    <a href="/about" class="text-gray-300 hover:text-orange-400 px-3 py-2 rounded-md text-sm font-medium transition duration-150">
                        About
                    </a>
                    <a href="/projects" class="text-gray-300 hover:text-orange-400 px-3 py-2 rounded-md text-sm font-medium transition duration-150">
                        Projects
                    </a>
                    {{-- <a href="/news" class="text-gray-300 hover:text-orange-400 px-3 py-2 rounded-md text-sm font-medium transition duration-150">
                        News
                    </a> --}}
                    {{-- <a href="/people" class="text-gray-300 hover:text-orange-400 px-3 py-2 rounded-md text-sm font-medium transition duration-150">
                        People
                    </a>
                    <a href="/membership" class="text-gray-300 hover:text-orange-400 px-3 py-2 rounded-md text-sm font-medium transition duration-150">
                        Membership
                    </a> --}}
                </nav>
                
                <!-- Donate Button - Close to Right Edge -->
                {{-- <button onclick="openDonationTypeModal()" class="bg-orange-600 hover:bg-orange-700 text-black px-6 py-2 rounded-md text-sm font-bold transition duration-150">
                    DONATE
                </button> --}}
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button type="button" class="mobile-menu-button text-orange-600 hover:text-orange-600 focus:outline-none focus:text-orange-600" aria-label="Toggle menu">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path class="menu-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path class="close-icon hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div class="mobile-menu hidden md:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 bg-black border-t border-gray-700">
                <a href="/about" class="text-gray-300 hover:text-blue-400 block px-3 py-2 rounded-md text-base font-medium">
                    About
                </a>
                <a href="/projects" class="text-gray-300 hover:text-blue-400 block px-3 py-2 rounded-md text-base font-medium">
                    Projects
                </a>
                {{-- <a href="/news" class="text-gray-300 hover:text-blue-400 block px-3 py-2 rounded-md text-base font-medium">
                    News
                </a> --}}
                {{-- <a href="/people" class="text-gray-300 hover:text-blue-400 block px-3 py-2 rounded-md text-base font-medium">
                    People
                </a> --}}
                {{-- <a href="/membership" class="text-gray-300 hover:text-blue-400 block px-3 py-2 rounded-md text-base font-medium">
                    Membership
                </a> --}}
                {{-- <button onclick="openDonationTypeModal()" class="bg-orange-600 text-black block px-3 py-2 rounded-md text-base font-medium w-full text-left">
                    Donate
                </button> --}}
            </div>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.querySelector('.mobile-menu-button');
        const mobileMenu = document.querySelector('.mobile-menu');
        const menuIcon = document.querySelector('.menu-icon');
        const closeIcon = document.querySelector('.close-icon');

        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
            menuIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        });
    });
</script> 