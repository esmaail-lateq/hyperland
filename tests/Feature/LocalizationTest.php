<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Car;

class LocalizationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_language_switching_works()
    {
        // Test switching to Arabic
        $response = $this->get('/language/ar');
        $response->assertRedirect();
        $this->assertEquals('ar', app()->getLocale());

        // Test switching to English
        $response = $this->get('/language/en');
        $response->assertRedirect();
        $this->assertEquals('en', app()->getLocale());
    }

    public function test_home_page_translations()
    {
        // Test English
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('HybridLand');
        $response->assertSee('Auto Market');

        // Test Arabic
        $this->get('/language/ar');
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('HybridLand');
    }

    public function test_navigation_translations()
    {
        // Test English navigation
        $response = $this->get('/');
        $response->assertSee('Home');
        $response->assertSee('Cars');
        $response->assertSee('About');

        // Test Arabic navigation
        $this->get('/language/ar');
        $response = $this->get('/');
        $response->assertSee('الرئيسية');
        $response->assertSee('السيارات');
        $response->assertSee('من نحن');
    }

    public function test_cars_page_translations()
    {
        // Create a test car
        $car = Car::factory()->create([
            'title' => 'Test Car',
            'make' => 'Toyota',
            'model' => 'Camry',
            'year' => 2020,
            'price' => 25000,
            'mileage' => 50000,
            'fuel_type' => 'gasoline',
            'transmission' => 'automatic',
            'condition' => 'excellent',
            'status' => 'available',
            'location' => 'Riyadh',
            'cylinders' => 4,
        ]);

        // Test English cars page
        $response = $this->get('/cars');
        $response->assertStatus(200);
        $response->assertSee('Car Make');
        $response->assertSee('Min Price');
        $response->assertSee('Max Price');
        $response->assertSee('SEARCH CARS');

        // Test Arabic cars page
        $this->get('/language/ar');
        $response = $this->get('/cars');
        $response->assertStatus(200);
        $response->assertSee('ماركة السيارة');
        $response->assertSee('السعر الأدنى');
        $response->assertSee('السعر الأقصى');
        $response->assertSee('البحث في السيارات');
    }

    public function test_car_details_translations()
    {
        $car = Car::factory()->create([
            'title' => 'Test Car',
            'make' => 'Toyota',
            'model' => 'Camry',
            'year' => 2020,
            'price' => 25000,
            'mileage' => 50000,
            'fuel_type' => 'gasoline',
            'transmission' => 'automatic',
            'condition' => 'excellent',
            'status' => 'available',
            'location' => 'Riyadh',
            'cylinders' => 4,
        ]);

        // Test English car details
        $response = $this->get("/cars/{$car->id}");
        $response->assertStatus(200);
        $response->assertSee('Key Specifications');
        $response->assertSee('Make');
        $response->assertSee('Model');
        $response->assertSee('Year');

        // Test Arabic car details
        $this->get('/language/ar');
        $response = $this->get("/cars/{$car->id}");
        $response->assertStatus(200);
        $response->assertSee('المواصفات الرئيسية');
        $response->assertSee('الماركة');
        $response->assertSee('الموديل');
        $response->assertSee('السنة');
    }

    public function test_authentication_translations()
    {
        // Test English login page
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Email');
        $response->assertSee('Password');
        $response->assertSee('Remember me');
        $response->assertSee('Log in');

        // Test Arabic login page
        $this->get('/language/ar');
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('البريد الإلكتروني');
        $response->assertSee('كلمة المرور');
        $response->assertSee('تذكرني');
        $response->assertSee('تسجيل الدخول');
    }

    public function test_profile_translations()
    {
        $user = User::factory()->create();
        
        // Test English profile page
        $response = $this->actingAs($user)->get('/profile');
        $response->assertStatus(200);
        $response->assertSee('Profile');
        $response->assertSee('Profile Picture');
        $response->assertSee('Update');

        // Test Arabic profile page
        $this->get('/language/ar');
        $response = $this->actingAs($user)->get('/profile');
        $response->assertStatus(200);
        $response->assertSee('الملف الشخصي');
        $response->assertSee('صورة الملف الشخصي');
        $response->assertSee('تحديث');
    }

    public function test_favorites_translations()
    {
        $user = User::factory()->create();
        
        // Test English favorites page
        $response = $this->actingAs($user)->get('/favorites');
        $response->assertStatus(200);
        $response->assertSee('My Favorite Cars');
        $response->assertSee('No favorite cars yet');

        // Test Arabic favorites page
        $this->get('/language/ar');
        $response = $this->actingAs($user)->get('/favorites');
        $response->assertStatus(200);
        $response->assertSee('سياراتي المفضلة');
        $response->assertSee('لا توجد سيارات مفضلة بعد');
    }

    public function test_about_page_translations()
    {
        // Test English about page
        $response = $this->get('/about');
        $response->assertStatus(200);
        $response->assertSee('Our Mission');
        $response->assertSee('Our Vision');
        $response->assertSee('Our Core Values');

        // Test Arabic about page
        $this->get('/language/ar');
        $response = $this->get('/about');
        $response->assertStatus(200);
        $response->assertSee('مهمتنا');
        $response->assertSee('رؤيتنا');
        $response->assertSee('قيمنا الأساسية');
    }

    public function test_rtl_support_for_arabic()
    {
        // Test that Arabic pages have RTL direction
        $this->get('/language/ar');
        $response = $this->get('/');
        $response->assertSee('dir="rtl"');
        
        // Test that English pages have LTR direction
        $this->get('/language/en');
        $response = $this->get('/');
        $response->assertSee('dir="ltr"');
    }

    public function test_language_persistence_in_session()
    {
        // Set language to Arabic
        $this->get('/language/ar');
        $this->assertEquals('ar', session('locale'));
        
        // Set language to English
        $this->get('/language/en');
        $this->assertEquals('en', session('locale'));
    }

    public function test_language_settings_page()
    {
        $user = User::factory()->create();
        
        // Test English settings page
        $response = $this->actingAs($user)->get('/language/settings');
        $response->assertStatus(200);
        $response->assertSee('Language Settings');
        $response->assertSee('Choose your preferred language');

        // Test Arabic settings page
        $this->get('/language/ar');
        $response = $this->actingAs($user)->get('/language/settings');
        $response->assertStatus(200);
        $response->assertSee('إعدادات اللغة');
        $response->assertSee('اختر لغتك المفضلة');
    }

    public function test_flash_messages_translations()
    {
        $user = User::factory()->create();
        $car = Car::factory()->create();

        // Test English flash messages
        $response = $this->actingAs($user)->post("/favorites/{$car->id}");
        $response->assertRedirect();
        $this->assertTrue(session()->has('success'));

        // Test Arabic flash messages
        $this->get('/language/ar');
        $response = $this->actingAs($user)->post("/favorites/{$car->id}");
        $response->assertRedirect();
        $this->assertTrue(session()->has('success'));
    }

    public function test_validation_messages_translations()
    {
        // Test English validation messages
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'invalid-email',
            'password' => '123',
        ]);
        $response->assertSessionHasErrors();

        // Test Arabic validation messages
        $this->get('/language/ar');
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'invalid-email',
            'password' => '123',
        ]);
        $response->assertSessionHasErrors();
    }
} 