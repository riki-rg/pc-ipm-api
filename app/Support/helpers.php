<?php

/*
|--------------------------------------------------------------------------
| Global Helpers
|--------------------------------------------------------------------------
*/

if (! function_exists('tahun_options')) {
    /**
     * Opsi tahun dropdown yang dinamis.
     *
     * Aturan:
     * - Tahun terendah = 2025 (tahun mulai pencatatan).
     * - Tahun tertinggi = tahun sekarang + 1.
     * - Semua tahun yang sudah ada di DB (pembayaran_kas & pengeluarans)
     *   tetap ditampilkan, sekalipun sudah terlewat.
     */
    function tahun_options(): array
    {
        $TAHUN_MINIMUM = 2025;

        $yearsDb = collect();

        try {
            if (class_exists(\App\Models\PembayaranKas::class) && \Illuminate\Support\Facades\Schema::hasTable('pembayaran_kas')) {
                $yearsDb = $yearsDb->merge(
                    \App\Models\PembayaranKas::query()->selectRaw('DISTINCT tahun')->pluck('tahun')
                );
            }
            if (class_exists(\App\Models\Pengeluaran::class) && \Illuminate\Support\Facades\Schema::hasTable('pengeluarans')) {
                $yearsDb = $yearsDb->merge(
                    \App\Models\Pengeluaran::query()
                        ->selectRaw("DISTINCT CAST(strftime('%Y', tanggal) AS INTEGER) as tahun")
                        ->pluck('tahun')
                );
            }
        } catch (\Throwable $e) {
            // DB belum siap (misal saat migrate pertama) — abaikan
        }

        $from = $yearsDb->filter()->min();
        $from = $from ? min($TAHUN_MINIMUM, (int) $from) : $TAHUN_MINIMUM;
        $to = max(now()->year + 1, (int) $yearsDb->max() ?: now()->year + 1);

        $years = range($from, $to);

        return array_combine($years, $years);
    }
}
