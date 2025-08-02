<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class BrowserCompatibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_html_attributes_are_correct()
    {
        // اختبار صحة attributes في HTML
        
        // اختبار العربية
        App::setLocale('ar');
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('lang="ar"');
        $response->assertSee('dir="rtl"');
        
        // اختبار الإنجليزية
        App::setLocale('en');
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('lang="en"');
        $response->assertSee('dir="ltr"');
    }

    public function test_css_classes_are_applied_correctly()
    {
        // اختبار تطبيق CSS classes بشكل صحيح
        
        App::setLocale('ar');
        $response = $this->get('/');
        
        // اختبار وجود CSS للـ RTL
        $response->assertSee('app.css');
        
        // اختبار عدم وجود أخطاء في HTML
        $response->assertDontSee('dir=""');
        $response->assertDontSee('lang=""');
    }

    public function test_font_loading_is_conditional()
    {
        // اختبار تحميل الخطوط بشكل مشروط
        
        // اختبار العربية - يجب تحميل خط Cairo
        App::setLocale('ar');
        $response = $this->get('/');
        $response->assertSee('Cairo');
        $response->assertSee('font-family: \'Cairo\'');
        
        // اختبار الإنجليزية - لا يجب تحميل خط Cairo
        App::setLocale('en');
        $response = $this->get('/');
        $response->assertDontSee('Cairo');
        $response->assertDontSee('font-family: \'Cairo\'');
    }

    public function test_meta_tags_are_correct()
    {
        // اختبار صحة meta tags
        
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('charset="utf-8"');
        $response->assertSee('viewport');
        $response->assertSee('csrf-token');
    }

    public function test_rtl_css_selectors_are_valid()
    {
        // اختبار صحة CSS selectors للـ RTL
        
        App::setLocale('ar');
        $response = $this->get('/');
        
        // اختبار عدم وجود أخطاء في CSS
        $response->assertDontSee('[dir="rtl"] {');
        $response->assertDontSee('direction: rtl;');
        
        // يجب أن يكون CSS محمل بشكل صحيح
        $response->assertSee('app.css');
    }

    public function test_javascript_compatibility()
    {
        // اختبار توافق JavaScript
        
        $response = $this->get('/');
        
        // اختبار تحميل JavaScript
        $response->assertSee('app.js');
        
        // اختبار عدم وجود أخطاء في JavaScript
        $response->assertDontSee('console.error');
        $response->assertDontSee('undefined');
    }

    public function test_responsive_design_works()
    {
        // اختبار التصميم المتجاوب
        
        $response = $this->get('/');
        
        // اختبار وجود classes للتصميم المتجاوب
        $response->assertSee('sm:');
        $response->assertSee('md:');
        $response->assertSee('lg:');
        $response->assertSee('xl:');
    }

    public function test_accessibility_features()
    {
        // اختبار ميزات إمكانية الوصول
        
        $response = $this->get('/');
        
        // اختبار وجود aria attributes
        $response->assertSee('aria-');
        
        // اختبار وجود alt attributes للصور
        $response->assertSee('alt=');
    }

    public function test_cross_browser_compatibility()
    {
        // اختبار التوافق عبر المتصفحات
        
        $response = $this->get('/');
        
        // اختبار عدم وجود vendor prefixes غير ضرورية
        $response->assertDontSee('-webkit-');
        $response->assertDontSee('-moz-');
        $response->assertDontSee('-ms-');
        
        // اختبار استخدام CSS standards
        $response->assertSee('flex');
        $response->assertSee('grid');
    }

    public function test_performance_optimization()
    {
        // اختبار تحسينات الأداء
        
        $response = $this->get('/');
        
        // اختبار تحميل الخطوط بشكل محسن
        $response->assertSee('display=swap');
        
        // اختبار عدم وجود تحميل مزدوج للخطوط
        $response->assertDontSee('Cairo');
        $response->assertDontSee('font-family: \'Cairo\'');
        
        // اختبار العربية
        App::setLocale('ar');
        $response = $this->get('/');
        $response->assertSee('Cairo');
        $response->assertSee('font-family: \'Cairo\'');
    }
} 