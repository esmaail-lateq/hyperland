@props(['notifications', 'unreadCount'])

<div class="relative group" x-data="{ open: false }">
    <button @click="open = !open" class="relative flex items-center space-x-2 bg-white/20 dark:bg-slate-800/20 backdrop-blur-xl rounded-full px-3 py-2 border border-white/30 dark:border-slate-600/30 hover:bg-white/30 dark:hover:bg-slate-700/30 transition-all duration-300 hover:scale-105 shadow-lg shadow-black/10 dark:shadow-black/20">
        <svg class="w-5 h-5 text-slate-600 dark:text-slate-400 group-hover:text-slate-800 dark:group-hover:text-slate-200 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
        </svg>
        
        @if($unreadCount > 0)
            <div class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center animate-pulse shadow-lg shadow-red-500/50">
                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
            </div>
        @endif
    </button>

    <!-- Notification Dropdown -->
    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-80 bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl rounded-2xl shadow-2xl shadow-black/20 dark:shadow-black/40 border border-white/30 dark:border-slate-600/30 origin-top-right">
        <div class="p-4 border-b border-white/20 dark:border-slate-600/20">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200">الإشعارات</h3>
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
                            <div class="w-2 h-2 mt-2 rounded-full {{ $notification->read_at ? 'bg-gray-400' : 'bg-blue-500' }}"></div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-slate-800 dark:text-slate-200">
                                    @if(isset($notification->data['message_ar']))
                                        {{ $notification->data['message_ar'] }}
                                    @elseif(isset($notification->data['message_en']))
                                        {{ $notification->data['message_en'] }}
                                    @elseif(isset($notification->data['message']))
                                        {{ $notification->data['message'] }}
                                    @else
                                        إشعار جديد
                                    @endif
                                </p>
                                <p class="text-xs text-slate-600 dark:text-slate-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="p-4 text-center">
                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    <p class="text-sm text-slate-600 dark:text-slate-400">لا توجد إشعارات جديدة</p>
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