<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;

class OptimizeTranslations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations:optimize {--clear-cache : Clear translation cache} {--preload : Preload all translations}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize translation files and cache for better performance';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Starting translation optimization...');

        // تنظيف cache إذا طُلب
        if ($this->option('clear-cache')) {
            $this->clearTranslationCache();
        }

        // تحميل مسبق للترجمات إذا طُلب
        if ($this->option('preload')) {
            $this->preloadTranslations();
        }

        // تحسين ملفات الترجمة
        $this->optimizeTranslationFiles();

        // إنشاء cache للترجمات
        $this->createTranslationCache();

        $this->info('✅ Translation optimization completed successfully!');
    }

    /**
     * تنظيف cache الترجمة
     */
    private function clearTranslationCache(): void
    {
        $this->info('🧹 Clearing translation cache...');
        
        $keys = Cache::get('translation_keys') ?? [];
        foreach ($keys as $key) {
            Cache::forget($key);
        }
        
        Cache::forget('translation_keys');
        $this->info('✅ Translation cache cleared.');
    }

    /**
     * تحميل مسبق للترجمات
     */
    private function preloadTranslations(): void
    {
        $this->info('📚 Preloading translations...');
        
        $locales = ['en', 'ar'];
        $translationFiles = ['cars', 'common', 'navigation', 'home', 'forms', 'messages'];
        
        foreach ($locales as $locale) {
            foreach ($translationFiles as $file) {
                $path = resource_path("lang/{$locale}/{$file}.php");
                
                if (File::exists($path)) {
                    $translations = require $path;
                    $this->cacheTranslations($translations, $locale, $file);
                }
            }
        }
        
        $this->info('✅ Translations preloaded.');
    }

    /**
     * تحسين ملفات الترجمة
     */
    private function optimizeTranslationFiles(): void
    {
        $this->info('🔧 Optimizing translation files...');
        
        $locales = ['en', 'ar'];
        
        foreach ($locales as $locale) {
            $langPath = resource_path("lang/{$locale}");
            
            if (File::exists($langPath)) {
                $files = File::files($langPath);
                
                foreach ($files as $file) {
                    $this->optimizeTranslationFile($file->getPathname());
                }
            }
        }
        
        $this->info('✅ Translation files optimized.');
    }

    /**
     * تحسين ملف ترجمة واحد
     */
    private function optimizeTranslationFile(string $filePath): void
    {
        $content = File::get($filePath);
        
        // إزالة التعليقات غير الضرورية
        $content = preg_replace('/\/\*.*?\*\//s', '', $content);
        $content = preg_replace('/\/\/.*$/m', '', $content);
        
        // إزالة المسافات الزائدة
        $content = preg_replace('/\s+/', ' ', $content);
        $content = trim($content);
        
        File::put($filePath, $content);
    }

    /**
     * إنشاء cache للترجمات
     */
    private function createTranslationCache(): void
    {
        $this->info('💾 Creating translation cache...');
        
        $locales = ['en', 'ar'];
        $translationFiles = ['cars', 'common', 'navigation', 'home', 'forms', 'messages'];
        
        foreach ($locales as $locale) {
            foreach ($translationFiles as $file) {
                $path = resource_path("lang/{$locale}/{$file}.php");
                
                if (File::exists($path)) {
                    $translations = require $path;
                    $this->cacheTranslations($translations, $locale, $file);
                }
            }
        }
        
        $this->info('✅ Translation cache created.');
    }

    /**
     * Cache الترجمات
     */
    private function cacheTranslations(array $translations, string $locale, string $file): void
    {
        foreach ($translations as $key => $value) {
            $cacheKey = "translation_{$locale}_{$file}_{$key}";
            Cache::put($cacheKey, $value, 3600); // ساعة واحدة
            
            // حفظ قائمة مفاتيح cache
            $keys = Cache::get('translation_keys') ?? [];
            $keys[] = $cacheKey;
            Cache::put('translation_keys', array_unique($keys), 3600);
        }
    }

    /**
     * التحقق من صحة ملفات الترجمة
     */
    private function validateTranslationFiles(): void
    {
        $this->info('🔍 Validating translation files...');
        
        $locales = ['en', 'ar'];
        $translationFiles = ['cars', 'common', 'navigation', 'home', 'forms', 'messages'];
        
        foreach ($locales as $locale) {
            foreach ($translationFiles as $file) {
                $path = resource_path("lang/{$locale}/{$file}.php");
                
                if (!File::exists($path)) {
                    $this->warn("⚠️  Missing translation file: {$path}");
                } else {
                    try {
                        $translations = require $path;
                        if (!is_array($translations)) {
                            $this->error("❌ Invalid translation file: {$path}");
                        }
                    } catch (\Exception $e) {
                        $this->error("❌ Error in translation file: {$path} - {$e->getMessage()}");
                    }
                }
            }
        }
        
        $this->info('✅ Translation files validation completed.');
    }
} 