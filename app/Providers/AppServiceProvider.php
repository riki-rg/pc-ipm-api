<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
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
        // Rate limiter untuk form kontak / pesan masuk (throttle:contact di routes/api.php)
        RateLimiter::for('contact', function (object $request) {
            return [
                Limit::perMinute(5)->by($request->ip()),
            ];
        });
    }
}
