<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // Ensure stale public/hot file is removed so Laravel uses public/build assets
        $hotFile = public_path('hot');
        if (file_exists($hotFile)) {
            @unlink($hotFile);
        }
    }
}
