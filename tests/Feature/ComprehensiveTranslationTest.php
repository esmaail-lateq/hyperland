<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class ComprehensiveTranslationTest extends TestCase
{
    use RefreshDatabase;

    public function test_language_switching_on_all_pages()
    {
        // اختبار تبديل اللغة في جميع الصفحات الرئيسية
        
        $pages = [
            '/',
            '/cars',
            '/cars/create',
            '/login',
            '/register',
            '/dashboard',
            '/profile',
            '/favorites',
            '/about'
        ];

        foreach ($pages as $page) {
            // اختبار تبديل إلى العربية
            $response = $this->get('/language/ar');
            $response->assertRedirect();
            
            $response = $this->get($page);
            $response->assertStatus(200);
            $response->assertSee('dir="rtl"');
            $response->assertSee('lang="ar"');
            
            // اختبار تبديل إلى الإنجليزية
            $response = $this->get('/language/en');
            $response->assertRedirect();
            
            $response = $this->get($page);
            $response->assertStatus(200);
            $response->assertSee('dir="ltr"');
            $response->assertSee('lang="en"');
        }
    }

    public function test_arabic_text_display_correctly()
    {
        // اختبار عرض النصوص العربية بشكل صحيح
        App::setLocale('ar');
        
        $response = $this->get('/');
        
        // اختبار النصوص العربية الأساسية
        $response->assertSee('الرئيسية');
        $response->assertSee('السيارات');
        $response->assertSee('المفضلة');
        $response->assertSee('الملف الشخصي');
        $response->assertSee('تسجيل الدخول');
    }

    public function test_english_text_display_correctly()
    {
        // اختبار عرض النصوص الإنجليزية بشكل صحيح
        App::setLocale('en');
        
        $response = $this->get('/');
        
        // اختبار النصوص الإنجليزية الأساسية
        $response->assertSee('Home');
        $response->assertSee('Cars');
        $response->assertSee('Favorites');
        $response->assertSee('Profile');
        $response->assertSee('Login');
    }

    public function test_rtl_support_comprehensive()
    {
        // اختبار دعم RTL شامل
        App::setLocale('ar');
        
        $response = $this->get('/');
        
        // اختبار اتجاه RTL
        $response->assertSee('dir="rtl"');
        $response->assertSee('lang="ar"');
        
        // اختبار تحميل خط Cairo
        $response->assertSee('Cairo');
        $response->assertSee('font-family: \'Cairo\'');
        
        // اختبار عدم تحميل خط Cairo في الإنجليزية
        App::setLocale('en');
        $response = $this->get('/');
        $response->assertDontSee('Cairo');
        $response->assertSee('dir="ltr"');
    }

    public function test_forms_and_validation()
    {
        // اختبار النماذج والتحقق
        
        // اختبار نموذج تسجيل الدخول بالعربية
        App::setLocale('ar');
        $response = $this->get('/login');
        $response->assertSee('البريد الإلكتروني');
        $response->assertSee('كلمة المرور');
        $response->assertSee('تسجيل الدخول');
        
        // اختبار نموذج تسجيل الدخول بالإنجليزية
        App::setLocale('en');
        $response = $this->get('/login');
        $response->assertSee('Email');
        $response->assertSee('Password');
        $response->assertSee('Log in');
        
        // اختبار نموذج إنشاء سيارة بالعربية
        App::setLocale('ar');
        $response = $this->get('/cars/create');
        $response->assertSee('ماركة السيارة');
        $response->assertSee('موديل السيارة');
        $response->assertSee('سعر السيارة');
        
        // اختبار نموذج إنشاء سيارة بالإنجليزية
        App::setLocale('en');
        $response = $this->get('/cars/create');
        $response->assertSee('Car Make');
        $response->assertSee('Car Model');
        $response->assertSee('Car Price');
    }

    public function test_messages_and_errors()
    {
        // اختبار الرسائل والأخطاء
        
        // اختبار رسائل التحقق بالعربية
        App::setLocale('ar');
        
        $response = $this->post('/login', [
            'email' => 'invalid-email',
            'password' => ''
        ]);
        
        $response->assertSessionHasErrors();
        
        // اختبار رسائل التحقق بالإنجليزية
        App::setLocale('en');
        
        $response = $this->post('/login', [
            'email' => 'invalid-email',
            'password' => ''
        ]);
        
        $response->assertSessionHasErrors();
    }

    public function test_translation_files_exist_and_work()
    {
        // اختبار وجود ملفات الترجمة وعملها
        
        $translationFiles = [
            'resources/lang/en/cars.php',
            'resources/lang/ar/cars.php',
            'resources/lang/en/common.php',
            'resources/lang/ar/common.php',
            'resources/lang/en/navigation.php',
            'resources/lang/ar/navigation.php',
            'resources/lang/en/home.php',
            'resources/lang/ar/home.php',
            'resources/lang/en/forms.php',
            'resources/lang/ar/forms.php',
            'resources/lang/en/messages.php',
            'resources/lang/ar/messages.php'
        ];
        
        foreach ($translationFiles as $file) {
            $this->assertFileExists($file);
        }
        
        // اختبار عمل مفاتيح الترجمة
        App::setLocale('en');
        $this->assertEquals('Cars', __('navigation.cars'));
        $this->assertEquals('Home', __('navigation.home'));
        
        App::setLocale('ar');
        $this->assertEquals('السيارات', __('navigation.cars'));
        $this->assertEquals('الرئيسية', __('navigation.home'));
    }

    public function test_language_persistence()
    {
        // اختبار استمرارية اللغة في الجلسة
        
        // تبديل إلى العربية
        $response = $this->get('/language/ar');
        $response->assertRedirect();
        
        $this->assertEquals('ar', Session::get('locale'));
        $this->assertEquals('ar', App::getLocale());
        
        // التحقق من استمرارية اللغة في الطلبات اللاحقة
        $response = $this->get('/');
        $response->assertSee('dir="rtl"');
        $response->assertSee('lang="ar"');
        
        // تبديل إلى الإنجليزية
        $response = $this->get('/language/en');
        $response->assertRedirect();
        
        $this->assertEquals('en', Session::get('locale'));
        $this->assertEquals('en', App::getLocale());
        
        // التحقق من استمرارية اللغة
        $response = $this->get('/');
        $response->assertSee('dir="ltr"');
        $response->assertSee('lang="en"');
    }

    public function test_invalid_language_handling()
    {
        // اختبار التعامل مع اللغات غير المدعومة
        
        $response = $this->get('/language/fr');
        $response->assertRedirect();
        
        // يجب أن تبقى اللغة الافتراضية
        $this->assertEquals('en', App::getLocale());
    }

    public function test_default_language_fallback()
    {
        // اختبار الرجوع للغة الافتراضية
        
        // مسح الجلسة
        Session::forget('locale');
        
        $response = $this->get('/');
        $response->assertSee('dir="ltr"');
        $response->assertSee('lang="en"');
        
        $this->assertEquals('en', App::getLocale());
    }

    public function test_car_specific_translations()
    {
        // اختبار الترجمات الخاصة بالسيارات
        
        // اختبار بالعربية
        App::setLocale('ar');
        $response = $this->get('/cars');
        $response->assertSee('البحث عن السيارات');
        $response->assertSee('ماركة السيارة');
        $response->assertSee('موديل السيارة');
        $response->assertSee('سعر السيارة');
        
        // اختبار بالإنجليزية
        App::setLocale('en');
        $response = $this->get('/cars');
        $response->assertSee('Search Cars');
        $response->assertSee('Car Make');
        $response->assertSee('Car Model');
        $response->assertSee('Car Price');
    }

    public function test_common_translations()
    {
        // اختبار الترجمات المشتركة
        
        // اختبار بالعربية
        App::setLocale('ar');
        $this->assertEquals('حفظ', __('common.save'));
        $this->assertEquals('إلغاء', __('common.cancel'));
        $this->assertEquals('تحرير', __('common.edit'));
        $this->assertEquals('حذف', __('common.delete'));
        
        // اختبار بالإنجليزية
        App::setLocale('en');
        $this->assertEquals('Save', __('common.save'));
        $this->assertEquals('Cancel', __('common.cancel'));
        $this->assertEquals('Edit', __('common.edit'));
        $this->assertEquals('Delete', __('common.delete'));
    }
} 