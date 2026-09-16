<div class="min-h-screen bg-black flex" x-data="{ sidebarOpen: false }">
    <x-admin.sidebar active="dashboard" />

<!-- Main Content -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- Top Header -->
        <header class="bg-black shadow-lg border-b border-orange-600 px-4 lg:px-6 py-3 lg:py-4">
            <div class="flex justify-between items-center">
                <!-- Mobile menu button -->
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" 
                            class="lg:hidden text-gray-400 hover:text-white mr-3">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    
                    <div>
                        <h1 class="text-xl lg:text-2xl font-bold text-white">Dashboard</h1>
                        <p class="text-gray-400 text-sm lg:text-base hidden sm:block">Welcome back, {{ auth()->user()->name }}!</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-2 lg:space-x-4">
                    <a href="/" target="_blank" 
                       class="bg-orange-600 hover:bg-orange-700 text-white px-3 lg:px-4 py-2 rounded-lg transition duration-200 flex items-center text-sm lg:text-base">
                        <svg class="h-4 w-4 mr-1 lg:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        <span class="hidden sm:inline">View Website</span>
                        <span class="sm:hidden">Website</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Dashboard Content -->
        <main class="flex-1 p-4 lg:p-6 overflow-y-auto">
            <!-- Welcome Card -->
            <div class="bg-black rounded-lg border border-orange-600 p-4 lg:p-6 mb-6 lg:mb-8">
                <h2 class="text-xl lg:text-2xl font-bold text-white mb-2">
                    🎉 Welcome to the Admin Panel!
                </h2>
                <p class="text-gray-300 text-sm lg:text-base">
                    You have successfully logged into the Anyen Iyak Foundation admin dashboard. 
                    From here, you can manage the foundation's content, projects, news, people, staff, and more.
                </p>
            </div>

            <!-- Summit Ticket Glance -->
            <a href="/admin/ticket-records" class="block bg-black rounded-lg border border-orange-600 p-4 lg:p-6 mb-6 lg:mb-8 hover:border-orange-400 transition duration-200">
                <div class="flex items-center justify-between gap-3 mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-white">GBSAAC 2026 Tickets</h3>
                        <p class="text-sm text-gray-400">View purchases, check-ins, and export records</p>
                    </div>
                    <span class="text-orange-400 text-sm whitespace-nowrap">Open records →</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <p class="text-xs text-gray-400">Sold</p>
                        <p class="text-2xl font-bold text-white">{{ $ticketsSold }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Checked in</p>
                        <p class="text-2xl font-bold text-white">{{ $ticketsCheckedIn }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Revenue</p>
                        <p class="text-2xl font-bold text-white">₦{{ number_format($ticketRevenue, 0) }}</p>
                    </div>
                </div>
            </a>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4 lg:gap-6 mb-6 lg:mb-8">
                <div class="bg-black rounded-lg border border-orange-600 p-4 lg:p-6">
                    <div class="flex items-center">
                        <div class="bg-orange-600 p-2 lg:p-3 rounded-full">
                            <svg class="h-5 w-5 lg:h-6 lg:w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="ml-3 lg:ml-4">
                            <p class="text-xs lg:text-sm font-medium text-gray-400">Total Staff</p>
                            <p class="text-lg lg:text-2xl font-bold text-white">{{ \App\Models\User::count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-black rounded-lg border border-orange-600 p-4 lg:p-6">
                    <div class="flex items-center">
                        <div class="bg-blue-600 p-2 lg:p-3 rounded-full">
                            <svg class="h-5 w-5 lg:h-6 lg:w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3v3m0 0v3m0-3h3m-3 0h-3"></path>
                            </svg>
                        </div>
                        <div class="ml-3 lg:ml-4">
                            <p class="text-xs lg:text-sm font-medium text-gray-400">Projects</p>
                            <p class="text-lg lg:text-2xl font-bold text-white">{{ \App\Models\Project::count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-black rounded-lg border border-orange-600 p-4 lg:p-6">
                    <div class="flex items-center">
                        <div class="bg-green-600 p-2 lg:p-3 rounded-full">
                            <svg class="h-5 w-5 lg:h-6 lg:w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-3 lg:ml-4">
                            <p class="text-xs lg:text-sm font-medium text-gray-400">News Articles</p>
                            <p class="text-lg lg:text-2xl font-bold text-white">{{ \App\Models\News::count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-black rounded-lg border border-orange-600 p-4 lg:p-6">
                    <div class="flex items-center">
                        <div class="bg-purple-600 p-2 lg:p-3 rounded-full">
                            <svg class="h-5 w-5 lg:h-6 lg:w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3 lg:ml-4">
                            <p class="text-xs lg:text-sm font-medium text-gray-400">People</p>
                            <p class="text-lg lg:text-2xl font-bold text-white">{{ \App\Models\Person::count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-black rounded-lg border border-orange-600 p-4 lg:p-6 sm:col-span-2 lg:col-span-1">
                    <div class="flex items-center">
                        <div class="bg-red-600 p-2 lg:p-3 rounded-full">
                            <svg class="h-5 w-5 lg:h-6 lg:w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3 lg:ml-4">
                            <p class="text-xs lg:text-sm font-medium text-gray-400">Donations</p>
                            <p class="text-lg lg:text-2xl font-bold text-white">{{ \App\Models\Donation::count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-black rounded-lg border border-orange-600 p-4 lg:p-6">
                <h3 class="text-lg font-bold text-white mb-4">Quick Actions</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 lg:gap-4">
                    <a href="/admin/projects" class="bg-orange-600 hover:bg-orange-700 text-white p-3 lg:p-4 rounded-lg text-center transition duration-200">
                        <svg class="h-6 w-6 lg:h-8 lg:w-8 mx-auto mb-1 lg:mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span class="text-xs lg:text-sm font-medium">Add Project</span>
                    </a>
                    
                    <a href="/admin/news" class="bg-blue-600 hover:bg-blue-700 text-white p-3 lg:p-4 rounded-lg text-center transition duration-200">
                        <svg class="h-6 w-6 lg:h-8 lg:w-8 mx-auto mb-1 lg:mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="text-xs lg:text-sm font-medium">Add News</span>
                    </a>
                    
                    <a href="/admin/people" class="bg-green-600 hover:bg-green-700 text-white p-3 lg:p-4 rounded-lg text-center transition duration-200">
                        <svg class="h-6 w-6 lg:h-8 lg:w-8 mx-auto mb-1 lg:mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span class="text-xs lg:text-sm font-medium">Add People</span>
                    </a>
                    
                    <a href="/admin/ticket-records" class="bg-orange-600 hover:bg-orange-700 text-white p-3 lg:p-4 rounded-lg text-center transition duration-200">
                        <svg class="h-6 w-6 lg:h-8 lg:w-8 mx-auto mb-1 lg:mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="text-xs lg:text-sm font-medium">Ticket Records</span>
                    </a>

                    <a href="/admin/tickets" class="bg-blue-600 hover:bg-blue-700 text-white p-3 lg:p-4 rounded-lg text-center transition duration-200">
                        <svg class="h-6 w-6 lg:h-8 lg:w-8 mx-auto mb-1 lg:mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                        </svg>
                        <span class="text-xs lg:text-sm font-medium">Ticket Check-In</span>
                    </a>
                    
                  
                </div>
            </div>
        </main>
    </div>
</div> 