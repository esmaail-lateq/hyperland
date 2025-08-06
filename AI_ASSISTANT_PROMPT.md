# 🤖 برومبت مساعد الذكاء الاصطناعي - Auto-Market

## 📋 نظرة عامة على المشروع

أنت مساعد ذكاء اصطناعي متخصص في تطوير تطبيق **Auto-Market** - منصة سوق السيارات الحديثة المبنية بـ Laravel. يجب عليك فهم السياق الكامل للمشروع والبيئة المشغلة له لتقديم حلول دقيقة ومتخصصة.

## 🏗️ هيكلية المشروع

### التقنيات المستخدمة
- **Backend:** Laravel 10.x (PHP 8.1+)
- **Frontend:** Blade Templates + TailwindCSS + Alpine.js + Vue.js 3
- **Database:** MySQL 8.0
- **Authentication:** Laravel Breeze
- **Build Tool:** Vite
- **Additional:** GSAP, Swiper, Axios
- **Containerization:** Docker (PHP-FPM 8.2, Nginx, MySQL, phpMyAdmin)

### الملفات الأساسية
- `composer.json` - إدارة التبعيات PHP
- `package.json` - إدارة التبعيات JavaScript
- `config/app.php` - إعدادات التطبيق
- `routes/web.php` - مسارات الويب
- `app/Models/` - نماذج البيانات
- `resources/views/` - قوالب Blade
- `resources/lang/` - ملفات الترجمة (ar/en)

## 🎯 الميزات الرئيسية

### للمستخدمين العاديين
- تصفح السيارات مع فلاتر متقدمة
- نظام المفضلة
- إدارة الملف الشخصي
- نظام الإشعارات

### للمديرين والمشرفين الفرعيين
- لوحة تحكم لإدارة المحتوى
- إضافة/تعديل السيارات وقطع الغيار
- نظام الموافقة على المحتوى

### للمشرفين الرئيسيين
- لوحة تحكم إدارية كاملة
- إدارة المستخدمين
- نظام الموافقة على المحتوى
- إحصائيات متقدمة

## 🌐 نظام الترجمة

### اللغات المدعومة
- **الإنجليزية (en):** اللغة الافتراضية
- **العربية (ar):** اللغة الثانية مع دعم RTL

### ملفات الترجمة
- `resources/lang/en/` - ملفات الترجمة الإنجليزية
- `resources/lang/ar/` - ملفات الترجمة العربية
- Middleware: `SetLocale` للتحكم في اللغة
- Controller: `LanguageController` لتبديل اللغة

## 👥 نظام الأدوار والصلاحيات

### أنواع المستخدمين
1. **admin** - مشرف رئيسي (إدارة كاملة)
2. **sub_admin** - مشرف فرعي (إضافة محتوى)
3. **user** - مستخدم عادي (تصفح وإضافة للمفضلة)

### الصلاحيات
- `canApproveContent()` - الموافقة على المحتوى
- `canAddContent()` - إضافة محتوى جديد
- `canManageUsers()` - إدارة المستخدمين

## 🚗 نماذج البيانات الرئيسية

### Car Model
```php
// الحقول الأساسية
'title', 'description', 'make', 'model', 'year', 'mileage', 'price',
'transmission', 'cylinders', 'fuel_type', 'condition', 'location',
'status', 'approval_status', 'is_featured'

// الميزات الإضافية
'has_air_conditioning', 'has_leather_seats', 'has_navigation',
'has_parking_sensors', 'has_parking_camera', 'has_heated_seats',
'has_bluetooth', 'has_led_lights'
```

### User Model
```php
// الحقول الأساسية
'name', 'email', 'password', 'role', 'status', 'phone', 'avatar', 'slug'
```

## 🔔 نظام الإشعارات

### أنواع الإشعارات
- Car Added/Approved/Rejected
- Spare Part Added/Approved/Rejected
- Car Sold
- Status Changes

### الميزات
- إشعارات فورية في Header
- مركز إدارة الإشعارات
- فلترة حسب النوع والحالة
- دعم البريد الإلكتروني

## 🛠️ الملفات المساعدة

### Helpers
- `app/Helpers/LanguageHelper.php` - مساعد اللغة

### Services
- `app/Services/MaerskService.php` - خدمة الشحن

### Middleware
- `AdminMiddleware` - حماية لوحة الإدارة
- `ApprovalMiddleware` - التحكم في الموافقة
- `ContentManagementMiddleware` - إدارة المحتوى
- `SetLocale` - إعداد اللغة

## 📁 هيكلية المجلدات

```
Auto-Market/
├── app/
│   ├── Console/Commands/
│   ├── Exceptions/
│   ├── Helpers/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Models/
│   ├── Notifications/
│   ├── Policies/
│   ├── Providers/
│   └── Services/
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── css/
│   ├── js/
│   ├── lang/
│   └── views/
├── routes/
├── storage/
└── tests/
```

## 🎨 واجهة المستخدم

### التصميم
- **Framework:** TailwindCSS
- **Responsive:** متجاوب مع جميع الأجهزة
- **RTL Support:** دعم كامل للغة العربية
- **Components:** مكونات Blade قابلة لإعادة الاستخدام

### المكونات الرئيسية
- `AppLayout` - التخطيط الرئيسي
- `GuestLayout` - تخطيط الضيوف
- `Navigation` - شريط التنقل
- `LanguageSwitcher` - مبدل اللغة
- `NotificationBadge` - شارة الإشعارات

## 🧪 الاختبارات

### أنواع الاختبارات
- **Feature Tests:** اختبارات الوظائف
- **Unit Tests:** اختبارات الوحدات
- **Browser Tests:** اختبارات المتصفح

### ملفات الاختبار
- `tests/Feature/` - اختبارات الوظائف
- `tests/Unit/` - اختبارات الوحدات

## 🐳 إعداد Docker

### الخدمات المتوفرة
- **app:** Laravel Application (PHP-FPM 8.2)
- **webserver:** Nginx Web Server
- **db:** MySQL 8.0 Database
- **phpmyadmin:** phpMyAdmin Interface

### أوامر Docker المهمة
```bash
# تشغيل جميع الخدمات
docker-compose up -d

# إيقاف جميع الخدمات
docker-compose down

# إعادة بناء الحاويات
docker-compose up --build

# عرض السجلات
docker-compose logs

# الدخول إلى حاوية التطبيق
docker-compose exec app bash

# الدخول إلى قاعدة البيانات
docker-compose exec db mysql -u root -p
```

### المنافذ المستخدمة
- **8001:** Nginx Web Server
- **9000:** PHP-FPM
- **3306:** MySQL Database
- **8081:** phpMyAdmin

## 🚀 أوامر Artisan المهمة

```bash
# تشغيل التطبيق (مع Docker)
docker-compose exec app php artisan serve

# إعادة بناء قاعدة البيانات
docker-compose exec app php artisan migrate:fresh --seed

# إنشاء رابط التخزين
docker-compose exec app php artisan storage:link

# تشغيل الاختبارات
docker-compose exec app php artisan test

# تحسين التطبيق
docker-compose exec app php artisan optimize
```

## 📝 إرشادات التطوير

### عند إضافة ميزات جديدة
1. **تحليل المتطلبات** - فهم المطلوب بدقة
2. **التخطيط** - تحديد الملفات المطلوب تعديلها
3. **التنفيذ** - كتابة الكود مع مراعاة المعايير
4. **الاختبار** - التأكد من عمل الميزة
5. **التوثيق** - تحديث الملفات ذات الصلة

### عند إصلاح الأخطاء
1. **تحديد المشكلة** - فهم سبب الخطأ
2. **البحث في الكود** - العثور على الملفات المتأثرة
3. **التطبيق** - إصلاح الخطأ
4. **التحقق** - التأكد من عدم كسر ميزات أخرى

### عند تحسين الأداء
1. **تحليل الأداء** - تحديد نقاط الضعف
2. **التحسين** - تطبيق الحلول المناسبة
3. **القياس** - مقارنة الأداء قبل وبعد

## 🎯 المهام المتوقعة

### تطوير الميزات
- إضافة ميزات جديدة للمستخدمين
- تحسين واجهة المستخدم
- إضافة وظائف إدارية
- تحسين نظام البحث

### الصيانة
- إصلاح الأخطاء البرمجية
- تحسين الأداء
- تحديث التبعيات
- تحسين الأمان

### التحسينات
- تحسين تجربة المستخدم
- إضافة لغات جديدة
- تحسين نظام الإشعارات
- إضافة ميزات متقدمة

## 📞 التواصل والدعم

### عند الحاجة لمساعدة إضافية
1. **تحديد المشكلة** - وصف دقيق للمشكلة
2. **تقديم السياق** - معلومات عن البيئة والحالة
3. **طلب الحل** - تحديد نوع المساعدة المطلوبة

### عند طلب ميزات جديدة
1. **وصف الميزة** - شرح مفصل للمطلوب
2. **تحديد الأولوية** - مدى أهمية الميزة
3. **تقديم الأمثلة** - أمثلة على الاستخدام المطلوب

---

**ملاحظة:** هذا البرومبت مصمم لضمان فهم دقيق وشامل للمشروع، مما يضمن تقديم حلول مناسبة ومتخصصة لجميع المهام الموكلة. 