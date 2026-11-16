<?php

use Illuminate\Support\Facades\Route;
use App\Filament\Pages\InputPembayaranKas;
use App\Filament\Resources\PembayaranKasResource\Pages\RekapPembayaranKas;

Route::post('/admin/input-pembayaran-kas/save', [InputPembayaranKas::class, 'saveAll'])
    ->middleware(['web', 'auth'])
    ->name('filament.admin.pages.inputPembayaranKas.saveAll');

// Export rekap kas ke Excel — GET agar bisa di-download langsung dari browser
Route::get('/admin/pembayaran-kas/rekap/export', [RekapPembayaranKas::class, 'exportExcel'])
    ->middleware(['web', 'auth'])
    ->name('filament.admin.resources.pembayaran-kas.rekap.export');

Route::get('/', function () {
    return view('welcome');
});
