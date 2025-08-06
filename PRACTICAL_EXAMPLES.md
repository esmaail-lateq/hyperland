# 💡 أمثلة عملية لاستخدام البرومبت - Auto-Market

## 🎯 أمثلة على المهام الشائعة

### مثال 1: إضافة ميزة جديدة للمستخدمين

**الطلب:** "أريد إضافة ميزة مقارنة السيارات للمستخدمين"

**الخطوات السريعة:**
1. **فهم المطلوب:** مقارنة بين سيارتين أو أكثر
2. **تحديد الملفات المطلوبة:**
   - `app/Http/Controllers/ComparisonController.php` (جديد)
   - `app/Models/Comparison.php` (جديد)
   - `resources/views/comparison/` (مجلد جديد)
   - `routes/web.php` (إضافة مسارات)
   - `resources/lang/ar/comparison.php` (ترجمة)
   - `resources/lang/en/comparison.php` (ترجمة)

3. **التنفيذ:**
```bash
# إنشاء Controller
php artisan make:controller ComparisonController

# إنشاء Model
php artisan make:model Comparison -m

# إنشاء مجلد Views
mkdir -p resources/views/comparison
```

### مثال 2: إصلاح خطأ في الترجمة

**المشكلة:** "النصوص لا تظهر باللغة العربية"

**الخطوات السريعة:**
1. **تحديد المشكلة:** مشكلة في نظام الترجمة
2. **البحث في الكود:**
```bash
# التحقق من Middleware
grep -r "SetLocale" app/Http/Middleware/

# التحقق من ملفات الترجمة
ls resources/lang/ar/
ls resources/lang/en/
```

3. **الإصلاح:**
```bash
# مسح الكاش
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### مثال 3: تحسين أداء البحث

**الطلب:** "البحث بطيء، أريد تحسينه"

**الخطوات السريعة:**
1. **تحليل المشكلة:** البحث في CarController
2. **البحث في الكود:**
```bash
# البحث في CarController
grep -r "search" app/Http/Controllers/CarController.php

# البحث في Car Model
grep -r "scope" app/Models/Car.php
```

3. **التحسين:**
```php
// إضافة Indexes في Migration
// تحسين Query في Controller
// إضافة Caching
```

## 🔍 أمثلة على البحث السريع

### البحث عن وظيفة معينة:

```bash
# البحث عن وظيفة إضافة سيارة
grep -r "store" app/Http/Controllers/CarController.php

# البحث عن وظيفة البحث
grep -r "search" app/Http/Controllers/

# البحث عن وظيفة المفضلة
grep -r "favorite" app/Http/Controllers/
```

### البحث عن ملف معين:

```bash
# البحث عن جميع Controllers
find app/Http/Controllers -name "*Controller.php"

# البحث عن جميع Models
find app/Models -name "*.php"

# البحث عن جميع Views
find resources/views -name "*.blade.php"
```

### البحث عن نص معين:

```bash
# البحث عن "car" في جميع الملفات
grep -r "car" app/

# البحث عن "user" في Controllers فقط
grep -r "user" app/Http/Controllers/

# البحث عن "admin" في Views فقط
grep -r "admin" resources/views/
```

## 🛠️ أمثلة على الأوامر المفيدة

### إعداد المشروع مع Docker:

```bash
# تشغيل جميع الخدمات
docker-compose up -d

# إعداد البيئة
docker-compose exec app cp .env.example .env
docker-compose exec app php artisan key:generate

# إعداد قاعدة البيانات
docker-compose exec app php artisan migrate --seed
docker-compose exec app php artisan storage:link

# الوصول للتطبيق
# http://localhost:8001 (التطبيق)
# http://localhost:8081 (phpMyAdmin)
```

### إعداد المشروع بدون Docker:

```bash
# تثبيت التبعيات
composer install
npm install

# إعداد البيئة
cp .env.example .env
php artisan key:generate

# إعداد قاعدة البيانات
php artisan migrate --seed
php artisan storage:link

# تشغيل التطبيق
php artisan serve
npm run dev
```

### إصلاح المشاكل:

```bash
# مشكلة في الكاش
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# مشكلة في قاعدة البيانات
php artisan migrate:fresh --seed

# مشكلة في الملفات الثابتة
php artisan storage:link
npm run build
```

### إنشاء ملفات جديدة:

```bash
# إنشاء Controller (مع Docker)
docker-compose exec app php artisan make:controller NewController

# إنشاء Model مع Migration (مع Docker)
docker-compose exec app php artisan make:model NewModel -m

# إنشاء Middleware (مع Docker)
docker-compose exec app php artisan make:middleware NewMiddleware

# إنشاء Request (مع Docker)
docker-compose exec app php artisan make:request NewRequest

# أو بدون Docker
php artisan make:controller NewController
php artisan make:model NewModel -m
php artisan make:middleware NewMiddleware
php artisan make:request NewRequest
```

## 📝 أمثلة على التطوير

### إضافة حقل جديد للسيارة:

1. **إنشاء Migration:**
```bash
php artisan make:migration add_new_field_to_cars_table
```

2. **تعديل Migration:**
```php
public function up()
{
    Schema::table('cars', function (Blueprint $table) {
        $table->string('new_field')->nullable();
    });
}
```

3. **تحديث Model:**
```php
// في app/Models/Car.php
protected $fillable = [
    // ... الحقول الموجودة
    'new_field',
];
```

4. **تحديث Controller:**
```php
// في app/Http/Controllers/CarController.php
public function store(Request $request)
{
    $validated = $request->validate([
        // ... القواعد الموجودة
        'new_field' => 'nullable|string',
    ]);
}
```

5. **تحديث View:**
```php
<!-- في resources/views/cars/create.blade.php -->
<div>
    <x-input-label for="new_field" :value="__('cars.new_field')" />
    <x-text-input id="new_field" name="new_field" type="text" />
</div>
```

6. **إضافة الترجمة:**
```php
// في resources/lang/ar/cars.php
'new_field' => 'الحقل الجديد',

// في resources/lang/en/cars.php
'new_field' => 'New Field',
```

### إضافة دور جديد:

1. **تحديث User Model:**
```php
// في app/Models/User.php
public function isNewRole(): bool
{
    return $this->role === 'new_role';
}
```

2. **تحديث Middleware:**
```php
// في app/Http/Middleware/AdminMiddleware.php
if (!auth()->user()->isNewRole()) {
    abort(403);
}
```

3. **تحديث Seeder:**
```php
// في database/seeders/UsersTableSeeder.php
User::create([
    'name' => 'New Role User',
    'email' => 'newrole@example.com',
    'password' => Hash::make('password'),
    'role' => 'new_role',
]);
```

## 🎨 أمثلة على واجهة المستخدم

### إضافة مكون جديد:

1. **إنشاء المكون:**
```bash
# إنشاء مجلد للمكون
mkdir -p resources/views/components/new-component
```

2. **إنشاء ملف المكون:**
```php
<!-- resources/views/components/new-component.blade.php -->
<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-lg font-semibold mb-4">{{ $title }}</h3>
    <div class="space-y-4">
        {{ $slot }}
    </div>
</div>
```

3. **استخدام المكون:**
```php
<!-- في أي View -->
<x-new-component title="{{ __('components.title') }}">
    <p>{{ __('components.content') }}</p>
</x-new-component>
```

### إضافة صفحة جديدة:

1. **إنشاء Controller:**
```bash
php artisan make:controller NewPageController
```

2. **إضافة Route:**
```php
// في routes/web.php
Route::get('/new-page', [NewPageController::class, 'index'])->name('new-page.index');
```

3. **إنشاء View:**
```php
<!-- resources/views/new-page/index.blade.php -->
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __('new_page.welcome') }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
```

## 🔧 أمثلة على إصلاح الأخطاء

### خطأ في الترجمة:

```bash
# المشكلة: النصوص لا تظهر باللغة المطلوبة
# الحل:
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### خطأ في قاعدة البيانات:

```bash
# المشكلة: خطأ في Migration
# الحل:
php artisan migrate:fresh --seed
```

### خطأ في الملفات الثابتة:

```bash
# المشكلة: الصور لا تظهر
# الحل:
php artisan storage:link
npm run build
```

### خطأ في الصلاحيات:

```php
// المشكلة: المستخدم لا يمكنه الوصول لصفحة معينة
// الحل: التحقق من Middleware
if (auth()->user()->canAddContent()) {
    // السماح بالوصول
} else {
    abort(403);
}
```

---

**ملاحظة:** هذه الأمثلة تساعد في فهم كيفية تطبيق البرومبت في مواقف عملية مختلفة. 