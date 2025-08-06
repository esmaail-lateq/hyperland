# 🚀 الدليل السريع لفهم البرومبت - Auto-Market

## ⚡ الطريقة الأسرع لفهم المشروع

### 1. قراءة سريعة للملفات الأساسية (5 دقائق)

```bash
# 1. README.md - نظرة عامة على المشروع
# 2. composer.json - التقنيات المستخدمة
# 3. package.json - أدوات Frontend
# 4. config/app.php - إعدادات التطبيق
# 5. routes/web.php - مسارات التطبيق
```

### 2. فهم نماذج البيانات (3 دقائق)

```php
// الملفات الأساسية للنماذج
app/Models/Car.php      // نموذج السيارة
app/Models/User.php     // نموذج المستخدم
app/Models/SparePart.php // نموذج قطع الغيار
```

### 3. فهم نظام الأدوار (2 دقائق)

```php
// أنواع المستخدمين
'admin'      // مشرف رئيسي - صلاحيات كاملة
'sub_admin'  // مشرف فرعي - إضافة محتوى
'user'       // مستخدم عادي - تصفح ومفضلة
```

## 🎯 نقاط التركيز الأساسية

### ✅ ما يجب فهمه أولاً
1. **نوع التطبيق:** منصة سوق سيارات
2. **التقنية:** Laravel 10 + TailwindCSS
3. **اللغات:** العربية والإنجليزية
4. **الأدوار:** 3 أنواع مستخدمين
5. **الميزات:** إدارة السيارات، المفضلة، الإشعارات

### ❌ ما يمكن تجاهله مؤقتاً
- تفاصيل الاختبارات المتقدمة
- ملفات التكوين المعقدة
- الميزات الإضافية غير الأساسية

## 🔍 البحث السريع في الكود

### عند البحث عن وظيفة معينة:

```bash
# البحث في Controllers
grep -r "function" app/Http/Controllers/

# البحث في Models
grep -r "public function" app/Models/

# البحث في Routes
grep -r "Route::" routes/

# البحث في Views
find resources/views -name "*.blade.php" -exec grep -l "keyword" {} \;
```

### عند البحث عن ملف معين:

```bash
# البحث عن ملف Controller
find app/Http/Controllers -name "*Controller.php"

# البحث عن ملف Model
find app/Models -name "*.php"

# البحث عن ملف View
find resources/views -name "*.blade.php"
```

## 🐳 إعداد Docker السريع

### تشغيل المشروع مع Docker
```bash
# تشغيل جميع الخدمات
docker-compose up -d

# الوصول للتطبيق: http://localhost:8001
# الوصول لـ phpMyAdmin: http://localhost:8081
```

### الخدمات المتوفرة
- **Laravel App:** PHP-FPM 8.2 على المنفذ 9000
- **Nginx:** Web Server على المنفذ 8001
- **MySQL:** قاعدة البيانات على المنفذ 3306
- **phpMyAdmin:** واجهة إدارة قاعدة البيانات على المنفذ 8081

## 🛠️ الأوامر السريعة المهمة

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

# مسح الكاش
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan view:clear
```

## 📁 هيكلية سريعة للمجلدات

```
Auto-Market/
├── app/
│   ├── Http/Controllers/    # Controllers
│   ├── Models/             # Models
│   ├── Http/Middleware/    # Middleware
│   └── Services/           # Services
├── resources/
│   ├── views/              # Blade Templates
│   ├── lang/               # Translation Files
│   └── css/                # Styles
├── routes/
│   └── web.php             # Web Routes
└── database/
    └── migrations/         # Database Migrations
```

## 🎨 فهم واجهة المستخدم

### المكونات الأساسية:
- `resources/views/layouts/app.blade.php` - التخطيط الرئيسي
- `resources/views/components/` - المكونات القابلة لإعادة الاستخدام
- `resources/css/app.css` - الأنماط الرئيسية
- `resources/js/app.js` - JavaScript الرئيسي

### نظام الترجمة:
- `resources/lang/en/` - ملفات الترجمة الإنجليزية
- `resources/lang/ar/` - ملفات الترجمة العربية
- `app/Http/Middleware/SetLocale.php` - Middleware اللغة

## 🔧 إصلاح المشاكل الشائعة

### مشكلة في الترجمة:
```bash
# مسح كاش الترجمة
php artisan cache:clear
php artisan config:clear
```

### مشكلة في قاعدة البيانات:
```bash
# إعادة بناء قاعدة البيانات
php artisan migrate:fresh --seed
```

### مشكلة في الملفات الثابتة:
```bash
# إعادة إنشاء رابط التخزين
php artisan storage:link

# تجميع الأصول
npm run build
```

## 📝 نمط العمل السريع

### عند طلب ميزة جديدة:
1. **فهم المطلوب** - قراءة الطلب بدقة
2. **تحديد الملفات** - أي ملفات تحتاج تعديل
3. **التنفيذ** - كتابة الكود
4. **الاختبار** - التأكد من العمل
5. **التوثيق** - تحديث الملفات ذات الصلة

### عند إصلاح خطأ:
1. **تحديد المشكلة** - فهم سبب الخطأ
2. **البحث في الكود** - العثور على الملفات المتأثرة
3. **الإصلاح** - تطبيق الحل
4. **التحقق** - التأكد من عدم كسر شيء آخر

## 🎯 نصائح للعمل السريع

### 1. استخدم البحث الذكي
```bash
# البحث في ملف معين
grep -n "keyword" filename.php

# البحث في مجلد كامل
grep -r "keyword" app/Http/Controllers/
```

### 2. اعرف الملفات الأساسية
- `routes/web.php` - جميع المسارات
- `app/Http/Controllers/` - جميع Controllers
- `app/Models/` - جميع Models
- `resources/views/` - جميع Views

### 3. استخدم أوامر Artisan
```bash
# إنشاء Controller جديد
php artisan make:controller NewController

# إنشاء Model جديد
php artisan make:model NewModel

# إنشاء Migration جديد
php artisan make:migration create_new_table
```

### 4. اعرف نظام الأدوار
```php
// التحقق من دور المستخدم
if (auth()->user()->isAdmin()) {
    // كود للمشرف
}

if (auth()->user()->canAddContent()) {
    // كود لإضافة المحتوى
}
```

## 🚀 الاستعداد السريع للمشروع

### الطريقة الأولى: مع Docker (موصى بها)
```bash
# 1. تشغيل جميع الخدمات
docker-compose up -d

# 2. إعداد البيئة
docker-compose exec app cp .env.example .env
docker-compose exec app php artisan key:generate

# 3. إعداد قاعدة البيانات
docker-compose exec app php artisan migrate --seed
docker-compose exec app php artisan storage:link

# 4. الوصول للتطبيق
# http://localhost:8001
# http://localhost:8081 (phpMyAdmin)
```

### الطريقة الثانية: بدون Docker
```bash
# 1. تثبيت التبعيات
composer install
npm install

# 2. إعداد البيئة
cp .env.example .env
php artisan key:generate

# 3. إعداد قاعدة البيانات
php artisan migrate --seed
php artisan storage:link

# 4. تشغيل التطبيق
php artisan serve
npm run dev
```

---

**ملاحظة:** هذا الدليل مصمم للعمل السريع والفعال. استخدمه كمرجع سريع عند الحاجة لفهم أو تعديل المشروع. 