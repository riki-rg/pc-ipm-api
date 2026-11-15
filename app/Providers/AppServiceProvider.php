<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
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
        // Paksa skema https: request melalui proxy chain (Cloudflare -> webstack-nginx
        // -> sidecar nginx -> fpm) sehingga Laravel sering menganggap request http.
        // Tanpa ini, Filament meng-generate x-load-src dengan http:// padahal halaman https
        // -> browser memblokir mixed content -> FileUpload/RichEditor tidak jalan.
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // Rate limiter untuk form kontak / pesan masuk (throttle:contact di routes/api.php)
        RateLimiter::for('contact', function (object $request) {
            return [
                Limit::perMinute(5)->by($request->ip()),
            ];
        });
    }
}
