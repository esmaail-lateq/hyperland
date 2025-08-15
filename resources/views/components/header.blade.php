<!-- Glassmorphism Header with Blur Effects and Rounded Corners -->
<header class="bg-white/10 dark:bg-slate-900/10 backdrop-blur-xl border-b border-white/20 dark:border-slate-700/20 shadow-lg shadow-black/5 dark:shadow-black/20 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Main Header Container -->
        <div class="flex items-center justify-between h-20 lg:h-24">
            
            <!-- Logo Section with Glassmorphism - Larger and More Prominent -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('home') }}" class="flex items-center space-x-4 group transition-all duration-500 hover:scale-110">
                    <div class="relative">
                        <!-- Large Logo without Background -->
                        <img src="{{ asset('images/logo.svg') }}" alt="HybridLand Logo" class="w-20 h-20 lg:w-24 lg:h-24 group-hover:scale-110 transition-all duration-500">
                        <!-- Animated Status Dot -->
                        <div class="absolute -top-1 -right-1 w-4 h-4 bg-emerald-400 rounded-full animate-pulse shadow-lg shadow-emerald-400/50 border-2 border-white dark:border-slate-800"></div>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-2xl lg:text-3xl font-black text-slate-800 dark:text-slate-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-all duration-500">
                            HybridLand
                        </span>
                        <span class="text-sm lg:text-base text-slate-600 dark:text-slate-400 font-medium group-hover:text-slate-700 dark:group-hover:text-slate-300 transition-colors duration-500">
                            Auto Market
                        </span>
                    </div>
                </a>
            </div>

            <!-- Navigation Links with Glassmorphism Effects - All Rounded -->
            <nav class="hidden sm:flex items-center space-x-2 lg:space-x-3">
                <!-- Home Link -->
                <a href="{{ route('home') }}" class="group relative px-4 py-3 rounded-full transition-all duration-300 hover:bg-white/20 dark:hover:bg-slate-800/20 hover:scale-105 backdrop-blur-sm border border-transparent hover:border-white/20 dark:hover:border-slate-600/20 {{ request()->routeIs('home') ? 'bg-white/30 dark:bg-slate-800/30 shadow-lg' : '' }}">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 lg:w-6 lg:h-6 text-blue-500 dark:text-blue-400 group-hover:text-blue-600 dark:group-hover:text-blue-300 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span class="text-base lg:text-lg font-medium text-slate-700 dark:text-slate-200 group-hover:text-slate-900 dark:group-hover:text-white transition-colors duration-300">{{ __('navigation.home') }}</span>
                    </div>
                    <!-- Animated Underline -->
                    <div class="absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-blue-500 to-purple-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 rounded-full"></div>
                </a>



                <!-- Cars Link -->
                <a href="{{ route('cars.index') }}" class="group relative px-4 py-3 rounded-full transition-all duration-300 hover:bg-white/20 dark:hover:bg-slate-800/20 hover:scale-105 backdrop-blur-sm border border-transparent hover:border-white/20 dark:hover:border-slate-600/20 {{ request()->routeIs('cars.index') ? 'bg-white/30 dark:bg-slate-800/30 shadow-lg' : '' }}">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 lg:w-6 lg:h-6 text-purple-500 dark:text-purple-400 group-hover:text-purple-600 dark:group-hover:text-purple-300 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span class="text-base lg:text-lg font-medium text-slate-700 dark:text-slate-200 group-hover:text-slate-900 dark:group-hover:text-white transition-colors duration-300">{{ __('navigation.cars') }}</span>
                    </div>
                    <div class="absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-purple-500 to-pink-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 rounded-full"></div>
                </a>

                <!-- Spare Parts Link -->
                <a href="{{ route('spare-parts.index') }}" class="group relative px-4 py-3 rounded-full transition-all duration-300 hover:bg-white/20 dark:hover:bg-slate-800/20 hover:scale-105 backdrop-blur-sm border border-transparent hover:border-white/20 dark:hover:border-slate-600/20 {{ request()->routeIs('spare-parts.*') ? 'bg-white/30 dark:bg-slate-800/30 shadow-lg' : '' }}">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 lg:w-6 lg:h-6 text-amber-500 dark:text-amber-400 group-hover:text-amber-600 dark:group-hover:text-amber-300 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <span class="text-base lg:text-lg font-medium text-slate-700 dark:text-slate-200 group-hover:text-slate-900 dark:group-hover:text-white transition-colors duration-300">{{ __('navigation.spare_parts') }}</span>
                    </div>
                    <div class="absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-amber-500 to-orange-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 rounded-full"></div>
                </a>

                <!-- Shipping Services Link -->
                <a href="{{ route('shipping.index') }}" class="group relative px-4 py-3 rounded-full transition-all duration-300 hover:bg-white/20 dark:hover:bg-slate-800/20 hover:scale-105 backdrop-blur-sm border border-transparent hover:border-white/20 dark:hover:border-slate-600/20 {{ request()->routeIs('shipping.*') ? 'bg-white/30 dark:bg-slate-800/30 shadow-lg' : '' }}">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 lg:w-6 lg:h-6 text-blue-500 dark:text-blue-400 group-hover:text-blue-600 dark:group-hover:text-blue-300 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"/>
                        </svg>
                        <span class="text-base lg:text-lg font-medium text-slate-700 dark:text-slate-200 group-hover:text-slate-900 dark:group-hover:text-white transition-colors duration-300">{{ __('navigation.shipping_services') }}</span>
                    </div>
                    <div class="absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-blue-500 to-cyan-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 rounded-full"></div>
                </a>

                <!-- About Link -->
                <a href="{{ route('about') }}" class="group relative px-4 py-3 rounded-full transition-all duration-300 hover:bg-white/20 dark:hover:bg-slate-800/20 hover:scale-105 backdrop-blur-sm border border-transparent hover:border-white/20 dark:hover:border-slate-600/20 {{ request()->routeIs('about') ? 'bg-white/30 dark:bg-slate-800/30 shadow-lg' : '' }}">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 lg:w-6 lg:h-6 text-indigo-500 dark:text-indigo-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-300 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-base lg:text-lg font-medium text-slate-700 dark:text-slate-200 group-hover:text-slate-900 dark:group-hover:text-white transition-colors duration-300">{{ __('navigation.about') }}</span>
                    </div>
                    <div class="absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-indigo-500 to-blue-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 rounded-full"></div>
                </a>

                <!-- Unified Car Management Link (for admins and sub-admins only) -->
                @auth
                    @if(auth()->user()->isAdmin() || auth()->user()->isSubAdmin())
                        <a href="{{ route('unified-cars.index') }}" class="group relative px-4 py-3 rounded-full transition-all duration-300 hover:bg-white/20 dark:hover:bg-slate-800/20 hover:scale-105 backdrop-blur-sm border border-transparent hover:border-white/20 dark:hover:border-slate-600/20 {{ request()->routeIs('unified-cars.*') ? 'bg-white/30 dark:bg-slate-800/30 shadow-lg' : '' }}">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 lg:w-6 lg:h-6 text-emerald-500 dark:text-emerald-400 group-hover:text-emerald-600 dark:group-hover:text-emerald-300 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                <span class="text-base lg:text-lg font-medium text-slate-700 dark:text-slate-200 group-hover:text-slate-900 dark:group-hover:text-white transition-colors duration-300">
                                    {{ auth()->user()->isAdmin() ? __('navigation.admin_dashboard') : __('navigation.content_management') }}
                                </span>
                            </div>
                            <div class="absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-emerald-500 to-teal-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 rounded-full"></div>
                        </a>
                    @endif
                @endauth

            </nav>

            <!-- Right Section: Language Switcher, Notifications & User Menu -->
            <div class="flex items-center space-x-3 lg:space-x-4">
                
                <!-- Glassmorphism Language Switcher - Fully Rounded -->
                <div class="flex items-center bg-white/20 dark:bg-slate-800/20 backdrop-blur-xl rounded-full p-1 shadow-lg shadow-black/10 dark:shadow-black/20 border border-white/30 dark:border-slate-600/30">
                    @php
                        $currentLocale = app()->getLocale();
                        $availableLocales = ['en' => 'EN', 'ar' => 'عربي'];
                    @endphp
                    
                    @foreach($availableLocales as $locale => $name)
                        <a href="{{ route('language.switch', $locale) }}" 
                           class="px-4 py-2 text-sm font-bold rounded-full transition-all duration-300 {{ $currentLocale === $locale ? 'bg-white/80 dark:bg-slate-700/80 text-slate-800 dark:text-slate-200 shadow-md' : 'text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-white/40 dark:hover:bg-slate-700/40' }}">
                            <div class="flex items-center space-x-1">
                                <div class="w-2.5 h-2.5 rounded-full {{ $currentLocale === $locale ? 'bg-blue-500 dark:bg-blue-400' : 'bg-slate-400 dark:bg-slate-500' }}"></div>
                                <span>{{ $name }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Hamburger Button for Mobile -->
                @auth
                    <div class="lg:hidden">
                        <button @click="$dispatch('toggle-mobile-menu')" 
                                @click.away="$dispatch('close-mobile-menu')"
                                class="flex items-center justify-center w-10 h-10 bg-white/20 dark:bg-slate-800/20 backdrop-blur-xl rounded-full border border-white/30 dark:border-slate-600/30 hover:bg-white/30 dark:hover:bg-slate-700/30 transition-all duration-300">
                            <svg class="w-6 h-6 text-slate-700 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                    </div>
                @endauth

                <!-- Glassmorphism Notification Dropdown - Fully Rounded -->
                @auth
                    @php
                        $user = auth()->user();
                        $recentNotifications = $user->getRecentNotifications(5);
                        $unreadCount = $user->unreadNotifications()->count();
                    @endphp
                    
                    <div class="hidden lg:block">
                        <x-notification-dropdown :notifications="$recentNotifications" :unreadCount="$unreadCount" />
                    </div>
                @endauth

                <!-- Glassmorphism User Menu - Fully Rounded -->
                @auth
                    <div class="hidden lg:block relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                @click.away="open = false"
                                class="flex items-center space-x-3 bg-white/20 dark:bg-slate-800/20 backdrop-blur-xl rounded-full px-4 py-2.5 lg:px-5 lg:py-3 border border-white/30 dark:border-slate-600/30 hover:bg-white/30 dark:hover:bg-slate-700/30 transition-all duration-300 hover:scale-105 shadow-lg shadow-black/10 dark:shadow-black/20">
                            <div class="relative">
                                <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-gradient-to-r from-blue-500/80 to-purple-600/80 flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-blue-500/25">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-emerald-400 border-2 border-white dark:border-slate-800 rounded-full animate-pulse shadow-lg shadow-emerald-400/50"></div>
                            </div>
                            <div class="hidden md:block text-left">
                                <div class="text-base font-bold text-slate-800 dark:text-slate-200">{{ Auth::user()->name }}</div>
                                <div class="text-sm text-slate-600 dark:text-slate-400">{{ __('components.online') }}</div>
                            </div>
                            <svg class="w-5 h-5 text-slate-600 dark:text-slate-400 group-hover:text-slate-800 dark:group-hover:text-slate-200 transition-colors duration-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>

                        <!-- Glassmorphism Dropdown Menu - Fully Rounded -->
                        <div x-show="open" 
                             x-cloak 
                             @click.away="open = false" 
                             @keydown.escape="open = false"
                             x-transition:enter="transition ease-out duration-200" 
                             x-transition:enter-start="transform opacity-0 scale-95" 
                             x-transition:enter-end="transform opacity-100 scale-100" 
                             x-transition:leave="transition ease-in duration-75" 
                             x-transition:leave-start="transform opacity-100 scale-100" 
                             x-transition:leave-end="transform opacity-0 scale-95" 
                             class="absolute right-0 top-full mt-2 w-64 bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl rounded-2xl shadow-2xl shadow-black/20 dark:shadow-black/40 border border-white/30 dark:border-slate-600/30 origin-top-right z-50">
                            <div class="p-4 border-b border-white/20 dark:border-slate-600/20">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500/80 to-purple-600/80 flex items-center justify-center text-white font-bold shadow-lg shadow-blue-500/25">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-800 dark:text-slate-200">{{ Auth::user()->name }}</div>
                                        <div class="text-sm text-slate-600 dark:text-slate-400">{{ Auth::user()->email }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-2 space-y-1">
                                <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-full hover:bg-blue-500/10 dark:hover:bg-blue-400/10 group transition-all duration-300">
                                    <div class="w-8 h-8 rounded-full bg-blue-500/20 dark:bg-blue-400/20 flex items-center justify-center group-hover:bg-blue-500/30 dark:group-hover:bg-blue-400/30 transition-colors duration-300">
                                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="font-bold text-slate-800 dark:text-slate-200 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300">{{ __('navigation.profile') }}</span>
                                        <div class="text-xs text-slate-600 dark:text-slate-400">{{ __('navigation.manage_account') }}</div>
                                    </div>
                                </a>



                                <a href="{{ route('favorites.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-full hover:bg-purple-500/10 dark:hover:bg-purple-400/10 group transition-all duration-300">
                                    <div class="w-8 h-8 rounded-full bg-purple-500/20 dark:bg-purple-400/20 flex items-center justify-center group-hover:bg-purple-500/30 dark:group-hover:text-purple-400/30 transition-colors duration-300">
                                        <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="font-bold text-slate-800 dark:text-slate-200 group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors duration-300">{{ __('components.favorites') }}</span>
                                        <div class="text-xs text-slate-600 dark:text-slate-400">{{ __('components.your_saved_cars') }}</div>
                                    </div>
                                </a>



                                @if(auth()->user()->canManageUsers())
                                <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-full hover:bg-red-500/10 dark:hover:bg-red-400/10 group transition-all duration-300">
                                    <div class="w-8 h-8 rounded-full bg-red-500/20 dark:bg-red-400/20 flex items-center justify-center group-hover:bg-red-500/30 dark:group-hover:bg-red-400/30 transition-colors duration-300">
                                        <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="font-bold text-slate-800 dark:text-slate-200 group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors duration-300">{{ __('navigation.user_management') }}</span>
                                        <div class="text-xs text-slate-600 dark:text-slate-400">{{ __('components.manage_users_roles') }}</div>
                                    </div>
                                </a>
                                @endif

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center space-x-3 px-3 py-2.5 rounded-full hover:bg-rose-500/10 dark:hover:bg-rose-400/10 group transition-all duration-300">
                                        <div class="w-8 h-8 rounded-full bg-rose-500/20 dark:bg-rose-400/20 flex items-center justify-center group-hover:bg-rose-500/30 dark:group-hover:bg-rose-400/30 transition-colors duration-300">
                                            <svg class="w-4 h-4 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="font-bold text-slate-800 dark:text-slate-200 group-hover:text-rose-600 dark:group-hover:text-rose-400 transition-colors duration-300">{{ __('navigation.logout') }}</span>
                                            <div class="text-xs text-slate-600 dark:text-slate-400">{{ __('components.sign_out') }}</div>
                                        </div>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Guest Authentication Buttons with Glassmorphism - Fully Rounded -->
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('login') }}" class="px-5 py-3 text-sm font-bold text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition-colors duration-300 rounded-full hover:bg-white/20 dark:hover:bg-slate-800/20 backdrop-blur-sm border border-white/30 dark:border-slate-600/30 shadow-lg shadow-black/10 dark:shadow-black/20">
                            {{ __('navigation.login') }}
                        </a>
                        <a href="{{ route('register') }}" class="px-5 py-3 text-sm font-bold text-white bg-gradient-to-r from-blue-500/80 to-purple-600/80 hover:from-blue-600/90 hover:to-purple-700/90 rounded-full shadow-lg shadow-blue-500/25 hover:shadow-xl hover:shadow-blue-500/40 transition-all duration-300 transform hover:scale-105 backdrop-blur-sm border border-white/30">
                            {{ __('navigation.register') }}
                        </a>
                    </div>
                @endauth
            </div>
        </div>

        <!-- Mobile Navigation with Glassmorphism - Fully Rounded -->
        <div class="sm:hidden py-3 border-t border-white/20 dark:border-slate-700/20">
            <div class="flex items-center justify-between space-x-1">
                <a href="{{ route('home') }}" class="flex-1 flex flex-col items-center px-2 py-2.5 rounded-full transition-all duration-300 hover:bg-white/20 dark:hover:bg-slate-800/20 backdrop-blur-sm {{ request()->routeIs('home') ? 'bg-white/30 dark:bg-slate-800/30' : '' }}">
                    <svg class="w-5 h-5 text-blue-500 dark:text-blue-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="text-xs font-medium text-slate-700 dark:text-slate-200">{{ __('navigation.home') }}</span>
                </a>
                
                <a href="{{ route('cars.index') }}" class="flex-1 flex flex-col items-center px-2 py-2.5 rounded-full transition-all duration-300 hover:bg-white/20 dark:hover:bg-slate-800/20 backdrop-blur-sm {{ request()->routeIs('cars.index') ? 'bg-white/30 dark:bg-slate-800/30' : '' }}">
                    <svg class="w-5 h-5 text-purple-500 dark:text-purple-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span class="text-xs font-medium text-slate-700 dark:text-slate-200">{{ __('navigation.cars') }}</span>
                </a>
                
                <a href="{{ route('spare-parts.index') }}" class="flex-1 flex flex-col items-center px-2 py-2.5 rounded-full transition-all duration-300 hover:bg-white/20 dark:hover:bg-slate-800/20 backdrop-blur-sm {{ request()->routeIs('spare-parts.*') ? 'bg-white/30 dark:bg-slate-800/30' : '' }}">
                    <svg class="w-5 h-5 text-amber-500 dark:text-amber-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <span class="text-xs font-medium text-slate-700 dark:text-slate-200">{{ __('navigation.spare_parts') }}</span>
                </a>
                
                <a href="{{ route('shipping.index') }}" class="flex-1 flex flex-col items-center px-2 py-2.5 rounded-full transition-all duration-300 hover:bg-white/20 dark:hover:bg-slate-800/20 backdrop-blur-sm {{ request()->routeIs('shipping.*') ? 'bg-white/30 dark:bg-slate-800/30' : '' }}">
                    <svg class="w-5 h-5 text-blue-500 dark:text-blue-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <span class="text-xs font-medium text-slate-700 dark:text-slate-200">{{ __('navigation.shipping_services') }}</span>
                </a>
                
                <a href="{{ route('about') }}" class="flex-1 flex flex-col items-center px-2 py-2.5 rounded-full transition-all duration-300 hover:bg-white/20 dark:hover:bg-slate-800/20 backdrop-blur-sm {{ request()->routeIs('about') ? 'bg-white/30 dark:bg-slate-800/30' : '' }}">
                    <svg class="w-5 h-5 text-indigo-500 dark:text-indigo-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-xs font-medium text-slate-700 dark:text-slate-200">{{ __('navigation.about') }}</span>
                </a>
            </div>
        </div>
    </div>
</header>

<!-- Mobile Menu Component -->
@auth
    <x-mobile-menu :notifications="$recentNotifications" :unreadCount="$unreadCount" />
@endauth 