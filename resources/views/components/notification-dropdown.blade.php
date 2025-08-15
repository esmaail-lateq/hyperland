@props(['notifications', 'unreadCount'])

<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" 
            @click.away="open = false"
            class="relative flex items-center space-x-2 bg-white/20 dark:bg-slate-800/20 backdrop-blur-xl rounded-full px-3 py-2 border border-white/30 dark:border-slate-600/30 hover:bg-white/30 dark:hover:bg-slate-700/30 transition-all duration-300 hover:scale-105 shadow-lg shadow-black/10 dark:shadow-black/20">
        <svg class="w-5 h-5 text-slate-600 dark:text-slate-400 group-hover:text-slate-800 dark:group-hover:text-slate-200 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/>
        </svg>
        
        @if($unreadCount > 0)
            <div class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center animate-pulse shadow-lg shadow-red-500/50">
                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
            </div>
        @endif
    </button>

    <!-- Notification Dropdown -->
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
         class="absolute right-0 top-full mt-2 w-80 bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl rounded-2xl shadow-2xl shadow-black/20 dark:shadow-black/40 border border-white/30 dark:border-slate-600/30 origin-top-right z-50">
        <div class="p-4 border-b border-white/20 dark:border-slate-600/20">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200">{{ __('notifications.title') }}</h3>
                @if($unreadCount > 0)
                    <span class="px-2 py-1 bg-red-500 text-white text-xs font-bold rounded-full">{{ $unreadCount }}</span>
                @endif
            </div>
        </div>
        
        <div class="max-h-64 overflow-y-auto">
            @if($notifications->count() > 0)
                @foreach($notifications as $notification)
                    <div class="p-3 border-b border-white/10 dark:border-slate-600/10 hover:bg-white/20 dark:hover:bg-slate-700/20 transition-colors duration-200">
                        <div class="flex items-start space-x-3">
                            {{-- Notification Icon --}}
                            <div class="flex-shrink-0 mt-1">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white">
                                    {!! \App\Helpers\NotificationHelper::getNotificationIcon($notification->type) !!}
                                </div>
                            </div>
                            
                            <div class="flex-1 min-w-0">
                                {{-- Notification Type Badge --}}
                                <div class="flex items-center space-x-2 mb-1">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ \App\Helpers\NotificationHelper::getNotificationTypeBadgeClass($notification->type) }}">
                                        {{ \App\Helpers\NotificationHelper::getNotificationTypeName($notification->type) }}
                                    </span>
                                    @if(!$notification->read_at)
                                        <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                                    @endif
                                </div>
                                
                                {{-- Notification Message --}}
                                <p class="text-sm font-medium text-slate-800 dark:text-slate-200 mb-1">
                                    {{ \App\Helpers\NotificationHelper::formatNotificationMessage($notification) }}
                                </p>
                                
                                {{-- Show aggregated details if available --}}
                                @if(\App\Helpers\NotificationHelper::isAggregated($notification))
                                    <div class="mt-2">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-sm">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ \App\Helpers\NotificationHelper::getAggregatedCount($notification) }} {{ __('notifications.aggregated_notifications') }}
                                        </span>
                                    </div>
                                @endif
                                
                                {{-- Notification Time --}}
                                <p class="text-xs text-slate-600 dark:text-slate-400 mt-1">
                                    {{ \App\Helpers\NotificationHelper::getNotificationTime($notification) }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="p-4 text-center">
                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                    </svg>
                    <p class="text-sm text-slate-600 dark:text-slate-400">{{ __('notifications.no_notifications') }}</p>
                </div>
            @endif
        </div>
        
        @if($notifications->count() > 0)
            <div class="p-3 border-t border-white/20 dark:border-slate-600/20">
                <a href="{{ route('notifications.index') }}" class="block text-center text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors duration-200">
                    {{ __('notifications.view_all') }}
                </a>
            </div>
        @endif
    </div>
</div> 