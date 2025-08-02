<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class RTLTest extends TestCase
{
    use RefreshDatabase;

    public function test_rtl_direction_is_set_for_arabic()
    {
        // اختبار تعيين اتجاه RTL للعربية
        App::setLocale('ar');
        
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('dir="rtl"');
        $response->assertSee('lang="ar"');
    }

    public function test_ltr_direction_is_set_for_english()
    {
        // اختبار تعيين اتجاه LTR للإنجليزية
        App::setLocale('en');
        
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('dir="ltr"');
        $response->assertSee('lang="en"');
    }

    public function test_arabic_font_is_loaded_for_arabic()
    {
        // اختبار تحميل خط Cairo للعربية
        App::setLocale('ar');
        
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('Cairo');
        $response->assertSee('font-family: \'Cairo\'');
    }

    public function test_arabic_font_is_not_loaded_for_english()
    {
        // اختبار عدم تحميل خط Cairo للإنجليزية
        App::setLocale('en');
        
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertDontSee('Cairo');
        $response->assertDontSee('font-family: \'Cairo\'');
    }

    public function test_rtl_css_file_is_loaded()
    {
        // اختبار تحميل ملف CSS للـ RTL
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('app.css');
    }

    public function test_rtl_works_on_all_layouts()
    {
        // اختبار عمل RTL على جميع Layouts
        
        // اختبار app layout
        App::setLocale('ar');
        $response = $this->get('/dashboard');
        $response->assertSee('dir="rtl"');
        
        // اختبار guest layout
        $response = $this->get('/login');
        $response->assertSee('dir="rtl"');
        
        // اختبار welcome page
        $response = $this->get('/');
        $response->assertSee('dir="rtl"');
    }

    public function test_language_switcher_works_with_rtl()
    {
        // اختبار عمل Language Switcher مع RTL
        
        // تبديل إلى العربية
        $response = $this->get('/language/ar');
        $response->assertRedirect();
        
        // التحقق من أن الصفحة تستخدم RTL
        $response = $this->get('/');
        $response->assertSee('dir="rtl"');
        
        // تبديل إلى الإنجليزية
        $response = $this->get('/language/en');
        $response->assertRedirect();
        
        // التحقق من أن الصفحة تستخدم LTR
        $response = $this->get('/');
        $response->assertSee('dir="ltr"');
    }
} 