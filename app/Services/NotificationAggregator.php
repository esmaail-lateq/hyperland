<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;

class NotificationAggregator
{
    /**
     * Check if a notification should be aggregated with existing ones
     *
     * @param User $user
     * @param string $type
     * @param int $minutes
     * @return bool
     */
    public static function shouldAggregate(User $user, string $type, int $minutes = null): bool
    {
        // First check if aggregation is enabled for this type
        if (!self::isAggregationEnabled($type)) {
            return false;
        }
        
        $config = config('notifications');
        $minutes = $minutes ?? $config['aggregation_minutes'] ?? 30;
        
        $recentNotification = $user->notifications()
            ->where('type', $type)
            ->where('created_at', '>=', now()->subMinutes($minutes))
            ->first();
            
        return $recentNotification !== null;
    }
    
    /**
     * Update an existing notification with new aggregated data
     *
     * @param DatabaseNotification $notification
     * @param array $newData
     * @return void
     */
    public static function updateExistingNotification(DatabaseNotification $notification, array $newData): void
    {
        $data = $notification->data;
        $data['aggregated_count'] = ($data['aggregated_count'] ?? 1) + 1;
        $data['last_updated'] = now()->toISOString();
        
        // Add new items to the aggregated list
        if (!isset($data['aggregated_items'])) {
            $data['aggregated_items'] = [];
        }
        
        // Add the new item to the list (keep only last 10 items)
        $data['aggregated_items'][] = [
            'id' => $newData['id'] ?? null,
            'title' => $newData['title'] ?? null,
            'added_at' => now()->toISOString()
        ];
        
        // Keep only the last 10 items to prevent data bloat
        if (count($data['aggregated_items']) > 10) {
            $data['aggregated_items'] = array_slice($data['aggregated_items'], -10);
        }
        
        // Update the message to include the aggregated count
        if (isset($data['message_ar'])) {
            $data['message_ar'] = self::getAggregatedMessageAr($data['aggregated_count'], $newData['type'] ?? 'item');
        }
        if (isset($data['message_en'])) {
            $data['message_en'] = self::getAggregatedMessageEn($data['aggregated_count'], $newData['type'] ?? 'item');
        }
        
        $notification->update(['data' => $data]);
    }
    
    /**
     * Get aggregated message in Arabic
     *
     * @param int $count
     * @param string $type
     * @return string
     */
    private static function getAggregatedMessageAr(int $count, string $type): string
    {
        switch ($type) {
            case 'car':
                return "تم إضافة {$count} سيارات جديدة";
            case 'spare_part':
                return "تم إضافة {$count} قطع غيار جديدة";
            case 'car_sold':
                return "تم بيع {$count} سيارات";
            case 'car_status':
                return "تم تغيير حالة {$count} سيارات";
            default:
                return "تم إضافة {$count} عناصر جديدة";
        }
    }
    
    /**
     * Get aggregated message in English
     *
     * @param int $count
     * @param string $type
     * @return string
     */
    private static function getAggregatedMessageEn(int $count, string $type): string
    {
        switch ($type) {
            case 'car':
                return "{$count} new cars have been added";
            case 'spare_part':
                return "{$count} new spare parts have been added";
            case 'car_sold':
                return "{$count} cars have been sold";
            case 'car_status':
                return "{$count} cars have had their status changed";
            default:
                return "{$count} new items have been added";
        }
    }
    
    /**
     * Get the most recent notification of a specific type for a user
     *
     * @param User $user
     * @param string $type
     * @param int $minutes
     * @return DatabaseNotification|null
     */
    public static function getRecentNotification(User $user, string $type, int $minutes = null): ?DatabaseNotification
    {
        $config = config('notifications');
        $minutes = $minutes ?? $config['aggregation_minutes'] ?? 30;
        
        return $user->notifications()
            ->where('type', $type)
            ->where('created_at', '>=', now()->subMinutes($minutes))
            ->first();
    }
    
    /**
     * Check if aggregation is enabled for a specific notification type
     *
     * @param string $type
     * @return bool
     */
    public static function isAggregationEnabled(string $type): bool
    {
        $config = config('notifications');
        $enabledTypes = $config['aggregation_enabled_types'] ?? [
            'App\Notifications\NewCarAddedNotification',
            'App\Notifications\NewSparePartAddedNotification',
            'App\Notifications\CarSoldNotification',
            'App\Notifications\CarStatusChangedNotification'
        ];
        
        return in_array($type, $enabledTypes);
    }
} 