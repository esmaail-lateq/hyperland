@props(['notifications', 'unreadCount'])

<div x-data="{ open: false }" 
     @toggle-mobile-menu.window="open = !open"
     @close-mobile-menu.window="open = false"
     @keydown.escape="open = false"
     class="lg:hidden">
    
    <!-- Enhanced Backdrop -->
    <div x-show="open" 
         x-cloak 
         @click="open = false"
         @click.away="open = false"
         class="fixed inset-0 bg-black/60 backdrop-blur-xl z-40 transition-all duration-500"></div>
    
    <!-- Enhanced Mobile Menu -->
    <div x-show="open" 
         x-cloak 
         @click.away="open = false"
         @keydown.escape="open = false"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="transform -translate-x-full opacity-0"
         x-transition:enter-end="transform translate-x-0 opacity-100"
         x-transition:leave="transition ease-in duration-400"
         x-transition:leave-start="transform translate-x-0 opacity-100"
         x-transition:leave-end="transform -translate-x-full opacity-0"
         class="fixed right-0 top-0 h-full w-80 bg-white/95 dark:bg-slate-800/95 backdrop-blur-2xl shadow-2xl shadow-black/30 dark:shadow-black/50 dark:border-slate-600/40 z-50 border-l border-white/30 dark:border-slate-600/30">
        
        <!-- Enhanced Header -->
        <div class="p-5 border-b border-white/25 dark:border-slate-600/25 bg-gradient-to-r from-white/50 to-white/30 dark:from-slate-800/50 dark:to-slate-800/30">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-slate-800 dark:text-slate-200">{{ __('navigation.menu') }}</h3>
                <button @click="open = false" 
                        @click.away="open = false"
                        class="w-10 h-10 rounded-full bg-white/30 dark:bg-slate-700/30 flex items-center justify-center hover:bg-white/40 dark:hover:bg-slate-600/40 hover:scale-110 transition-all duration-300 shadow-lg shadow-black/10 dark:shadow-black/20 hover:shadow-xl hover:shadow-black/15 dark:hover:shadow-black/25">
                    <svg class="w-6 h-6 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Enhanced Content -->
        <div class="p-5 space-y-6">
            
            <!-- Enhanced Notifications Section -->
            <div class="space-y-4">
                <h4 class="text-sm font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider flex items-center space-x-2">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                    </svg>
                    <span>{{ __('notifications.title') }}</span>
                </h4>
                
                @if($notifications->count() > 0)
                    <div class="space-y-3 max-h-48 overflow-y-auto">
                        @foreach($notifications->take(3) as $notification)
                            <div class="p-4 bg-gradient-to-r from-slate-50/80 to-slate-100/60 dark:from-slate-700/60 dark:to-slate-800/40 rounded-2xl border border-slate-200/50 dark:border-slate-600/40 hover:scale-[1.02] transition-all duration-300 hover:shadow-lg hover:shadow-black/10 dark:hover:shadow-black/20">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0 mt-1">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                                            {!! \App\Helpers\NotificationHelper::getNotificationIcon($notification->type) !!}
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-slate-800 dark:text-slate-200 line-clamp-2 leading-relaxed">
                                            {{ \App\Helpers\NotificationHelper::formatNotificationMessage($notification) }}
                                        </p>
                                        <p class="text-xs text-slate-600 dark:text-slate-400 mt-2 font-medium">
                                            {{ \App\Helpers\NotificationHelper::getNotificationTime($notification) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    @if($notifications->count() > 3)
                        <a href="{{ route('notifications.index') }}" class="block text-center text-sm font-bold text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-all duration-300 hover:scale-105 py-2 px-4 rounded-full hover:bg-blue-50 dark:hover:bg-blue-900/20">
                            {{ __('notifications.view_all') }}
                        </a>
                    @endif
                @else
                    <div class="text-center py-6">
                        <div class="w-16 h-16 mx-auto mb-3 bg-gradient-to-r from-slate-400/20 to-slate-500/20 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                            </svg>
                        </div>
                        <p class="text-sm text-slate-600 dark:text-slate-400 font-medium">{{ __('notifications.no_notifications') }}</p>
                    </div>
                @endif
            </div>
            
            <!-- Enhanced User Menu Section -->
            <div class="space-y-4">
                <h4 class="text-sm font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider flex items-center space-x-2">
                    <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span>{{ __('navigation.account') }}</span>
                </h4>
                
                <div class="space-y-3">
                    <a href="{{ route('profile.edit') }}" class="flex items-center space-x-4 p-4 rounded-2xl hover:bg-blue-500/10 dark:hover:bg-blue-400/10 transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-blue-500/20">
                        <div class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center group-hover:bg-blue-500/30 transition-all duration-300">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <span class="font-bold text-slate-800 dark:text-slate-200">{{ __('navigation.profile') }}</span>
                    </a>
                    
                    <a href="{{ route('favorites.index') }}" class="flex items-center space-x-4 p-4 rounded-2xl hover:bg-purple-500/10 dark:hover:bg-purple-400/10 transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-purple-500/20">
                        <div class="w-10 h-10 rounded-full bg-purple-500/20 flex items-center justify-center group-hover:bg-purple-500/30 transition-all duration-300">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                        <span class="font-bold text-slate-800 dark:text-slate-200">{{ __('components.favorites') }}</span>
                    </a>
                    
                    @if(auth()->user()->canManageUsers())
                        <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-4 p-4 rounded-2xl hover:bg-red-500/10 dark:hover:bg-red-400/10 transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-red-500/20">
                            <div class="w-10 h-10 rounded-full bg-red-500/20 flex items-center justify-center group-hover:bg-red-500/30 transition-all duration-300">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                </svg>
                            </div>
                            <span class="font-bold text-slate-800 dark:text-slate-200">{{ __('navigation.user_management') }}</span>
                        </a>
                    @endif
                </div>
            </div>
            
            <!-- Enhanced Logout Section -->
            <div class="pt-6 border-t border-slate-200/50 dark:border-slate-600/40">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center space-x-4 p-4 rounded-2xl bg-gradient-to-r from-red-500/10 to-pink-500/10 hover:from-red-500/20 hover:to-pink-500/20 text-red-600 dark:text-red-400 transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-red-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span class="font-bold">{{ __('navigation.logout') }}</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

