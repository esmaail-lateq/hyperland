<?php

namespace App\Helpers;

use Illuminate\Notifications\DatabaseNotification;

class NotificationHelper
{
    /**
     * Get notification type badge class
     *
     * @param string $type
     * @return string
     */
    public static function getNotificationTypeBadgeClass(string $type): string
    {
        return match($type) {
            'App\Notifications\CarAddedNotification' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
            'App\Notifications\NewCarAddedNotification' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            'App\Notifications\SparePartAddedNotification' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300',
            'App\Notifications\NewSparePartAddedNotification' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300',
            'App\Notifications\CarApprovalNotification' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            'App\Notifications\CarRejectionNotification' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
            'App\Notifications\CarSoldNotification' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300',
            'App\Notifications\CarStatusChangedNotification' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
            'App\Notifications\SparePartApprovalNotification' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            'App\Notifications\SparePartRejectionNotification' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
            default => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300'
        };
    }

    /**
     * Get notification type name
     *
     * @param string $type
     * @return string
     */
    public static function getNotificationTypeName(string $type): string
    {
        return match($type) {
            'App\Notifications\CarAddedNotification' => __('notifications.car_added'),
            'App\Notifications\NewCarAddedNotification' => __('notifications.new_car_added'),
            'App\Notifications\SparePartAddedNotification' => __('notifications.spare_part_added'),
            'App\Notifications\NewSparePartAddedNotification' => __('notifications.new_spare_part_added'),
            'App\Notifications\CarApprovalNotification' => __('notifications.car_approval'),
            'App\Notifications\CarRejectionNotification' => __('notifications.car_rejection'),
            'App\Notifications\CarSoldNotification' => __('notifications.car_sold'),
            'App\Notifications\CarStatusChangedNotification' => __('notifications.car_status_changed'),
            'App\Notifications\SparePartApprovalNotification' => __('notifications.spare_part_approval'),
            'App\Notifications\SparePartRejectionNotification' => __('notifications.spare_part_rejection'),
            default => __('notifications.unknown_type')
        };
    }

    /**
     * Get notification icon
     *
     * @param string $type
     * @return string
     */
    public static function getNotificationIcon(string $type): string
    {
        return match($type) {
            'App\Notifications\CarAddedNotification',
            'App\Notifications\NewCarAddedNotification' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 01-16.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>',
            
            'App\Notifications\SparePartAddedNotification',
            'App\Notifications\NewSparePartAddedNotification' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
            
            'App\Notifications\CarApprovalNotification',
            'App\Notifications\SparePartApprovalNotification' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
            
            'App\Notifications\CarRejectionNotification',
            'App\Notifications\SparePartRejectionNotification' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
            
            'App\Notifications\CarSoldNotification' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/></svg>',
            
            'App\Notifications\CarStatusChangedNotification' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>',
            
            default => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>'
        };
    }

    /**
     * Format notification message
     *
     * @param DatabaseNotification $notification
     * @return string
     */
    public static function formatNotificationMessage(DatabaseNotification $notification): string
    {
        $data = $notification->data;
        
        // Validate data structure
        if (!is_array($data)) {
            return __('notifications.new_notification');
        }
        
        if (isset($data['message_ar']) && !empty($data['message_ar'])) {
            return $data['message_ar'];
        }
        
        if (isset($data['message_en']) && !empty($data['message_en'])) {
            return $data['message_en'];
        }
        
        if (isset($data['message']) && !empty($data['message'])) {
            return $data['message'];
        }
        
        return __('notifications.new_notification');
    }

    /**
     * Get notification time display
     *
     * @param DatabaseNotification $notification
     * @return string
     */
    public static function getNotificationTime(DatabaseNotification $notification): string
    {
        $data = $notification->data;
        
        // Validate data structure
        if (is_array($data) && isset($data['last_updated']) && !empty($data['last_updated'])) {
            try {
                return __('notifications.last_updated') . ': ' . \Carbon\Carbon::parse($data['last_updated'])->diffForHumans();
            } catch (\Exception $e) {
                // Fallback to created_at if parsing fails
            }
        }
        
        return $notification->created_at->diffForHumans();
    }

    /**
     * Check if notification is aggregated
     *
     * @param DatabaseNotification $notification
     * @return bool
     */
    public static function isAggregated(DatabaseNotification $notification): bool
    {
        $data = $notification->data;
        return is_array($data) && isset($data['aggregated_count']) && is_numeric($data['aggregated_count']) && $data['aggregated_count'] > 1;
    }

    /**
     * Get aggregated count
     *
     * @param DatabaseNotification $notification
     * @return int|null
     */
    public static function getAggregatedCount(DatabaseNotification $notification): ?int
    {
        $data = $notification->data;
        if (is_array($data) && isset($data['aggregated_count']) && is_numeric($data['aggregated_count'])) {
            return (int) $data['aggregated_count'];
        }
        return null;
    }

    /**
     * Get aggregated items
     *
     * @param DatabaseNotification $notification
     * @param int $limit
     * @return array
     */
    public static function getAggregatedItems(DatabaseNotification $notification, int $limit = 3): array
    {
        $data = $notification->data;
        if (!is_array($data) || !isset($data['aggregated_items']) || !is_array($data['aggregated_items'])) {
            return [];
        }
        
        $items = $data['aggregated_items'];
        return array_slice($items, -$limit);
    }

    /**
     * Get notification priority
     *
     * @param string $type
     * @return int
     */
    public static function getNotificationPriority(string $type): int
    {
        return match($type) {
            'App\Notifications\CarRejectionNotification',
            'App\Notifications\SparePartRejectionNotification' => 1, // High priority
            
            'App\Notifications\CarApprovalNotification',
            'App\Notifications\SparePartApprovalNotification' => 2, // Medium-high priority
            
            'App\Notifications\CarSoldNotification',
            'App\Notifications\CarStatusChangedNotification' => 3, // Medium priority
            
            'App\Notifications\CarAddedNotification',
            'App\Notifications\SparePartAddedNotification' => 4, // Medium-low priority
            
            'App\Notifications\NewCarAddedNotification',
            'App\Notifications\NewSparePartAddedNotification' => 5, // Low priority
            
            default => 6 // Lowest priority
        };
    }
} 