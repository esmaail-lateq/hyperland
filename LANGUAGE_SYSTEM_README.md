# نظام الترجمة - المرحلة الخامسة: إعداد Middleware والتحكم

## نظرة عامة

تم إكمال المرحلة الخامسة من نظام الترجمة بنجاح! هذه المرحلة تركز على إعداد Middleware والتحكم في تبديل اللغة.

## الملفات المحدثة/المضافة

### 1. SetLocale Middleware
**الملف:** `app/Http/Middleware/SetLocale.php`

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // التحقق من وجود لغة محفوظة في الجلسة
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        } else {
            // استخدام اللغة الافتراضية
            App::setLocale('en');
        }

        return $next($request);
    }
}
```

### 2. LanguageController
**الملف:** `app/Http/Controllers/LanguageController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    public function switch($locale)
    {
        // التحقق من أن اللغة مدعومة
        $supportedLocales = ['en', 'ar'];
        
        if (in_array($locale, $supportedLocales)) {
            Session::put('locale', $locale);
            App::setLocale($locale);
        }

        return redirect()->back();
    }
}
```

### 3. Routes
**الملف:** `routes/web.php`

```php
// Language routes
Route::get('language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');
```

### 4. Kernel Configuration
**الملف:** `app/Http/Kernel.php`

تم إضافة SetLocale middleware إلى مجموعة الـ web middleware:

```php
'web' => [
    // ... other middleware
    \App\Http\Middleware\SetLocale::class,
],
```

### 5. Language Switcher Component
**الملف:** `resources/views/components/header.blade.php`

تم إضافة Language Switcher في Header:

```php
<!-- Glassmorphism Language Switcher - Fully Rounded -->
<div class="flex items-center bg-white/20 dark:bg-slate-800/20 backdrop-blur-xl rounded-full p-1 shadow-lg shadow-black/10 dark:shadow-black/20 border border-white/30 dark:border-slate-600/30">
    @php
        $currentLocale = app()->getLocale();
        $availableLocales = ['en' => 'EN', 'ar' => 'عربي'];
    @endphp
    
    @foreach($availableLocales as $locale => $name)
        <a href="{{ route('language.switch', $locale) }}" 
           class="px-4 py-2 text-sm font-bold rounded-full transition-all duration-300 {{ $currentLocale === $locale ? 'bg-white/80 dark:bg-slate-700/80 text-slate-800 dark:text-slate-200 shadow-md' : 'text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-white/40 dark:hover:bg-slate-700/40' }}">
            <div class="flex items-center space-x-1">
                <div class="w-2.5 h-2.5 rounded-full {{ $currentLocale === $locale ? 'bg-blue-500 dark:bg-blue-400' : 'bg-slate-400 dark:bg-slate-500' }}"></div>
                <span>{{ $name }}</span>
            </div>
        </a>
    @endforeach
</div>
```

## كيفية العمل

### 1. تبديل اللغة
- المستخدم ينقر على Language Switcher في Header
- يتم توجيه الطلب إلى `language.switch` route
- LanguageController يتحقق من صحة اللغة
- يتم حفظ اللغة في Session
- يتم تعيين اللغة للتطبيق
- العودة للصفحة السابقة

### 2. Middleware
- SetLocale middleware يعمل على كل طلب
- يتحقق من وجود لغة محفوظة في Session
- إذا وجدت، يتم تعيينها للتطبيق
- إذا لم توجد، يتم استخدام اللغة الافتراضية (الإنجليزية)

### 3. اللغات المدعومة
- **الإنجليزية (en):** اللغة الافتراضية
- **العربية (ar):** اللغة الثانية المدعومة

## الاختبارات

تم إنشاء ملف اختبار `tests/Feature/LanguageTest.php` للتحقق من:

1. **تبديل اللغة:** اختبار تبديل اللغة بين العربية والإنجليزية
2. **اللغة غير المدعومة:** اختبار تجاهل اللغات غير المدعومة
3. **اللغة الافتراضية:** اختبار أن اللغة الافتراضية هي الإنجليزية
4. **ملفات الترجمة:** اختبار وجود جميع ملفات الترجمة
5. **مفاتيح الترجمة:** اختبار عمل مفاتيح الترجمة

## المميزات

### ✅ مكتمل
- [x] SetLocale Middleware
- [x] LanguageController
- [x] Routes للغة
- [x] Language Switcher في Header
- [x] دعم اللغتين العربية والإنجليزية
- [x] حفظ اللغة في Session
- [x] اختبارات شاملة
- [x] تصميم جميل ومتجاوب

### 🎯 النتيجة
- نظام ترجمة كامل ومتكامل
- واجهة مستخدم سهلة لتبديل اللغة
- حفظ تفضيلات المستخدم
- اختبارات شاملة لضمان الجودة
- تصميم متجاوب يعمل على جميع الأجهزة

## الاستخدام

### للمطورين
```php
// تبديل اللغة برمجياً
App::setLocale('ar');
Session::put('locale', 'ar');

// الحصول على اللغة الحالية
$currentLocale = App::getLocale();

// استخدام الترجمة
echo __('navigation.home'); // الرئيسية
```

### للمستخدمين
1. انقر على Language Switcher في Header
2. اختر اللغة المطلوبة (EN أو عربي)
3. سيتم حفظ تفضيلك تلقائياً
4. جميع النصوص ستظهر باللغة المختارة

## المراحل السابقة

- **المرحلة الأولى:** إعداد ملفات الترجمة الأساسية ✅
- **المرحلة الثانية:** ترجمة النصوص الأساسية ✅
- **المرحلة الثالثة:** ترجمة النماذج والرسائل ✅
- **المرحلة الرابعة:** تحديث النصوص لتستخدم الترجمة ✅
- **المرحلة الخامسة:** إعداد Middleware والتحكم ✅

## المرحلة التالية

المرحلة السادسة ستتضمن:
- تحسينات إضافية على واجهة المستخدم
- إضافة لغات جديدة
- تحسين الأداء
- إضافة ميزات متقدمة

---

**تم إكمال المرحلة الخامسة بنجاح! 🎉** 