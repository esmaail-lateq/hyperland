<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class LanguageTest extends TestCase
{
    use RefreshDatabase;

    public function test_language_switcher_works()
    {
        // اختبار تبديل اللغة إلى العربية
        $response = $this->get('/language/ar');
        
        $response->assertRedirect();
        $this->assertEquals('ar', Session::get('locale'));
        $this->assertEquals('ar', App::getLocale());
        
        // اختبار تبديل اللغة إلى الإنجليزية
        $response = $this->get('/language/en');
        
        $response->assertRedirect();
        $this->assertEquals('en', Session::get('locale'));
        $this->assertEquals('en', App::getLocale());
    }

    public function test_invalid_language_is_ignored()
    {
        // اختبار تجاهل اللغة غير المدعومة
        $response = $this->get('/language/fr');
        
        $response->assertRedirect();
        $this->assertNull(Session::get('locale'));
    }

    public function test_default_language_is_english()
    {
        // اختبار أن اللغة الافتراضية هي الإنجليزية
        $this->assertEquals('en', App::getLocale());
    }

    public function test_translation_files_exist()
    {
        // اختبار وجود ملفات الترجمة
        $this->assertFileExists(resource_path('lang/en/cars.php'));
        $this->assertFileExists(resource_path('lang/ar/cars.php'));
        $this->assertFileExists(resource_path('lang/en/common.php'));
        $this->assertFileExists(resource_path('lang/ar/common.php'));
        $this->assertFileExists(resource_path('lang/en/navigation.php'));
        $this->assertFileExists(resource_path('lang/ar/navigation.php'));
    }

    public function test_translation_keys_work()
    {
        // اختبار عمل مفاتيح الترجمة
        App::setLocale('en');
        $this->assertEquals('Cars', __('navigation.cars'));
        $this->assertEquals('Home', __('navigation.home'));
        
        App::setLocale('ar');
        $this->assertEquals('السيارات', __('navigation.cars'));
        $this->assertEquals('الرئيسية', __('navigation.home'));
    }
}
