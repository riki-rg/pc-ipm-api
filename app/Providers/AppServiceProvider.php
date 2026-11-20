<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Gate;
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
        Gate::policy(\Spatie\Permission\Models\Role::class, \App\Policies\RolePolicy::class);
        Gate::policy(\Spatie\Permission\Models\Permission::class, \App\Policies\PermissionPolicy::class);
        Gate::policy(\App\Models\ArsipRapat::class, \App\Policies\ArsipRapatPolicy::class);
        Gate::policy(\App\Models\ProgramKerja::class, \App\Policies\ProgramKerjaPolicy::class);
        Gate::policy(\App\Models\PeriodeKepengurusan::class, \App\Policies\PeriodeKepengurusanPolicy::class);
        // Paksa skema https: request melalui proxy chain (Cloudflare -> webstack-nginx
        // -> sidecar nginx -> fpm) sehingga Laravel sering menganggap request http.
        // Tanpa ini, Filament meng-generate x-load-src dengan http:// padahal halaman https
        // -> browser memblokir mixed content -> FileUpload/RichEditor tidak jalan.
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
            URL::forceRootUrl(config('app.url'));
        }

        // Global helper: opsi tahun dropdown yang dinamis.
        // Selalu: (tahun sekarang - 5) s/d (tahun sekarang + 1), PLUS semua tahun
        // yang sudah ada di DB (agar data lama tidak hilang dari dropdown).
        if (! function_exists('tahun_options')) {
            function tahun_options(int $minYearsBack = 5, int $maxYearsForward = 1): array
            {
                $fromDb = collect();
                try {
                    if (class_exists(\App\Models\PembayaranKas::class) && Schema::hasTable('pembayaran_kas')) {
                        $fromDb = \App\Models\PembayaranKas::query()->selectRaw('DISTINCT tahun')->pluck('tahun');
                    }
                    if (class_exists(\App\Models\Pengeluaran::class) && Schema::hasTable('pengeluarans')) {
                        $fromDb = $fromDb->merge(
                            \App\Models\Pengeluaran::query()->selectRaw('DISTINCT strftime("%Y", tanggal) as tahun')->pluck('tahun')
                        );
                    }
                } catch (\Throwable $e) {
                    // DB belum siap (misal saat pertama migrate) — abaikan
                }

                $from = min(now()->year - $minYearsBack, (int) $fromDb->min() ?: now()->year - $minYearsBack);
                $to = max(now()->year + $maxYearsForward, (int) $fromDb->max() ?: now()->year + $maxYearsForward);

                $years = range((int) $from, (int) $to);

                return array_combine($years, $years);
            }
        }

        // Rate limiter untuk form kontak / pesan masuk (throttle:contact di routes/api.php)
        RateLimiter::for('contact', function (object $request) {
            return [
                Limit::perMinute(5)->by($request->ip()),
            ];
        });
    }
}
