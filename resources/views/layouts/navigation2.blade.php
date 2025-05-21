@php
    $unreadNotificationsCount = auth()->check() ? auth()->user()->notifications()->whereNull('read_at')->count() : 0;
@endphp

<nav x-data="{ open: false }" class="bg-[#213448] sticky top-0 left-0 right-0 z-50 shadow-md">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <x-application-logo class="block h-8 w-auto fill-current text-white" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-6 sm:-my-px sm:ml-8 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')" class="text-white hover:text-gray-200 transition-colors duration-200">
                        Beranda
                    </x-nav-link>
                    @auth
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:text-gray-200 transition-colors duration-200">
                            Menu
                        </x-nav-link>
                        <x-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.index')" class="text-white hover:text-gray-200 transition-colors duration-200 relative">
                            <div class="flex items-center">
                                <span>Notifikasi</span>
                                @if($unreadNotificationsCount > 0)
                                    <span class="ml-1.5 inline-flex items-center justify-center h-5 w-5 rounded-full bg-red-500 text-xs font-medium text-white">
                                        {{ $unreadNotificationsCount }}
                                    </span>
                                @endif
                            </div>
                        </x-nav-link>
                        @if(auth()->user()->isCourier())
                        <x-nav-link :href="route('courier2')" :active="request()->routeIs('courier2')" class="text-white hover:text-gray-200 transition-colors duration-200 relative">
                            <div class="flex items-center">
                                <span>Antarkan Pesanan</span>
                                @if(isset($pendingOrdersCount) && $pendingOrdersCount > 0)
                                    <span class="ml-1.5 inline-flex items-center justify-center h-5 w-5 rounded-full bg-red-500 text-xs font-medium text-white">
                                        {{ $pendingOrdersCount }}
                                    </span>
                                @endif
                            </div>
                        </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            @auth
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <x-dropdown align="right" width="56">
                        <x-slot name="trigger">
                            <button class="flex items-center space-x-2 text-sm transition-colors duration-200 focus:outline-none">
                                <div class="flex items-center">
                                    <!-- Profile Photo or Initial -->
                                    @if(Auth::user()->profile_photo)
                                        <img src="{{ Storage::url(Auth::user()->profile_photo) }}" alt="{{ Auth::user()->name }}" class="h-8 w-8 rounded-full object-cover">
                                    @else
                                        <div class="h-8 w-8 rounded-full bg-white flex items-center justify-center text-[#213448] font-medium">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- User Info -->
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ ucfirst(Auth::user()->role) }}</p>
                            </div>
                            
                            <!-- Menu Items -->
                            <div class="py-1">
                                <x-dropdown-link :href="route('profile.show', Auth::user())" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Profil Saya
                                </x-dropdown-link>
                                
                                <x-dropdown-link :href="route('profile.edit')" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-150 pl-10">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit Profil
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('orders.history')" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    Riwayat Pesanan
                                </x-dropdown-link>

                                <!-- Settings -->
                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-150">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Keluar
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>
            @else
                <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-3">
                    <a href="{{ route('seller.login') }}" class="rounded-lg border border-white px-4 py-2 text-sm font-medium text-white transition duration-300 hover:bg-white hover:bg-opacity-10 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-50">
                        Daftar
                    </a>
                    <a href="{{ route('login') }}" class="rounded-lg bg-white px-4 py-2 text-sm font-medium text-[#213448] transition duration-300 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-50">
                        Masuk
                    </a>
                </div>
            @endauth

            <!-- Mobile menu button -->
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-200 hover:text-white hover:bg-white hover:bg-opacity-10 focus:outline-none focus:bg-white focus:bg-opacity-10 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white shadow-lg">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')" class="text-gray-900 hover:bg-gray-100">
                Beranda
            </x-responsive-nav-link>
            @auth
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-gray-900 hover:bg-gray-100">
                    Menu
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.index')" class="text-gray-900 hover:bg-gray-100 relative">
                    <div class="flex items-center">
                        <span>Notifikasi</span>
                        @if($unreadNotificationsCount > 0)
                            <span class="ml-2 inline-flex items-center justify-center h-5 w-5 rounded-full bg-red-500 text-xs font-medium text-white">
                                {{ $unreadNotificationsCount }}
                            </span>
                        @endif
                    </div>
                </x-responsive-nav-link>
                @if(auth()->user()->isCourier())
                <x-responsive-nav-link :href="route('courier2')" :active="request()->routeIs('courier2')" class="text-gray-900 hover:bg-gray-100 relative">
                    <div class="flex items-center">
                        <span>Antarkan Pesanan</span>
                        @if(isset($pendingOrdersCount) && $pendingOrdersCount > 0)
                            <span class="ml-2 inline-flex items-center justify-center h-5 w-5 rounded-full bg-red-500 text-xs font-medium text-white">
                                {{ $pendingOrdersCount }}
                            </span>
                        @endif
                    </div>
                </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4 flex items-center space-x-3">
                    @if(Auth::user()->profile_photo)
                        <img src="{{ Storage::url(Auth::user()->profile_photo) }}" alt="{{ Auth::user()->name }}" class="h-10 w-10 rounded-full object-cover">
                    @else
                        <div class="h-10 w-10 rounded-full bg-[#213448] flex items-center justify-center text-white font-medium">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ ucfirst(Auth::user()->role) }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.show', Auth::user())" class="text-gray-700 hover:bg-gray-100">
                        Profil Saya
                    </x-responsive-nav-link>
                    
                    <x-responsive-nav-link :href="route('profile.edit')" class="text-gray-700 hover:bg-gray-100 pl-10">
                        Edit Profil
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('orders.history')" class="text-gray-700 hover:bg-gray-100">
                        Riwayat Pesanan
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-gray-700 hover:bg-gray-100">
                            Keluar
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="space-y-2 px-4">
                    <x-responsive-nav-link :href="route('seller.login')" class="block w-full text-center py-2 border border-[#213448] text-[#213448] rounded-lg hover:bg-[#213448] hover:text-white transition-colors duration-200">
                        Daftar
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('login')" class="block w-full text-center py-2 bg-[#213448] text-white rounded-lg hover:bg-opacity-90 transition-colors duration-200">
                        Masuk
                    </x-responsive-nav-link>
                </div>
            </div>
        @endauth
    </div>
</nav>
