<?php

namespace App\Helpers;

class LanguageHelper
{
    public static function getCurrentLanguage()
    {
        return app()->getLocale();
    }

    public static function setLanguage($language)
    {
        app()->setLocale($language);
        session()->put('locale', $language);
    }

    public static function getAvailableLanguages()
    {
        return [
            'en' => 'English',
            'ar' => 'العربية'
        ];
    }
} 