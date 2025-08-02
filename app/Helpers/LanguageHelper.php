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
} 