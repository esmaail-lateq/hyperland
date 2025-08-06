<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Car;

echo "=== فحص مشكلة إشعارات الإدمن الفرعي ===\n\n";

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

// 3. محاكاة سيناريوهات مختلفة
echo "3. محاكاة سيناريوهات مختلفة:\n";

if ($cars->count() > 0) {
    $testCar = $cars->first();
    echo "اختبار مع السيارة: ID={$testCar->id}, Title={$testCar->title}, Owner ID: {$testCar->user_id}\n\n";
    
    // السيناريو 1: الإدمن الفرعي يغير الحالة
    echo "السيناريو 1: الإدمن الفرعي يغير الحالة\n";
    $subAdmin = $allUsers->where('role', 'sub_admin')->first();
    if ($subAdmin) {
        echo "الإدمن الفرعي: ID={$subAdmin->id}, Name={$subAdmin->name}\n";
        
        // محاكاة الاستعلام الحالي
        $usersToNotify = User::where('status', 'active')
            ->where('id', '!=', $testCar->user_id)  // استثناء مالك السيارة
            ->where('id', '!=', $subAdmin->id)      // استثناء من غير الحالة (الإدمن الفرعي)
            ->whereNotNull('email_verified_at')
            ->get();
        
        echo "المستخدمين الذين سيتم إشعارهم: " . $usersToNotify->count() . "\n";
        foreach ($usersToNotify as $user) {
            echo "- User: {$user->name} (ID: {$user->id}, Role: {$user->role})\n";
        }
        
        // فحص إذا كان الإدمن الفرعي سيستقبل الإشعار
        $subAdminWillReceive = $usersToNotify->contains('id', $subAdmin->id);
        echo "الإدمن الفرعي سيستقبل الإشعار: " . ($subAdminWillReceive ? 'نعم' : 'لا') . "\n";
        
        if (!$subAdminWillReceive) {
            echo "❌ المشكلة: الإدمن الفرعي لن يستقبل الإشعار لأنه من غير الحالة!\n";
        }
    } else {
        echo "لا يوجد إدمن فرعي للاختبار\n";
    }
    
    echo "\n";
    
    // السيناريو 2: المستخدم العادي يغير الحالة
    echo "السيناريو 2: المستخدم العادي يغير الحالة\n";
    $regularUser = $allUsers->where('role', 'public_user')->first();
    if ($regularUser) {
        echo "المستخدم العادي: ID={$regularUser->id}, Name={$regularUser->name}\n";
        
        // محاكاة الاستعلام الحالي
        $usersToNotify = User::where('status', 'active')
            ->where('id', '!=', $testCar->user_id)  // استثناء مالك السيارة
            ->where('id', '!=', $regularUser->id)   // استثناء من غير الحالة (المستخدم العادي)
            ->whereNotNull('email_verified_at')
            ->get();
        
        echo "المستخدمين الذين سيتم إشعارهم: " . $usersToNotify->count() . "\n";
        foreach ($usersToNotify as $user) {
            echo "- User: {$user->name} (ID: {$user->id}, Role: {$user->role})\n";
        }
        
        // فحص إذا كان الإدمن الفرعي سيستقبل الإشعار
        $subAdmin = $allUsers->where('role', 'sub_admin')->first();
        if ($subAdmin) {
            $subAdminWillReceive = $usersToNotify->contains('id', $subAdmin->id);
            echo "الإدمن الفرعي سيستقبل الإشعار: " . ($subAdminWillReceive ? 'نعم' : 'لا') . "\n";
        }
    } else {
        echo "لا يوجد مستخدم عادي للاختبار\n";
    }
    
    echo "\n";
    
    // السيناريو 3: الإدمن الرئيسي يغير الحالة
    echo "السيناريو 3: الإدمن الرئيسي يغير الحالة\n";
    $mainAdmin = $allUsers->where('role', 'admin')->first();
    if ($mainAdmin) {
        echo "الإدمن الرئيسي: ID={$mainAdmin->id}, Name={$mainAdmin->name}\n";
        
        // محاكاة الاستعلام الحالي
        $usersToNotify = User::where('status', 'active')
            ->where('id', '!=', $testCar->user_id)  // استثناء مالك السيارة
            ->where('id', '!=', $mainAdmin->id)     // استثناء من غير الحالة (الإدمن الرئيسي)
            ->whereNotNull('email_verified_at')
            ->get();
        
        echo "المستخدمين الذين سيتم إشعارهم: " . $usersToNotify->count() . "\n";
        foreach ($usersToNotify as $user) {
            echo "- User: {$user->name} (ID: {$user->id}, Role: {$user->role})\n";
        }
        
        // فحص إذا كان الإدمن الفرعي سيستقبل الإشعار
        $subAdmin = $allUsers->where('role', 'sub_admin')->first();
        if ($subAdmin) {
            $subAdminWillReceive = $usersToNotify->contains('id', $subAdmin->id);
            echo "الإدمن الفرعي سيستقبل الإشعار: " . ($subAdminWillReceive ? 'نعم' : 'لا') . "\n";
        }
    } else {
        echo "لا يوجد إدمن رئيسي للاختبار\n";
    }
    
} else {
    echo "لا توجد سيارات للاختبار\n";
}

echo "\n";

// 4. الحلول المقترحة
echo "4. الحلول المقترحة:\n";
echo "أ) إزالة استثناء من غير الحالة تماماً\n";
echo "ب) استثناء من غير الحالة فقط إذا كان مستخدم عادي\n";
echo "ج) إضافة إشعارات خاصة للإدمن الفرعي\n";

echo "\n=== انتهى الفحص ===\n"; 