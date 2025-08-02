# نظام الإشعارات - Notification System

## نظرة عامة

تم تطوير نظام إشعارات شامل لإدارة التواصل بين المستخدمين في نظام بيع السيارات. النظام يضمن إرسال إشعارات فورية عند إضافة أو مراجعة المحتوى.

## أنواع الإشعارات

### 1. إشعارات إضافة المحتوى (Sub-Admin → Admin)

#### CarAddedNotification
- **الغرض**: إشعار الادمن الرئيسي عند إضافة سيارة جديدة من الادمن الفرعي
- **المستقبل**: جميع الادمن الرئيسي النشطين
- **القنوات**: Email, Database, Broadcast
- **المحتوى**: تفاصيل السيارة، اسم المضيف، رابط المراجعة

#### SparePartAddedNotification
- **الغرض**: إشعار الادمن الرئيسي عند إضافة قطعة غيار جديدة من الادمن الفرعي
- **المستقبل**: جميع الادمن الرئيسي النشطين
- **القنوات**: Email, Database, Broadcast
- **المحتوى**: تفاصيل قطعة الغيار، اسم المضيف، رابط المراجعة

### 2. إشعارات الموافقة (Admin → User)

#### CarApprovalNotification
- **الغرض**: إشعار مالك السيارة عند الموافقة على إعلانه
- **المستقبل**: مالك السيارة
- **القنوات**: Email, Database, Broadcast
- **المحتوى**: تفاصيل السيارة، اسم الموافق، رسالة تهنئة

#### SparePartApprovalNotification
- **الغرض**: إشعار مالك قطعة الغيار عند الموافقة على طلبه
- **المستقبل**: مالك قطعة الغيار
- **القنوات**: Email, Database, Broadcast
- **المحتوى**: تفاصيل قطعة الغيار، اسم الموافق، رسالة تهنئة

### 3. إشعارات الرفض (Admin → User)

#### CarRejectionNotification
- **الغرض**: إشعار مالك السيارة عند رفض إعلانه
- **المستقبل**: مالك السيارة
- **القنوات**: Email, Database, Broadcast
- **المحتوى**: تفاصيل السيارة، اسم الرافض، رسالة توضيحية

#### SparePartRejectionNotification
- **الغرض**: إشعار مالك قطعة الغيار عند رفض طلبه
- **المستقبل**: مالك قطعة الغيار
- **القنوات**: Email, Database, Broadcast
- **المحتوى**: تفاصيل قطعة الغيار، اسم الرافض، رسالة توضيحية

## كيفية عمل النظام

### عند إضافة سيارة جديدة (CarController::store)

```php
// Send notification to main admin if car is added by sub-admin
if (auth()->user()->isSubAdmin()) {
    try {
        $mainAdmins = User::where('role', 'admin')->where('status', 'active')->get();
        foreach ($mainAdmins as $admin) {
            $admin->notify(new \App\Notifications\CarAddedNotification($car, auth()->user()));
        }
    } catch (\Exception $e) {
        \Log::error('Failed to send car added notification: ' . $e->getMessage());
    }
}
```

### عند إضافة قطعة غيار جديدة (SparePartController::store)

```php
// Send notification to main admin if spare part is added by sub-admin
if (Auth::user()->isSubAdmin()) {
    try {
        $mainAdmins = User::where('role', 'admin')->where('status', 'active')->get();
        foreach ($mainAdmins as $admin) {
            $admin->notify(new \App\Notifications\SparePartAddedNotification($sparePart, Auth::user()));
        }
    } catch (\Exception $e) {
        \Log::error('Failed to send spare part added notification: ' . $e->getMessage());
    }
}
```

### عند الموافقة على السيارة (UnifiedCarController::approve)

```php
// Send notification to car owner
try {
    $car->user->notify(new \App\Notifications\CarApprovalNotification($car, auth()->user()));
} catch (\Exception $e) {
    \Log::error('Failed to send car approval notification: ' . $e->getMessage());
}
```

### عند رفض السيارة (UnifiedCarController::reject)

```php
// Send notification to car owner
try {
    $car->user->notify(new \App\Notifications\CarRejectionNotification($car, auth()->user()));
} catch (\Exception $e) {
    \Log::error('Failed to send car rejection notification: ' . $e->getMessage());
}
```

## الملفات المضافة/المحدثة

### ملفات الإشعارات الجديدة
- `app/Notifications/CarAddedNotification.php`
- `app/Notifications/SparePartAddedNotification.php`
- `app/Notifications/CarRejectionNotification.php`
- `app/Notifications/SparePartApprovalNotification.php`
- `app/Notifications/SparePartRejectionNotification.php`

### Controllers المحدثة
- `app/Http/Controllers/CarController.php` - إضافة إشعار عند إضافة سيارة
- `app/Http/Controllers/SparePartController.php` - إضافة إشعار عند إضافة قطعة غيار
- `app/Http/Controllers/UnifiedCarController.php` - إضافة إشعارات الموافقة والرفض

## اختبار النظام

### اختبار شامل
```bash
docker compose exec app php test_notifications.php
```

### اختبار السيناريو الحقيقي
```bash
docker compose exec app php test_real_scenario.php
```

### اختبار نهائي
```bash
docker compose exec app php final_test.php
```

## متطلبات النظام

1. **Queue Worker**: يجب تشغيل queue worker لمعالجة الإشعارات
   ```bash
   docker compose exec app php artisan queue:work --daemon
   ```

2. **Database**: تأكد من وجود جدول notifications
   ```bash
   docker compose exec app php artisan migrate
   ```

3. **Mail Configuration**: تأكد من إعداد البريد الإلكتروني في `.env`

## تدفق العمل

### سيناريو إضافة سيارة
1. الادمن الفرعي يضيف سيارة جديدة
2. النظام يرسل إشعار للادمن الرئيسي
3. الادمن الرئيسي يراجع السيارة
4. عند الموافقة/الرفض، يتم إرسال إشعار لمالك السيارة

### سيناريو إضافة قطعة غيار
1. الادمن الفرعي يضيف قطعة غيار جديدة
2. النظام يرسل إشعار للادمن الرئيسي
3. الادمن الرئيسي يراجع قطعة الغيار
4. عند الموافقة/الرفض، يتم إرسال إشعار لمالك قطعة الغيار

## الدعم متعدد اللغات

جميع الإشعارات تدعم اللغتين العربية والإنجليزية:
- الرسائل العربية: `message_ar`
- الرسائل الإنجليزية: `message_en`
- يتم اختيار اللغة بناءً على إعدادات التطبيق

## الأمان والموثوقية

- جميع الإشعارات تستخدم try-catch للتعامل مع الأخطاء
- يتم تسجيل الأخطاء في logs
- الإشعارات تعمل في الخلفية (Queue) لتجنب تأخير الاستجابة
- يتم التحقق من صلاحيات المستخدم قبل إرسال الإشعارات

## استكشاف الأخطاء

### مشاكل شائعة
1. **عدم وصول الإشعارات**: تأكد من تشغيل queue worker
2. **أخطاء في البريد**: تحقق من إعدادات SMTP
3. **إشعارات مكررة**: تحقق من عدم وجود duplicate notifications

### فحص حالة النظام
```bash
# فحص الإشعارات في قاعدة البيانات
docker compose exec app php artisan tinker
>>> App\Models\User::find(1)->notifications()->count()

# فحص queue jobs
docker compose exec app php artisan queue:work --once
```

## التطوير المستقبلي

- إضافة إشعارات للمستخدمين العاديين عند إضافة سيارات
- إشعارات التحديثات والتغييرات
- إشعارات النظام والصيانة
- إشعارات مخصصة حسب تفضيلات المستخدم 