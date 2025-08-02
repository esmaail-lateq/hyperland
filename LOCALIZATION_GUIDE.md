# دليل الترجمة السريع - HybridLand Auto Market

## 🚀 البدء السريع

### إضافة نص جديد للترجمة

```php
// في القالب Blade
{{ __('cars.car_make') }}

// في Controller
return redirect()->back()->with('success', __('cars.created_successfully'));
```

### إضافة مفتاح ترجمة جديد

```php
// في resources/lang/en/cars.php
return [
    'car_make' => 'Car Make',
    'new_key' => 'New Translation',
];

// في resources/lang/ar/cars.php
return [
    'car_make' => 'ماركة السيارة',
    'new_key' => 'ترجمة جديدة',
];
```

## 📁 هيكل ملفات الترجمة

```
resources/lang/
├── en/
│   ├── messages.php      # الرسائل العامة
│   ├── cars.php          # نصوص السيارات
│   ├── auth.php          # المصادقة
│   ├── profile.php       # الملف الشخصي
│   ├── components.php    # مكونات الواجهة
│   ├── about.php         # صفحة من نحن
│   ├── admin.php         # لوحة الإدارة
│   ├── validation.php    # رسائل التحقق
│   ├── favorites.php     # المفضلة
│   ├── common.php        # العناصر المشتركة
│   └── forms.php         # النماذج
└── ar/
    └── [نفس الملفات بالعربية]
```

## 🔧 استخدام الترجمة

### في القوالب Blade

```php
{{ __('key') }}                    // ترجمة بسيطة
{{ __('cars.car_make') }}          // ترجمة من ملف محدد
{{ __('messages.welcome', ['name' => $user->name]) }}  // مع متغيرات
```

### في Controllers

```php
// رسائل النجاح
return redirect()->back()->with('success', __('cars.created_successfully'));

// رسائل الخطأ
return back()->withErrors(['error' => __('validation.required', ['attribute' => 'name'])]);
```

### في Validation

```php
// في Request Class
public function rules()
{
    return [
        'title' => 'required|max:255',
        'price' => 'required|numeric|min:0',
    ];
}

public function messages()
{
    return [
        'title.required' => __('validation.required', ['attribute' => __('cars.title')]),
        'price.numeric' => __('validation.numeric', ['attribute' => __('cars.price')]),
    ];
}
```

## 🌐 تبديل اللغة

### في القوالب

```php
{{-- مبدل اللغة --}}
<x-language-switcher />

{{-- رابط مباشر --}}
<a href="{{ route('language.switch', 'ar') }}">العربية</a>
<a href="{{ route('language.switch', 'en') }}">English</a>
```

### في Controllers

```php
// تبديل اللغة برمجياً
app()->setLocale('ar');
session(['locale' => 'ar']);

// الحصول على اللغة الحالية
$locale = app()->getLocale();
$isRTL = app()->getLocale() === 'ar';
```

## 📱 دعم RTL/LTR

### في التخطيط الرئيسي

```php
{{-- في layouts/app.blade.php --}}
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
```

### في CSS

```css
/* دعم RTL */
[dir="rtl"] .text-left {
    text-align: right;
}

[dir="rtl"] .ml-4 {
    margin-left: 0;
    margin-right: 1rem;
}
```

## 🧪 اختبار الترجمة

### تشغيل الاختبارات

```bash
# تشغيل جميع اختبارات الترجمة
php artisan test tests/Feature/LocalizationTest.php

# تشغيل اختبار محدد
php artisan test --filter test_language_switching_works
```

### اختبار يدوي

```bash
# مسح الكاش
php artisan config:clear
php artisan view:clear
php artisan cache:clear

# اختبار تبديل اللغة
curl -I http://localhost/language/ar
curl -I http://localhost/language/en
```

## 📝 أفضل الممارسات

### 1. تسمية المفاتيح

```php
// ✅ جيد - وصفي ومنظم
'cars.car_make' => 'Car Make',
'cars.car_model' => 'Car Model',
'auth.login' => 'Log in',
'auth.register' => 'Register',

// ❌ سيء - غير واضح
'key1' => 'Car Make',
'text_123' => 'Log in',
```

### 2. تنظيم الملفات

```php
// ✅ جيد - تنظيم حسب الوظيفة
resources/lang/en/cars.php      // كل ما يتعلق بالسيارات
resources/lang/en/auth.php      // كل ما يتعلق بالمصادقة
resources/lang/en/admin.php     // كل ما يتعلق بالإدارة

// ❌ سيء - كل شيء في ملف واحد
resources/lang/en/messages.php  // ملف ضخم يحتوي على كل شيء
```

### 3. استخدام المتغيرات

```php
// ✅ جيد - مرن وقابل للتخصيص
'welcome_message' => 'Welcome, :name!',
'items_count' => ':count items found',

// ❌ سيء - ثابت وغير مرن
'welcome_john' => 'Welcome, John!',
'items_5' => '5 items found',
```

### 4. التعليقات

```php
// ✅ جيد - توضيح السياق
return [
    // Car listing page
    'search_cars' => 'Search Cars',
    'filter_by_make' => 'Filter by Make',
    
    // Car details page
    'key_specifications' => 'Key Specifications',
    'seller_information' => 'Seller Information',
];
```

## 🚨 الأخطاء الشائعة

### 1. نسيان إضافة الترجمة العربية

```php
// ❌ خطأ - إضافة للغة الإنجليزية فقط
// resources/lang/en/cars.php
'new_key' => 'New Translation',

// ✅ صحيح - إضافة للغتين
// resources/lang/en/cars.php
'new_key' => 'New Translation',

// resources/lang/ar/cars.php
'new_key' => 'ترجمة جديدة',
```

### 2. استخدام نص ثابت بدلاً من الترجمة

```php
// ❌ خطأ
<h1>Car Details</h1>
<p>This car has been sold</p>

// ✅ صحيح
<h1>{{ __('cars.car_details') }}</h1>
<p>{{ __('components.this_car_has_been_sold') }}</p>
```

### 3. نسيان مسح الكاش

```php
// عند إضافة ترجمة جديدة، تأكد من مسح الكاش
php artisan config:clear
php artisan view:clear
php artisan cache:clear
```

## 🔍 أدوات مفيدة

### 1. البحث عن النصوص غير المترجمة

```bash
# البحث عن النصوص الإنجليزية في القوالب
grep -r ">[A-Za-z ]*<" resources/views/

# البحث عن النصوص العربية في القوالب
grep -r ">[ء-ي ]*<" resources/views/
```

### 2. التحقق من مفاتيح الترجمة

```php
// في tinker
php artisan tinker

// التحقق من وجود مفتاح
__('cars.car_make')  // يجب أن يعيد الترجمة أو المفتاح نفسه
```

### 3. إضافة مفتاح جديد بسرعة

```bash
# إنشاء ملف ترجمة جديد
php artisan make:lang-file new_section

# إضافة مفتاح لجميع اللغات
echo "'new_key' => 'New Translation'," >> resources/lang/en/new_section.php
echo "'new_key' => 'ترجمة جديدة'," >> resources/lang/ar/new_section.php
```

## 📚 مراجع إضافية

- [Laravel Localization Documentation](https://laravel.com/docs/localization)
- [RTL Support in Laravel](https://laravel.com/docs/localization#pluralization)
- [Blade Templates](https://laravel.com/docs/blade)
- [Validation Messages](https://laravel.com/docs/validation#custom-error-messages)

---

**آخر تحديث**: {{ date('Y-m-d') }}
**الإصدار**: 1.0.0 