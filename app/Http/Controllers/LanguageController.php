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
            
            // إضافة رسالة نجاح
            $message = $locale === 'ar' ? 'تم تغيير اللغة إلى العربية' : 'Language changed to English';
            Session::flash('success', $message);
        }

        return redirect()->back();
    }
}
