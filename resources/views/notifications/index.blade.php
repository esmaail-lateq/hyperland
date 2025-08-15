@extends('layouts.app')

@section('title', __('notifications.page_title'))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-800 dark:text-slate-200 mb-2">
                        {{ __('notifications.page_title') }}
                    </h1>
                    <p class="text-slate-600 dark:text-slate-400">
                        {{ __('notifications.page_description') }}
                    </p>
                </div>
                
                @if($notifications->count() > 0)
                    <div class="flex items-center space-x-3">
                        <button data-action="mark-all-read" class="flex items-center space-x-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-full transition-colors duration-300 shadow-lg shadow-blue-500/25">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>{{ __('notifications.mark_all_read') }}</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <!-- Filters -->
        <div class="mb-6">
            <div class="flex flex-wrap items-center gap-4">
                <div class="flex items-center space-x-2">
                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ __('notifications.filter_by') }}:</span>
                    <select id="statusFilter" onchange="filterNotifications()" class="bg-white/80 dark:bg-slate-800/80 border border-slate-300 dark:border-slate-600 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">{{ __('notifications.all_notifications') }}</option>
                        <option value="unread" {{ request('filter') === 'unread' ? 'selected' : '' }}>{{ __('notifications.unread_only') }}</option>
                        <option value="read" {{ request('filter') === 'read' ? 'selected' : '' }}>{{ __('notifications.read_only') }}</option>
                    </select>
                </div>
                
                <div class="flex items-center space-x-2">
                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ __('notifications.type') }}:</span>
                    <select id="typeFilter" onchange="filterNotifications()" class="bg-white/80 dark:bg-slate-800/80 border border-slate-300 dark:border-slate-600 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">{{ __('notifications.all_types') }}</option>
                        <option value="App\Notifications\CarAddedNotification" {{ request('type') === 'App\Notifications\CarAddedNotification' ? 'selected' : '' }}>{{ __('notifications.car_added') }}</option>
                        <option value="App\Notifications\SparePartAddedNotification" {{ request('type') === 'App\Notifications\SparePartAddedNotification' ? 'selected' : '' }}>{{ __('notifications.spare_part_added') }}</option>
                        <option value="App\Notifications\CarApprovalNotification" {{ request('type') === 'App\Notifications\CarApprovalNotification' ? 'selected' : '' }}>{{ __('notifications.car_approval') }}</option>
                        <option value="App\Notifications\CarRejectionNotification" {{ request('type') === 'App\Notifications\CarRejectionNotification' ? 'selected' : '' }}>{{ __('notifications.car_rejection') }}</option>
                        <option value="App\Notifications\SparePartApprovalNotification" {{ request('type') === 'App\Notifications\SparePartApprovalNotification' ? 'selected' : '' }}>{{ __('notifications.spare_part_approval') }}</option>
                        <option value="App\Notifications\SparePartRejectionNotification" {{ request('type') === 'App\Notifications\SparePartRejectionNotification' ? 'selected' : '' }}>{{ __('notifications.spare_part_rejection') }}</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Notifications List -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl shadow-2xl shadow-black/10 dark:shadow-black/20 border border-white/30 dark:border-slate-600/30 overflow-hidden">
            @if($notifications->count() > 0)
                <div class="divide-y divide-slate-200 dark:divide-slate-700">
                    @foreach($notifications as $notification)
                        <div class="p-6 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors duration-200 {{ $notification->read_at ? 'opacity-75' : '' }}">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start space-x-4 flex-1">
                                    <!-- Status Indicator -->
                                    <div class="flex-shrink-0">
                                        <div class="w-3 h-3 rounded-full {{ $notification->read_at ? 'bg-gray-400' : 'bg-blue-500 animate-pulse' }}"></div>
                                    </div>
                                    
                                    <!-- Notification Content -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center space-x-4 mb-3">
                                            {{-- Notification Icon --}}
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white shadow-lg">
                                                {!! \App\Helpers\NotificationHelper::getNotificationIcon($notification->type) !!}
                                            </div>
                                            
                                            <div class="flex-1">
                                                <div class="flex items-center space-x-2 mb-1">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ \App\Helpers\NotificationHelper::getNotificationTypeBadgeClass($notification->type) }}">
                                                        {{ \App\Helpers\NotificationHelper::getNotificationTypeName($notification->type) }}
                                                    </span>
                                                    @if(!$notification->read_at)
                                                        <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                                                    @endif
                                                </div>
                                                
                                                <p class="text-slate-800 dark:text-slate-200 font-medium">
                                                    {{ \App\Helpers\NotificationHelper::formatNotificationMessage($notification) }}
                                                </p>
                                            </div>
                                            
                                            <div class="text-right">
                                                <span class="text-sm text-slate-500 dark:text-slate-400">
                                                    {{ \App\Helpers\NotificationHelper::getNotificationTime($notification) }}
                                                </span>
                                            </div>
                                        </div>
                                        
                                        {{-- Show aggregated details if available --}}
                                        @if(\App\Helpers\NotificationHelper::isAggregated($notification))
                                            <div class="mt-3 p-4 bg-gradient-to-r from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 rounded-xl border border-blue-200 dark:border-blue-800 shadow-sm">
                                                <div class="flex items-center space-x-3 mb-3">
                                                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white">
                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <span class="text-sm font-bold text-blue-800 dark:text-blue-200">
                                                            {{ \App\Helpers\NotificationHelper::getAggregatedCount($notification) }} إشعارات مجمعة
                                                        </span>
                                                        <p class="text-xs text-blue-600 dark:text-blue-400">
                                                            تم تجميع الإشعارات المتشابهة لتقليل spam
                                                        </p>
                                                    </div>
                                                </div>
                                                
                                                @if(count(\App\Helpers\NotificationHelper::getAggregatedItems($notification)) > 0)
                                                    <div class="bg-white/50 dark:bg-slate-800/50 rounded-lg p-3">
                                                        <div class="text-xs font-medium text-blue-700 dark:text-blue-300 mb-2">
                                                            آخر العناصر المضافة:
                                                        </div>
                                                        <ul class="space-y-2">
                                                            @foreach(\App\Helpers\NotificationHelper::getAggregatedItems($notification) as $item)
                                                                <li class="flex items-center justify-between p-2 bg-white/70 dark:bg-slate-700/70 rounded-md">
                                                                    <div class="flex items-center space-x-2">
                                                                        <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                                                        <span class="text-sm text-slate-700 dark:text-slate-300">
                                                                            {{ $item['title'] ?? 'عنصر جديد' }}
                                                                        </span>
                                                                    </div>
                                                                    <span class="text-xs text-blue-600 dark:text-blue-400">
                                                                        {{ \Carbon\Carbon::parse($item['added_at'])->diffForHumans() }}
                                                                    </span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                                
                                                <div class="text-xs text-blue-600 dark:text-blue-400 mt-3 text-center">
                                                    آخر تحديث: {{ \Carbon\Carbon::parse($notification->data['last_updated'])->diffForHumans() }}
                                                </div>
                                            </div>
                                        @endif
                                        
                                        <!-- Additional Details -->
                                        @if(isset($notification->data['car_title']))
                                            <div class="text-sm text-slate-600 dark:text-slate-400">
                                                <strong>{{ __('notifications.car') }}:</strong> {{ $notification->data['car_title'] }}
                                            </div>
                                        @endif
                                        
                                        @if(isset($notification->data['spare_part_name']))
                                            <div class="text-sm text-slate-600 dark:text-slate-400">
                                                <strong>{{ __('notifications.spare_part') }}:</strong> {{ $notification->data['spare_part_name'] }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Actions -->
                                <div class="flex items-center space-x-2">
                                    @if(!$notification->read_at)
                                        <button data-action="mark-as-read" data-notification-id="{{ $notification->id }}" class="p-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-200" title="{{ __('notifications.mark_as_read') }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </button>
                                    @endif
                                    
                                    <button data-action="delete" data-notification-id="{{ $notification->id }}" class="p-2 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors duration-200" title="{{ __('notifications.delete') }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="p-12 text-center">
                    <div class="w-24 h-24 mx-auto mb-4 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-slate-800 dark:text-slate-200 mb-2">
                        {{ __('notifications.no_notifications') }}
                    </h3>
                    <p class="text-slate-600 dark:text-slate-400">
                        {{ __('notifications.no_notifications_description') }}
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function filterNotifications() {
    const statusFilter = document.getElementById('statusFilter').value;
    const typeFilter = document.getElementById('typeFilter').value;
    
    let url = new URL(window.location);
    
    if (statusFilter) {
        url.searchParams.set('filter', statusFilter);
    } else {
        url.searchParams.delete('filter');
    }
    
    if (typeFilter) {
        url.searchParams.set('type', typeFilter);
    } else {
        url.searchParams.delete('type');
    }
    
    window.location.href = url.toString();
}

document.addEventListener('DOMContentLoaded', function() {
    const markAllReadButton = document.querySelector('[data-action="mark-all-read"]');
    const markAsReadButtons = document.querySelectorAll('[data-action="mark-as-read"]');
    const deleteButtons = document.querySelectorAll('[data-action="delete"]');
    const markAllConfirmText = document.getElementById('markAllConfirmText').textContent;
    const deleteConfirmText = document.getElementById('deleteConfirmText').textContent;

    if (markAllReadButton) {
        markAllReadButton.addEventListener('click', function(e) {
            if (!confirm(markAllConfirmText)) {
                e.preventDefault();
            }
        });
    }

    markAsReadButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const notificationId = this.dataset.notificationId;
            if (!confirm('{{ __("notifications.confirm_mark_as_read") }}')) {
                e.preventDefault();
            } else {
                fetch(`/notifications/${notificationId}/read`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        });
    });

    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const notificationId = this.dataset.notificationId;
            if (!confirm(deleteConfirmText)) {
                e.preventDefault();
            } else {
                fetch(`/notifications/${notificationId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        });
    });
});
</script>
@endsection

{{-- Helper functions moved to NotificationHelper class --}} 