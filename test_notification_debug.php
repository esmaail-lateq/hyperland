<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Services\NotificationRateLimiter;

echo "=== فحص نظام الإشعارات ===\n\n";

// 1. فحص المستخدمين النشطين مع email_verified_at
echo "1. فحص المستخدمين النشطين:\n";
$activeUsers = User::where('status', 'active')->whereNotNull('email_verified_at')->get();
echo "عدد المستخدمين النشطين مع email_verified_at: " . $activeUsers->count() . "\n";

foreach ($activeUsers as $user) {
    echo "- User ID: {$user->id}, Name: {$user->name}, Role: {$user->role}, Email: {$user->email}\n";
}

echo "\n";

// 2. فحص إعدادات Rate Limiting
echo "2. فحص إعدادات Rate Limiting:\n";
$config = config('notifications');
echo "Rate limit for car_status_changed: " . ($config['rate_limit']['car_status_changed'] ?? 'NOT SET') . "\n";
echo "Time window: " . ($config['rate_limit_time_window'] ?? 'NOT SET') . " minutes\n";

echo "\n";

// 3. فحص Rate Limiting لكل مستخدم
echo "3. فحص Rate Limiting لكل مستخدم:\n";
foreach ($activeUsers as $user) {
    $canSend = NotificationRateLimiter::canSendNotification($user, 'car_status_changed');
    $currentCount = NotificationRateLimiter::getCurrentCount($user, 'car_status_changed');
    $remainingCount = NotificationRateLimiter::getRemainingCount($user, 'car_status_changed');
    
    echo "User {$user->name} (ID: {$user->id}):\n";
    echo "  - Can send notification: " . ($canSend ? 'YES' : 'NO') . "\n";
    echo "  - Current count: {$currentCount}\n";
    echo "  - Remaining count: {$remainingCount}\n";
    echo "\n";
}

// 4. فحص إعدادات التجميع
echo "4. فحص إعدادات التجميع:\n";
echo "Aggregation minutes: " . ($config['aggregation_minutes'] ?? 'NOT SET') . "\n";
echo "Enabled types:\n";
foreach ($config['aggregation_enabled_types'] ?? [] as $type) {
    echo "  - {$type}\n";
}

echo "\n=== انتهى الفحص ===\n"; 