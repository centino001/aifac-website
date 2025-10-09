<div class="min-h-screen flex items-center justify-center bg-black py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <div class="flex justify-center mb-6">
                <img src="https://res.cloudinary.com/dgsctl247/image/upload/v1758843246/aifac_logo_wjjkzk.png" 
                     alt="Anyen Iyak Foundation Logo" 
                     class="h-20 w-20 object-contain">
            </div>
            <h2 class="text-3xl font-bold text-white">
                Admin Portal
            </h2>
            <p class="mt-2 text-sm text-gray-400">
                Anyen Iyak Foundation of Art and Culture
            </p>
        </div>

        <!-- Login Form -->
        <div class="bg-black rounded-xl shadow-2xl p-8 border border-orange-600">
            <form wire:submit="login" class="space-y-6">
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                        Email Address
                    </label>
                    <input wire:model="email" 
                           type="email" 
                           id="email"
                           autocomplete="email" 
                           required
                           class="w-full px-3 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition duration-200"
                           placeholder="admin@anyeniyakfoundation.org">
                    @error('email') 
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p> 
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-2">
                        Password
                    </label>
                    <input wire:model="password" 
                           type="password" 
                           id="password"
                           autocomplete="current-password" 
                           required
                           class="w-full px-3 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition duration-200"
                           placeholder="Enter your password">
                    @error('password') 
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p> 
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input wire:model="remember" 
                               id="remember" 
                               type="checkbox" 
                               class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-600 bg-gray-700 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-300">
                            Remember me
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" 
                            wire:loading.attr="disabled"
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 disabled:opacity-50 disabled:cursor-not-allowed transition duration-200 transform hover:scale-105">
                        <span wire:loading.remove class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Sign in to Admin Portal
                        </span>
                        <span wire:loading class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Signing in...
                        </span>
                    </button>
                </div>
            </form>

            <!-- Footer Links -->
            <div class="mt-6 text-center">
                <a href="/" class="text-sm text-gray-400 hover:text-orange-400 transition duration-200">
                    ← Back to Main Website
                </a>
            </div>
        </div>

        <!-- Security Notice -->
        <div class="text-center">
            <p class="text-xs text-gray-500">
                🔒 This is a secure admin area. Only authorized personnel allowed.
            </p>
        </div>
    </div>
</div> 