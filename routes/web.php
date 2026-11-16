<?php

use Illuminate\Support\Facades\Route;
use App\Filament\Resources\PembayaranKasResource\Pages\RekapPembayaranKas;
use App\Filament\Pages\LaporanKas;

// Export rekap kas ke Excel — GET agar bisa di-download langsung dari browser
Route::get('/admin/pembayaran-kas/rekap/export', [RekapPembayaranKas::class, 'exportExcel'])
    ->middleware(['web', 'auth'])
    ->name('filament.admin.resources.pembayaran-kas.rekap.export');

// Export laporan kas lengkap (iuran + pengeluaran + saldo)
Route::get('/admin/laporan-kas/export', [LaporanKas::class, 'exportExcel'])
    ->middleware(['web', 'auth'])
    ->name('filament.admin.pages.laporan-kas.export');

Route::get('/', function () {
    return view('welcome');
});
