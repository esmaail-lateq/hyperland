@props(['notifications', 'unreadCount'])

<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" 
            @click.away="open = false"
            class="relative flex items-center space-x-2 bg-white/25 dark:bg-slate-800/25 backdrop-blur-2xl rounded-full px-3 py-2 border border-white/35 dark:border-slate-600/35 hover:bg-white/35 dark:hover:bg-slate-700/35 hover:scale-105 transition-all duration-500 shadow-xl shadow-black/15 dark:shadow-black/25 hover:shadow-2xl hover:shadow-black/20 dark:hover:shadow-black/30">
        <div class="relative">
            <svg class="w-5 h-5 text-slate-600 dark:text-slate-400 group-hover:text-slate-800 dark:group-hover:text-slate-200 transition-all duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/>
            </svg>
            <!-- Glow Effect -->
            <div class="absolute inset-0 w-5 h-5 bg-blue-500/20 rounded-full blur-md opacity-0 group-hover:opacity-100 transition-all duration-500"></div>
        </div>
        
        @if($unreadCount > 0)
            <div class="absolute -top-1 -right-1 w-5 h-5 bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs font-bold rounded-full flex items-center justify-center animate-pulse shadow-lg shadow-red-500/50 ring-2 ring-white dark:ring-slate-800">
                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
            </div>
        @endif
    </button>

    <!-- Enhanced Notification Dropdown -->
    <div x-show="open" 
         x-cloak 
         @click.away="open = false" 
         @keydown.escape="open = false"
         x-transition:enter="transition ease-out duration-300" 
         x-transition:enter-start="transform opacity-0 scale-95" 
         x-transition:enter-end="transform opacity-100 scale-100" 
         x-transition:leave="transition ease-in duration-200" 
         x-transition:leave-start="transform opacity-100 scale-100" 
         x-transition:leave-end="transform opacity-0 scale-95" 
         class="absolute right-0 top-full mt-3 w-80 bg-white/95 dark:bg-slate-800/95 backdrop-blur-2xl rounded-3xl shadow-2xl shadow-black/25 dark:shadow-black/50 border border-white/35 dark:border-slate-600/35 origin-top-right z-50">
        <div class="p-5 border-b border-white/25 dark:border-slate-600/25">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200">{{ __('notifications.title') }}</h3>
                @if($unreadCount > 0)
                    <span class="px-3 py-1 bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs font-bold rounded-full shadow-lg shadow-red-500/30">{{ $unreadCount }}</span>
                @endif
            </div>
        </div>
        
        <div class="max-h-64 overflow-y-auto">
            @if($notifications->count() > 0)
                @foreach($notifications as $notification)
                    <div class="p-4 border-b border-white/15 dark:border-slate-600/15 hover:bg-white/20 dark:hover:bg-slate-700/20 transition-all duration-300 hover:scale-[1.02]">
                        <div class="flex items-start space-x-4">
                            {{-- Enhanced Notification Icon --}}
                            <div class="flex-shrink-0 mt-1">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 transition-all duration-300">
                                    {!! \App\Helpers\NotificationHelper::getNotificationIcon($notification->type) !!}
                                </div>
                            </div>
                            
                            <div class="flex-1 min-w-0">
                                {{-- Enhanced Notification Type Badge --}}
                                <div class="flex items-center space-x-2 mb-2">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ \App\Helpers\NotificationHelper::getNotificationTypeBadgeClass($notification->type) }} shadow-sm">
                                        {{ \App\Helpers\NotificationHelper::getNotificationTypeName($notification->type) }}
                                    </span>
                                    @if(!$notification->read_at)
                                        <span class="w-2.5 h-2.5 bg-gradient-to-r from-red-500 to-pink-500 rounded-full animate-pulse shadow-lg shadow-red-500/50"></span>
                                    @endif
                                </div>
                                
                                {{-- Enhanced Notification Message --}}
                                <p class="text-sm font-medium text-slate-800 dark:text-slate-200 mb-2 leading-relaxed">
                                    {{ \App\Helpers\NotificationHelper::formatNotificationMessage($notification) }}
                                </p>
                                
                                {{-- Show aggregated details if available --}}
                                @if(\App\Helpers\NotificationHelper::isAggregated($notification))
                                    <div class="mt-3">
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg shadow-blue-500/30">
                                            <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ \App\Helpers\NotificationHelper::getAggregatedCount($notification) }} {{ __('notifications.aggregated_notifications') }}
                                        </span>
                                    </div>
                                @endif
                                
                                {{-- Enhanced Notification Time --}}
                                <p class="text-xs text-slate-600 dark:text-slate-400 mt-2 font-medium">
                                    {{ \App\Helpers\NotificationHelper::getNotificationTime($notification) }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="p-6 text-center">
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
        
        @if($notifications->count() > 0)
            <div class="p-4 border-t border-white/25 dark:border-slate-600/25">
                <a href="{{ route('notifications.index') }}" class="block text-center text-sm font-bold text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-all duration-300 hover:scale-105">
                    {{ __('notifications.view_all') }}
                </a>
            </div>
        @endif
    </div>
</div> 