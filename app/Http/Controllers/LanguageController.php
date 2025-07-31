<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\LanguageHelper;

class LanguageController extends Controller
{
    public function switchLanguage($locale)
    {
        // Validate locale
        $availableLocales = ['en', 'ar'];
        
        if (!in_array($locale, $availableLocales)) {
            $locale = 'ar'; // Default to Arabic
        }
        
        // Set the locale
        LanguageHelper::setLanguage($locale);
        
        // Redirect back to previous page
        return redirect()->back();
    }
}
