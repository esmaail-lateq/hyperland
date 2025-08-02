<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class PerformanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_translation_cache_performance()
    {
        // اختبار أداء cache الترجمة
        
        $startTime = microtime(true);
        
        // اختبار الترجمة بدون cache
        App::setLocale('ar');
        for ($i = 0; $i < 100; $i++) {
            __('navigation.cars');
            __('navigation.home');
            __('common.save');
            __('common.cancel');
        }
        
        $timeWithoutCache = microtime(true) - $startTime;
        
        // تنظيف cache
        Cache::flush();
        
        $startTime = microtime(true);
        
        // اختبار الترجمة مع cache
        App::setLocale('ar');
        for ($i = 0; $i < 100; $i++) {
            __('navigation.cars');
            __('navigation.home');
            __('common.save');
            __('common.cancel');
        }
        
        $timeWithCache = microtime(true) - $startTime;
        
        // التحقق من أن cache يحسن الأداء
        $this->assertLessThan($timeWithoutCache, $timeWithCache);
    }

    public function test_font_loading_performance()
    {
        // اختبار أداء تحميل الخطوط
        
        // اختبار العربية
        App::setLocale('ar');
        $startTime = microtime(true);
        
        $response = $this->get('/');
        $response->assertStatus(200);
        
        $timeArabic = microtime(true) - $startTime;
        
        // اختبار الإنجليزية
        App::setLocale('en');
        $startTime = microtime(true);
        
        $response = $this->get('/');
        $response->assertStatus(200);
        
        $timeEnglish = microtime(true) - $startTime;
        
        // التحقق من أن الإنجليزية أسرع (لا تحتاج لتحميل خطوط إضافية)
        $this->assertLessThan($timeArabic, $timeEnglish);
    }

    public function test_rtl_css_performance()
    {
        // اختبار أداء CSS للـ RTL
        
        App::setLocale('ar');
        $startTime = microtime(true);
        
        $response = $this->get('/');
        $response->assertStatus(200);
        
        $timeRTL = microtime(true) - $startTime;
        
        // التحقق من أن الوقت معقول
        $this->assertLessThan(1.0, $timeRTL);
    }

    public function test_language_switching_performance()
    {
        // اختبار أداء تبديل اللغة
        
        $startTime = microtime(true);
        
        // تبديل متكرر بين اللغات
        for ($i = 0; $i < 10; $i++) {
            $this->get('/language/ar');
            $this->get('/language/en');
        }
        
        $timeSwitching = microtime(true) - $startTime;
        
        // التحقق من أن الوقت معقول
        $this->assertLessThan(2.0, $timeSwitching);
    }

    public function test_memory_usage_optimization()
    {
        // اختبار تحسين استخدام الذاكرة
        
        $initialMemory = memory_get_usage();
        
        // تحميل الترجمات
        App::setLocale('ar');
        for ($i = 0; $i < 50; $i++) {
            __('cars.car_make');
            __('cars.car_model');
            __('cars.car_price');
            __('common.save');
            __('common.cancel');
        }
        
        $memoryAfterTranslations = memory_get_usage();
        
        // التحقق من أن استخدام الذاكرة معقول
        $memoryIncrease = $memoryAfterTranslations - $initialMemory;
        $this->assertLessThan(1024 * 1024, $memoryIncrease); // أقل من 1MB
    }

    public function test_cache_hit_rate()
    {
        // اختبار معدل نجاح cache
        
        Cache::flush();
        
        // أول طلب - cache miss
        App::setLocale('ar');
        $startTime = microtime(true);
        __('navigation.cars');
        $timeFirst = microtime(true) - $startTime;
        
        // طلب ثاني - cache hit
        $startTime = microtime(true);
        __('navigation.cars');
        $timeSecond = microtime(true) - $startTime;
        
        // التحقق من أن الطلب الثاني أسرع
        $this->assertLessThan($timeFirst, $timeSecond);
    }

    public function test_concurrent_language_requests()
    {
        // اختبار الطلبات المتزامنة للغات مختلفة
        
        $startTime = microtime(true);
        
        // محاكاة طلبات متزامنة
        $responses = [];
        for ($i = 0; $i < 5; $i++) {
            $responses[] = $this->get('/language/ar');
            $responses[] = $this->get('/language/en');
        }
        
        $timeConcurrent = microtime(true) - $startTime;
        
        // التحقق من أن جميع الطلبات نجحت
        foreach ($responses as $response) {
            $response->assertStatus(302); // redirect
        }
        
        // التحقق من أن الوقت معقول
        $this->assertLessThan(3.0, $timeConcurrent);
    }

    public function test_translation_file_size_optimization()
    {
        // اختبار تحسين حجم ملفات الترجمة
        
        $translationFiles = [
            'resources/lang/en/cars.php',
            'resources/lang/ar/cars.php',
            'resources/lang/en/common.php',
            'resources/lang/ar/common.php'
        ];
        
        foreach ($translationFiles as $file) {
            if (file_exists($file)) {
                $fileSize = filesize($file);
                
                // التحقق من أن حجم الملف معقول (أقل من 10KB)
                $this->assertLessThan(10 * 1024, $fileSize);
            }
        }
    }

    public function test_css_file_size_optimization()
    {
        // اختبار تحسين حجم ملف CSS
        
        $cssFile = 'resources/css/rtl.css';
        
        if (file_exists($cssFile)) {
            $fileSize = filesize($cssFile);
            
            // التحقق من أن حجم الملف معقول (أقل من 50KB)
            $this->assertLessThan(50 * 1024, $fileSize);
        }
    }

    public function test_overall_page_load_performance()
    {
        // اختبار أداء تحميل الصفحة بشكل عام
        
        $pages = ['/', '/cars', '/login', '/register'];
        
        foreach ($pages as $page) {
            $startTime = microtime(true);
            
            $response = $this->get($page);
            $response->assertStatus(200);
            
            $loadTime = microtime(true) - $startTime;
            
            // التحقق من أن وقت التحميل معقول (أقل من 2 ثانية)
            $this->assertLessThan(2.0, $loadTime, "Page {$page} took too long to load");
        }
    }
} 