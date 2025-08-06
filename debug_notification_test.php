<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Car;
use App\Services\NotificationAggregator;

echo "=== فحص مشكلة الإشعارات ===\n\n";

// 1. فحص المستخدمين
echo "1. فحص المستخدمين:\n";
$allUsers = User::where('status', 'active')->whereNotNull('email_verified_at')->get();
echo "إجمالي المستخدمين النشطين مع email_verified_at: " . $allUsers->count() . "\n";

foreach ($allUsers as $user) {
    echo "- User ID: {$user->id}, Name: {$user->name}, Role: {$user->role}, Email: {$user->email}\n";
}

echo "\n";

// 2. فحص السيارات
echo "2. فحص السيارات:\n";
$cars = Car::all();
echo "إجمالي السيارات: " . $cars->count() . "\n";

foreach ($cars as $car) {
    echo "- Car ID: {$car->id}, Title: {$car->title}, Status: {$car->status}, User ID: {$car->user_id}\n";
}

echo "\n";

// 3. محاكاة بيع سيارة
echo "3. محاكاة بيع سيارة:\n";
if ($cars->count() > 0) {
    $testCar = $cars->first();
    echo "اختبار مع السيارة: ID={$testCar->id}, Title={$testCar->title}\n";
    
    // محاكاة المستخدمين الذين سيتم إشعارهم
    $usersToNotify = User::where('status', 'active')
        ->where('id', '!=', $testCar->user_id)
        ->whereNotNull('email_verified_at')
        ->get();
    
    echo "المستخدمين الذين سيتم إشعارهم: " . $usersToNotify->count() . "\n";
    
    foreach ($usersToNotify as $user) {
        echo "- User: {$user->name} (ID: {$user->id}, Role: {$user->role})\n";
        
        // فحص التجميع
        $shouldAggregate = NotificationAggregator::shouldAggregate($user, 'App\Notifications\CarSoldNotification');
        echo "  - Should aggregate: " . ($shouldAggregate ? 'YES' : 'NO') . "\n";
        
        if ($shouldAggregate) {
            $existingNotification = NotificationAggregator::getRecentNotification($user, 'App\Notifications\CarSoldNotification');
            echo "  - Existing notification: " . ($existingNotification ? 'FOUND' : 'NOT FOUND') . "\n";
        }
        
        // فحص الإشعارات الموجودة
        $existingNotifications = $user->notifications()->where('type', 'App\Notifications\CarSoldNotification')->count();
        echo "  - Existing CarSold notifications: {$existingNotifications}\n";
    }
} else {
    echo "لا توجد سيارات للاختبار\n";
}

echo "\n";

// 4. فحص إعدادات التجميع
echo "4. فحص إعدادات التجميع:\n";
$config = config('notifications');
echo "Aggregation minutes: " . ($config['aggregation_minutes'] ?? 'NOT SET') . "\n";
echo "Enabled types:\n";
foreach ($config['aggregation_enabled_types'] ?? [] as $type) {
    echo "- {$type}\n";
}

echo "\n";

// 5. فحص قاعدة البيانات مباشرة
echo "5. فحص قاعدة البيانات مباشرة:\n";
try {
    $notificationsCount = \DB::table('notifications')->count();
    echo "إجمالي الإشعارات في قاعدة البيانات: {$notificationsCount}\n";
    
    $carSoldNotifications = \DB::table('notifications')
        ->where('type', 'App\Notifications\CarSoldNotification')
        ->count();
    echo "إشعارات بيع السيارات: {$carSoldNotifications}\n";
    
    $carStatusNotifications = \DB::table('notifications')
        ->where('type', 'App\Notifications\CarStatusChangedNotification')
        ->count();
    echo "إشعارات تغيير حالة السيارات: {$carStatusNotifications}\n";
    
} catch (Exception $e) {
    echo "خطأ في فحص قاعدة البيانات: " . $e->getMessage() . "\n";
}

echo "\n=== انتهى الفحص ===\n"; 