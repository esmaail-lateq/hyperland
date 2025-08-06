<?php

namespace App\Helpers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class LanguageHelper
{
    /**
     * الحصول على اللغة الحالية
     */
    public static function getCurrentLocale(): string
    {
        return App::getLocale();
    }

    /**
     * التحقق من أن اللغة عربية
     */
    public static function isArabic(): bool
    {
        return self::getCurrentLocale() === 'ar';
    }

    /**
     * التحقق من أن اللغة إنجليزية
     */
    public static function isEnglish(): bool
    {
        return self::getCurrentLocale() === 'en';
    }

    /**
     * الحصول على اتجاه النص
     */
    public static function getTextDirection(): string
    {
        return self::isArabic() ? 'rtl' : 'ltr';
    }

    /**
     * الحصول على اتجاه Flexbox
     */
    public static function getFlexDirection(): string
    {
        return self::isArabic() ? 'row-reverse' : 'row';
    }

    /**
     * الحصول على خط اللغة
     */
    public static function getFontFamily(): string
    {
        return self::isArabic() ? "'Cairo', sans-serif" : "'Figtree', sans-serif";
    }

    /**
     * الحصول على قائمة اللغات المدعومة
     */
    public static function getSupportedLocales(): array
    {
        return [
            'en' => [
                'name' => 'English',
                'native' => 'English',
                'flag' => '🇺🇸',
                'direction' => 'ltr'
            ],
            'ar' => [
                'name' => 'Arabic',
                'native' => 'العربية',
                'flag' => '🇸🇦',
                'direction' => 'rtl'
            ]
        ];
    }

    /**
     * التحقق من صحة اللغة
     */
    public static function isValidLocale(string $locale): bool
    {
        return array_key_exists($locale, self::getSupportedLocales());
    }

    /**
     * الحصول على معلومات اللغة
     */
    public static function getLocaleInfo(string $locale = null): array
    {
        $locale = $locale ?? self::getCurrentLocale();
        $locales = self::getSupportedLocales();
        
        return $locales[$locale] ?? $locales['en'];
    }

    /**
     * تحسين تحميل الخطوط
     */
    public static function getOptimizedFonts(): string
    {
        if (!self::isArabic()) {
            return '';
        }

        // تحسين تحميل خط Cairo
        return '<link rel="preconnect" href="https://fonts.googleapis.com">
                <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">';
    }

    /**
     * الحصول على CSS محسن للخطوط
     */
    public static function getOptimizedFontCSS(): string
    {
        if (!self::isArabic()) {
            return '';
        }

        return '<style>
            body { 
                font-family: \'Cairo\', sans-serif; 
                font-display: swap;
            }
            .font-sans { 
                font-family: \'Cairo\', sans-serif; 
            }
        </style>';
    }

    /**
     * تحسين cache للترجمات
     */
    public static function getCachedTranslation(string $key, array $replace = []): string
    {
        $cacheKey = "translation_" . self::getCurrentLocale() . "_{$key}_" . md5(serialize($replace));
        
        return Cache::remember($cacheKey, 3600, function () use ($key, $replace) {
            return __($key, $replace);
        });
    }

    /**
     * تنظيف cache الترجمة
     */
    public static function clearTranslationCache(): void
    {
        $pattern = "translation_*";
        $keys = Cache::get($pattern) ?? [];
        
        foreach ($keys as $key) {
            Cache::forget($key);
        }
    }

    /**
     * الحصول على إعدادات اللغة المحسنة
     */
    public static function getOptimizedLanguageSettings(): array
    {
        return [
            'current' => self::getCurrentLocale(),
            'direction' => self::getTextDirection(),
            'font_family' => self::getFontFamily(),
            'is_rtl' => self::isArabic(),
            'supported' => self::getSupportedLocales(),
            'fonts_loaded' => self::isArabic()
        ];
    }

    /**
     * الحصول على اسم نوع الإشعار
     */
    public static function getNotificationTypeName(string $type): string
    {
        $types = [
            'App\Notifications\CarAddedNotification' => [
                'ar' => 'إضافة سيارة جديدة',
                'en' => 'New Car Added'
            ],
            'App\Notifications\CarApprovalNotification' => [
                'ar' => 'موافقة على السيارة',
                'en' => 'Car Approval'
            ],
            'App\Notifications\CarRejectionNotification' => [
                'ar' => 'رفض السيارة',
                'en' => 'Car Rejection'
            ],
            'App\Notifications\CarSoldNotification' => [
                'ar' => 'بيع السيارة',
                'en' => 'Car Sold'
            ],
            'App\Notifications\CarStatusChangedNotification' => [
                'ar' => 'تغيير حالة السيارة',
                'en' => 'Car Status Changed'
            ],
            'App\Notifications\SparePartAddedNotification' => [
                'ar' => 'إضافة قطع غيار',
                'en' => 'Spare Part Added'
            ],
            'App\Notifications\SparePartApprovalNotification' => [
                'ar' => 'موافقة على قطع الغيار',
                'en' => 'Spare Part Approval'
            ],
            'App\Notifications\SparePartRejectionNotification' => [
                'ar' => 'رفض قطع الغيار',
                'en' => 'Spare Part Rejection'
            ],
            'App\Notifications\NewCarAddedNotification' => [
                'ar' => 'سيارة جديدة',
                'en' => 'New Car'
            ],
            'App\Notifications\NewSparePartAddedNotification' => [
                'ar' => 'قطع غيار جديدة',
                'en' => 'New Spare Part'
            ],
        ];

        $locale = self::getCurrentLocale();
        return $types[$type][$locale] ?? $types[$type]['en'] ?? 'إشعار جديد';
    }

    /**
     * الحصول على فئة badge نوع الإشعار
     */
    public static function getNotificationTypeBadgeClass(string $type): string
    {
        $classes = [
            'App\Notifications\CarAddedNotification' => 'bg-blue-100 text-blue-800',
            'App\Notifications\CarApprovalNotification' => 'bg-green-100 text-green-800',
            'App\Notifications\CarRejectionNotification' => 'bg-red-100 text-red-800',
            'App\Notifications\CarSoldNotification' => 'bg-purple-100 text-purple-800',
            'App\Notifications\CarStatusChangedNotification' => 'bg-yellow-100 text-yellow-800',
            'App\Notifications\SparePartAddedNotification' => 'bg-indigo-100 text-indigo-800',
            'App\Notifications\SparePartApprovalNotification' => 'bg-green-100 text-green-800',
            'App\Notifications\SparePartRejectionNotification' => 'bg-red-100 text-red-800',
            'App\Notifications\NewCarAddedNotification' => 'bg-blue-100 text-blue-800',
            'App\Notifications\NewSparePartAddedNotification' => 'bg-indigo-100 text-indigo-800',
        ];

        return $classes[$type] ?? 'bg-gray-100 text-gray-800';
    }
} 