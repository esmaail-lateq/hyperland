<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\MaerskService;

class MaerskServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(MaerskService::class, function ($app) {
            return new MaerskService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
} 