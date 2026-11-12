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
        // Auto-cleanup stale public/hot file if Vite dev server is not active
        $hotFile = public_path('hot');
        if (file_exists($hotFile)) {
            $url = trim(file_get_contents($hotFile));
            if ($url) {
                $parts = parse_url($url);
                $host = $parts['host'] ?? '127.0.0.1';
                $port = $parts['port'] ?? 5173;
                $connection = @fsockopen($host, $port, $errno, $errstr, 0.2);
                if (is_resource($connection)) {
                    fclose($connection);
                } else {
                    @unlink($hotFile);
                }
            }
        }
    }
}
