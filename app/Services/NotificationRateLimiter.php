<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class NotificationRateLimiter
{
    /**
     * Check if a notification can be sent to a user based on rate limiting
     *
     * @param User $user
     * @param string $type
     * @param int $limit
     * @param int $minutes
     * @return bool
     */
    public static function canSendNotification(User $user, string $type, int $limit = null, int $minutes = null): bool
    {
        // Get configuration values
        $config = config('notifications');
        $limit = $limit ?? $config['rate_limit'][$type] ?? 10;
        $minutes = $minutes ?? $config['rate_limit_time_window'] ?? 60;
        $prefix = $config['cache_prefix'] ?? 'notification_rate_limit';
        
        $key = "{$prefix}:{$user->id}:{$type}";
        $count = Cache::get($key, 0);
        
        if ($count >= $limit) {
            // Log rate limit hit if debug is enabled
            if ($config['debug'] ?? false) {
                \Log::info("Rate limit hit for user {$user->id}, type: {$type}, limit: {$limit}");
            }
            return false;
        }
        
        Cache::put($key, $count + 1, now()->addMinutes($minutes));
        return true;
    }
    
    /**
     * Reset the notification counter for a user and type
     *
     * @param User $user
     * @param string $type
     * @return void
     */
    public static function resetCounter(User $user, string $type): void
    {
        $config = config('notifications');
        $prefix = $config['cache_prefix'] ?? 'notification_rate_limit';
        $key = "{$prefix}:{$user->id}:{$type}";
        Cache::forget($key);
    }
    
    /**
     * Get the current notification count for a user and type
     *
     * @param User $user
     * @param string $type
     * @return int
     */
    public static function getCurrentCount(User $user, string $type): int
    {
        $config = config('notifications');
        $prefix = $config['cache_prefix'] ?? 'notification_rate_limit';
        $key = "{$prefix}:{$user->id}:{$type}";
        return Cache::get($key, 0);
    }
    
    /**
     * Get the remaining notifications allowed for a user and type
     *
     * @param User $user
     * @param string $type
     * @param int $limit
     * @return int
     */
    public static function getRemainingCount(User $user, string $type, int $limit = null): int
    {
        $config = config('notifications');
        $limit = $limit ?? $config['rate_limit'][$type] ?? 10;
        $current = self::getCurrentCount($user, $type);
        return max(0, $limit - $current);
    }
} 