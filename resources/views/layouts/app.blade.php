<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'AutoMarket') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Additional scripts -->
        @stack('scripts')
        
        <!-- Additional styles -->
        @stack('styles')
        
        <style>
            /* Добавяме временни стилове за примерни изображения (докато не качим истински) */
            .placeholder-image {
                position: relative;
                overflow: hidden;
                background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            }
            
            .placeholder-image::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 50%;
                height: 100%;
                background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.3) 50%, rgba(255,255,255,0) 100%);
                animation: shimmer 2s infinite;
            }
            
            @keyframes shimmer {
                100% { left: 150%; }
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <nav x-data="{ open: false, userDropdown: false }" class="bg-white shadow-md">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <a href="{{ route('home') }}" class="flex items-center">
                                    <x-application-logo class="block h-10 w-auto fill-current text-blue-600" />
                                    <span class="text-xl font-bold ml-2 text-gray-800">AutoMarket</span>
                                </a>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-1 sm:ms-10 sm:flex">
                                <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 border-b-2 {{ request()->routeIs('home') ? 'border-blue-500 text-blue-600' : 'border-transparent hover:border-gray-300 text-gray-600 hover:text-gray-800' }} text-sm font-medium transition-all duration-150 ease-in-out">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    Home
                                </a>
                                <a href="{{ route('cars.index') }}" class="inline-flex items-center px-4 py-2 border-b-2 {{ request()->routeIs('cars.index') ? 'border-blue-500 text-blue-600' : 'border-transparent hover:border-gray-300 text-gray-600 hover:text-gray-800' }} text-sm font-medium transition-all duration-150 ease-in-out">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                    </svg>
                                    Cars
                                </a>
                                <a href="{{ route('dealers.index') }}" class="inline-flex items-center px-4 py-2 border-b-2 {{ request()->routeIs('dealers.index') ? 'border-blue-500 text-blue-600' : 'border-transparent hover:border-gray-300 text-gray-600 hover:text-gray-800' }} text-sm font-medium transition-all duration-150 ease-in-out">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    Dealerships
                                </a>
                                @auth
                                    <a href="{{ route('cars.create') }}" class="inline-flex items-center px-4 py-2 border-b-2 {{ request()->routeIs('cars.create') ? 'border-blue-500 text-blue-600' : 'border-transparent hover:border-gray-300 text-gray-600 hover:text-gray-800' }} text-sm font-medium transition-all duration-150 ease-in-out">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Post Car
                                    </a>
                                @endauth
                            </div>
                        </div>

                        <!-- Settings Dropdown -->
                        <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-2">
                            @auth
                                <a href="{{ route('favorites.index') }}" class="relative p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-full transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </a>
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" class="flex items-center text-sm font-medium rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        <div class="flex items-center space-x-3 bg-white px-4 py-2 rounded-full border hover:shadow-md transition-all">
                                            <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                                                {{ substr(Auth::user()->name, 0, 1) }}
                                            </div>
                                            <div class="text-left">
                                                <div class="text-gray-800">{{ Auth::user()->name }}</div>
                                                <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                                            </div>
                                            <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>

                                    <div x-show="open" 
                                         @click.away="open = false"
                                         x-transition:enter="transition ease-out duration-200"
                                         x-transition:enter-start="transform opacity-0 scale-95"
                                         x-transition:enter-end="transform opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-75"
                                         x-transition:leave-start="transform opacity-100 scale-100"
                                         x-transition:leave-end="transform opacity-0 scale-95"
                                         class="absolute right-0 z-50 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" style="display: none;">
                                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Profile
                                        </a>
                                        <a href="{{ route('profile.my-cars') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            My Cars
                                        </a>
                                        @if (Auth::user()->isAdmin())
                                            <a href="{{ route('admin.cars.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Admin Panel
                                            </a>
                                        @endif
                                        
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Log Out
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <a href="{{ route('login') }}" class="text-blue-600 bg-white border border-blue-600 hover:bg-blue-50 px-4 py-2 rounded-md text-sm font-medium transition-colors">Log in</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">Register</a>
                                @endif
                            @endauth
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <a href="{{ route('home') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('home') ? 'border-blue-500 text-blue-600 bg-blue-50' : 'border-transparent hover:border-gray-300 text-gray-600 hover:text-gray-800 hover:bg-gray-50' }} text-base font-medium transition-all duration-150 ease-in-out">
                            Home
                        </a>
                        <a href="{{ route('cars.index') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('cars.index') ? 'border-blue-500 text-blue-600 bg-blue-50' : 'border-transparent hover:border-gray-300 text-gray-600 hover:text-gray-800 hover:bg-gray-50' }} text-base font-medium transition-all duration-150 ease-in-out">
                            Cars
                        </a>
                        <a href="{{ route('dealers.index') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('dealers.index') ? 'border-blue-500 text-blue-600 bg-blue-50' : 'border-transparent hover:border-gray-300 text-gray-600 hover:text-gray-800 hover:bg-gray-50' }} text-base font-medium transition-all duration-150 ease-in-out">
                            Dealerships
                        </a>
                        @auth
                            <a href="{{ route('cars.create') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('cars.create') ? 'border-blue-500 text-blue-600 bg-blue-50' : 'border-transparent hover:border-gray-300 text-gray-600 hover:text-gray-800 hover:bg-gray-50' }} text-base font-medium transition-all duration-150 ease-in-out">
                                Post Car
                            </a>
                            <a href="{{ route('favorites.index') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('favorites.index') ? 'border-blue-500 text-blue-600 bg-blue-50' : 'border-transparent hover:border-gray-300 text-gray-600 hover:text-gray-800 hover:bg-gray-50' }} text-base font-medium transition-all duration-150 ease-in-out">
                                Favorites
                            </a>
                        @endauth
                    </div>

                    <!-- Responsive Settings Options -->
                    @auth
                        <div class="pt-4 pb-1 border-t border-gray-200">
                            <div class="px-4 py-2 bg-blue-50 rounded-md mx-4 mb-3">
                                <div class="font-medium text-base text-blue-800">{{ Auth::user()->name }}</div>
                                <div class="font-medium text-sm text-blue-600">{{ Auth::user()->email }}</div>
                            </div>

                            <div class="mt-3 space-y-1">
                                <a href="{{ route('profile.edit') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent hover:border-gray-300 text-gray-600 hover:text-gray-800 hover:bg-gray-50 text-base font-medium transition-all duration-150 ease-in-out">
                                    Profile
                                </a>
                                
                                <a href="{{ route('profile.my-cars') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent hover:border-gray-300 text-gray-600 hover:text-gray-800 hover:bg-gray-50 text-base font-medium transition-all duration-150 ease-in-out">
                                    My Cars
                                </a>
                                
                                @if (Auth::user()->isAdmin())
                                    <a href="{{ route('admin.cars.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent hover:border-gray-300 text-gray-600 hover:text-gray-800 hover:bg-gray-50 text-base font-medium transition-all duration-150 ease-in-out">
                                        Admin Panel
                                    </a>
                                @endif

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left pl-3 pr-4 py-2 border-l-4 border-transparent hover:border-gray-300 text-gray-600 hover:text-gray-800 hover:bg-gray-50 text-base font-medium transition-all duration-150 ease-in-out">
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth
                </div>
            </nav>

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                @hasSection('content')
                    @yield('content')
                @else
                    {{ $slot ?? '' }}
                @endif
            </main>
        </div>
    </body>
</html>
