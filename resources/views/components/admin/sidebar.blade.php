@props(['active' => ''])

@php
    $user = auth()->user();
    $permissions = config('admin_permissions', []);
    $icons = [
        'dashboard' => 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2H3z',
        'projects' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3v3m0 0v3m0-3h3m-3 0h-3',
        'news' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
        'people' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
        'ticket_records' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
        'ticket_checkin' => 'M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z',
        'manage_staff' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
    ];
@endphp

{{-- Mobile Sidebar Overlay --}}
<div x-show="sidebarOpen"
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-30 bg-black bg-opacity-50 lg:hidden"
     @click="sidebarOpen = false"></div>

{{-- Sidebar --}}
<div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
     class="fixed inset-y-0 left-0 z-40 w-64 bg-black border-r border-orange-600 flex flex-col transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0">

    <div class="p-4 border-b border-orange-600">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <img src="https://res.cloudinary.com/dgsctl247/image/upload/v1758843246/aifac_logo_wjjkzk.png"
                     alt="AIFAC Logo"
                     class="h-8 w-8 lg:h-10 lg:w-10 object-contain">
                <div class="ml-3">
                    <h1 class="text-sm lg:text-lg font-bold text-white">Admin Panel</h1>
                    <p class="text-xs text-gray-400 hidden lg:block">AIFAC Dashboard</p>
                </div>
            </div>
            <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-white" type="button">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    <nav class="flex-1 p-2 lg:p-4 space-y-1 lg:space-y-2 overflow-y-auto">
        @foreach ($permissions as $key => $item)
            @if ($user->hasPermission($key))
                @php
                    $isActive = $active === $key;
                    $linkClass = $isActive
                        ? 'flex items-center px-3 lg:px-4 py-2 lg:py-3 text-white bg-orange-600 rounded-lg'
                        : 'flex items-center px-3 lg:px-4 py-2 lg:py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition duration-200';
                @endphp
                <a href="{{ $item['path'] }}"
                   @click="sidebarOpen = false"
                   class="{{ $linkClass }}">
                    @if (isset($icons[$key]))
                        <svg class="h-4 w-4 lg:h-5 lg:w-5 mr-2 lg:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icons[$key] }}"></path>
                        </svg>
                    @endif
                    <span class="text-sm lg:text-base">{{ $item['label'] }}</span>
                </a>
            @endif
        @endforeach

        <div class="border-t border-orange-600 my-2 lg:my-4"></div>

        <a href="/admin/profile"
           @click="sidebarOpen = false"
           class="{{ $active === 'profile'
                ? 'flex items-center px-3 lg:px-4 py-2 lg:py-3 text-white bg-orange-600 rounded-lg'
                : 'flex items-center px-3 lg:px-4 py-2 lg:py-3 text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition duration-200' }}">
            <svg class="h-4 w-4 lg:h-5 lg:w-5 mr-2 lg:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="text-sm lg:text-base">My Profile</span>
        </a>
    </nav>

    <div class="p-2 lg:p-4 border-t border-orange-600">
        <div class="flex items-center justify-between">
            <div class="flex items-center min-w-0 flex-1">
                <div class="bg-orange-600 p-2 rounded-full flex-shrink-0">
                    <svg class="h-3 w-3 lg:h-4 lg:w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div class="ml-2 lg:ml-3 min-w-0 flex-1">
                    <p class="text-xs lg:text-sm font-medium text-white truncate">{{ $user->name }}</p>
                    <p class="text-xs text-gray-400 hidden lg:block">{{ $user->roleLabel() }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}" class="inline ml-2">
                @csrf
                <button type="submit"
                        class="text-gray-400 hover:text-red-400 transition duration-200 p-1"
                        title="Logout">
                    <svg class="h-4 w-4 lg:h-5 lg:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>
