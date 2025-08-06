<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Notification Rate Limiting Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the rate limiting configuration for notifications.
    | You can customize the limits and time windows for different notification types.
    |
    */

    'rate_limit' => [
        // Admin notifications (higher limits for important notifications)
        'car_added' => env('NOTIFICATIONS_RATE_LIMIT_CAR_ADDED', 10),
        'spare_part_added' => env('NOTIFICATIONS_RATE_LIMIT_SPARE_PART_ADDED', 10),
        
        // User notifications (lower limits to prevent spam)
        'new_car_added' => env('NOTIFICATIONS_RATE_LIMIT_NEW_CAR_ADDED', 5),
        'car_sold' => env('NOTIFICATIONS_RATE_LIMIT_CAR_SOLD', 5),
        'car_status_changed' => env('NOTIFICATIONS_RATE_LIMIT_CAR_STATUS_CHANGED', 5),
        'new_spare_part' => env('NOTIFICATIONS_RATE_LIMIT_NEW_SPARE_PART', 5),
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting Time Windows (in minutes)
    |--------------------------------------------------------------------------
    |
    | Default time window for rate limiting is 60 minutes.
    | You can customize this for different notification types.
    |
    */

    'rate_limit_time_window' => env('NOTIFICATIONS_RATE_LIMIT_TIME_WINDOW', 60),

    /*
    |--------------------------------------------------------------------------
    | Notification Aggregation Settings
    |--------------------------------------------------------------------------
    |
    | Settings for aggregating similar notifications to reduce spam.
    |
    */

    'aggregation_minutes' => env('NOTIFICATIONS_AGGREGATION_MINUTES', 30),
    
    /*
    |--------------------------------------------------------------------------
    | Aggregation Enabled Types
    |--------------------------------------------------------------------------
    |
    | Notification types that support aggregation.
    |
    */

    'aggregation_enabled_types' => [
        'App\Notifications\NewCarAddedNotification',
        'App\Notifications\NewSparePartAddedNotification',
        'App\Notifications\CarSoldNotification',
        'App\Notifications\CarStatusChangedNotification'
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    |
    | Cache settings for notification rate limiting.
    | Uses the default cache driver configured in config/cache.php
    |
    */

    'cache_prefix' => env('NOTIFICATIONS_CACHE_PREFIX', 'notification_rate_limit'),

    /*
    |--------------------------------------------------------------------------
    | Debug Mode
    |--------------------------------------------------------------------------
    |
    | Enable debug logging for notification rate limiting.
    |
    */

    'debug' => env('NOTIFICATIONS_DEBUG', false),
]; 