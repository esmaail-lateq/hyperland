<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Lang;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // تحسين أداء الترجمة باستخدام Cache
        $this->optimizeTranslations();
        
        // إضافة Blade directives للترجمة المحسنة
        $this->addTranslationBladeDirectives();
    }

    /**
     * تحسين أداء الترجمة
     */
    private function optimizeTranslations(): void
    {
        // Cache للترجمات لمدة ساعة واحدة
        Lang::macro('cached', function ($key, $replace = [], $locale = null) {
            $cacheKey = "translation_{$locale}_{$key}_" . md5(serialize($replace));
            
            return Cache::remember($cacheKey, 3600, function () use ($key, $replace, $locale) {
                return __($key, $replace, $locale);
            });
        });
    }

    /**
     * إضافة Blade directives للترجمة المحسنة
     */
    private function addTranslationBladeDirectives(): void
    {
        // @trans directive للترجمة المحسنة
        Blade::directive('trans', function ($expression) {
            return "<?php echo Lang::cached($expression); ?>";
        });

        // @transChoice directive للترجمة مع اختيار
        Blade::directive('transChoice', function ($expression) {
            return "<?php echo Lang::choice($expression); ?>";
        });

        // @locale directive لتعيين اللغة
        Blade::directive('locale', function ($expression) {
            return "<?php app()->setLocale($expression); ?>";
        });
    }
}
