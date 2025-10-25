<div class="min-h-screen bg-black py-12 flex items-center justify-center">
    <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Failed Icon -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-red-600 rounded-full mb-4">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">Payment Failed</h1>
            <p class="text-gray-300">
                @if(session('error'))
                    {{ session('error') }}
                @else
                    Unfortunately, your payment could not be processed.
                @endif
            </p>
        </div>

        <!-- Error Details -->
        <div class="bg-black border border-red-600 rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold text-white mb-4">What happened?</h2>
            <ul class="space-y-2 text-gray-300">
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-red-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <circle cx="10" cy="10" r="8"/>
                    </svg>
                    <span>The payment was not completed</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-red-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <circle cx="10" cy="10" r="8"/>
                    </svg>
                    <span>No charges were made to your account</span>
                </li>
            </ul>
        </div>

        <!-- Actions -->
        <div class="flex flex-col space-y-3">
            <a href="/" class="px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white rounded-lg transition-colors font-medium text-center">
                Return to Home
            </a>
            <button onclick="window.history.back()" class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-colors font-medium">
                Try Again
            </button>
        </div>

        <!-- Support -->
        <div class="mt-8 text-center">
            <p class="text-sm text-gray-400">
                Need help? 
                <a href="/about" class="text-orange-500 hover:text-orange-400">Contact Support</a>
            </p>
        </div>
    </div>
</div>

