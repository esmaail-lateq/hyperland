@props(['notifications', 'unreadCount'])

<div x-data="{ open: false }" 
     @toggle-mobile-menu.window="open = !open"
     @close-mobile-menu.window="open = false"
     @keydown.escape="open = false"
     class="lg:hidden">
    
    <!-- Backdrop -->
    <div x-show="open" 
         x-cloak 
         @click="open = false"
         @click.away="open = false"
         class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40"></div>
    
    <!-- Mobile Menu -->
    <div x-show="open" 
         x-cloak 
         @click.away="open = false"
         @keydown.escape="open = false"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="transform -translate-x-full"
         x-transition:enter-end="transform translate-x-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="transform translate-x-0"
         x-transition:leave-end="transform -translate-x-full"
         class="fixed right-0 top-0 h-full w-80 bg-white/95 dark:bg-slate-800/95 backdrop-blur-xl shadow-2xl shadow-black/20 dark:border-slate-600/30 z-50">
        
        <!-- Header -->
        <div class="p-4 border-b border-white/20 dark:border-slate-600/20">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200">{{ __('navigation.menu') }}</h3>
                <button @click="open = false" 
                        @click.away="open = false"
                        class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors duration-200">
                    <svg class="w-5 h-5 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Content -->
        <div class="p-4 space-y-4">
            
            <!-- Notifications Section -->
            <div class="space-y-3">
                <h4 class="text-sm font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide">{{ __('notifications.title') }}</h4>
                
                @if($notifications->count() > 0)
                    <div class="space-y-2 max-h-48 overflow-y-auto">
                        @foreach($notifications->take(3) as $notification)
                            <div class="p-3 bg-slate-50 dark:bg-slate-700/50 rounded-lg border border-slate-200 dark:border-slate-600/30">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0 mt-1">
                                        <div class="w-6 h-6 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white">
                                            {!! \App\Helpers\NotificationHelper::getNotificationIcon($notification->type) !!}
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-slate-800 dark:text-slate-200 line-clamp-2">
                                            {{ \App\Helpers\NotificationHelper::formatNotificationMessage($notification) }}
                                        </p>
                                        <p class="text-xs text-slate-600 dark:text-slate-400 mt-1">
                                            {{ \App\Helpers\NotificationHelper::getNotificationTime($notification) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    @if($notifications->count() > 3)
                        <a href="{{ route('notifications.index') }}" class="block text-center text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors duration-200">
                            {{ __('notifications.view_all') }}
                        </a>
                    @endif
                @else
                    <div class="text-center py-4">
                        <svg class="w-8 h-8 mx-auto text-slate-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        </svg>
                        <p class="text-sm text-slate-600 dark:text-slate-400">{{ __('notifications.no_notifications') }}</p>
                    </div>
                @endif
            </div>
            
            <!-- User Menu Section -->
            <div class="space-y-3">
                <h4 class="text-sm font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide">{{ __('navigation.account') }}</h4>
                
                <div class="space-y-2">
                    <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700/50 transition-colors duration-200">
                        <div class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <span class="font-medium text-slate-800 dark:text-slate-200">{{ __('navigation.profile') }}</span>
                    </a>
                    
                    <a href="{{ route('favorites.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700/50 transition-colors duration-200">
                        <div class="w-8 h-8 rounded-full bg-purple-500/20 flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                        <span class="font-medium text-slate-800 dark:text-slate-200">{{ __('components.favorites') }}</span>
                    </a>
                    
                    @if(auth()->user()->canManageUsers())
                        <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700/50 transition-colors duration-200">
                            <div class="w-8 h-8 rounded-full bg-red-500/20 flex items-center justify-center">
                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                </svg>
                            </div>
                            <span class="font-medium text-slate-800 dark:text-slate-200">{{ __('navigation.user_management') }}</span>
                        </a>
                    @endif
                </div>
            </div>
            
            <!-- Logout Section -->
            <div class="pt-4 border-t border-slate-200 dark:border-slate-600/30">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center space-x-3 p-3 rounded-lg bg-red-500/10 hover:bg-red-500/20 text-red-600 dark:text-red-400 transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span class="font-medium">{{ __('navigation.logout') }}</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

