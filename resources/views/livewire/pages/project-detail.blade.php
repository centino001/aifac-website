<div>
    <!-- Hero Section -->
    <section class="relative py-16 sm:py-24 bg-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="mb-8">
                <ol class="flex items-center space-x-2 text-sm">
                    <li><a href="/" class="text-gray-400 hover:text-white transition duration-150">Home</a></li>
                    <li class="text-gray-400">/</li>
                    <li><a href="/projects" class="text-gray-400 hover:text-white transition duration-150">Projects</a></li>
                    <li class="text-gray-400">/</li>
                    <li class="text-white font-medium">{{ $project->name }}</li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                <!-- Project Image -->
                <div class="order-2 lg:order-1">
                    <div class="relative rounded-lg overflow-hidden shadow-2xl">
                        <img src="{{ $project->image }}" alt="{{ $project->name }}" 
                             class="w-full h-64 sm:h-80 lg:h-96 object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        <div class="absolute bottom-4 left-4">
                            <span class="bg-orange-600 text-white px-3 py-1 rounded-full text-sm font-medium">
                                {{ $project->category }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Project Info -->
                <div class="order-1 lg:order-2">
                    <div class="mb-6">
                        {{-- <span class="inline-block bg-green-600 text-white px-3 py-1 rounded-full text-sm font-medium mb-4">
                            Status: {{ $project->status }}
                        </span> --}}
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-4">
                            {{ $project->name }}
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Project Details Section -->
    <section class="py-16 bg-black">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-black rounded-lg p-6 sm:p-8 border border-gray-700">
                <h2 class="text-2xl sm:text-3xl font-bold text-white mb-6">Project Overview</h2>
                <div class="prose prose-lg prose-invert max-w-none">
                    <p class="text-gray-300 leading-relaxed text-base sm:text-lg">
                        {{ $project->description }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    {{-- <section class="py-16 bg-black">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl sm:text-3xl font-bold text-white mb-4">Support This Project</h2>
            <p class="text-gray-300 mb-8 text-base sm:text-lg">
                Help us preserve and promote Akwa Ibom's cultural heritage through storytelling.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button onclick="openDonationTypeModal()" 
                        class="bg-orange-600 hover:bg-orange-700 text-white px-8 py-3 rounded-lg font-semibold transition duration-300">
                    Make a Donation
                </button>
                <a href="/projects" 
                   class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-black transition duration-300">
                    View All Projects
                </a>
            </div>
        </div>
    </section> --}}
</div>
