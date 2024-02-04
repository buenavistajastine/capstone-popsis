<?php

namespace App\Providers;

use Laravel\Sanctum\Sanctum;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Any registration code here
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Ignore migrations for Sanctum
        Sanctum::ignoreMigrations();
    }
}
