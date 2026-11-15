<?php

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Console\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\RateLimiter;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Rate limiter untuk form kontak / pesan masuk (throttle:contact di routes/api.php)
RateLimiter::for('contact', function (object $request) {
    return [
        Limit::perMinute(5)->by($request->ip()),
    ];
});
