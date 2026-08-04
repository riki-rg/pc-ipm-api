<?php

use Illuminate\Support\Facades\Route;
use App\Filament\Pages\InputPembayaranKas;

Route::post('/admin/input-pembayaran-kas/save', [InputPembayaranKas::class, 'saveAll'])
    ->middleware(['web', 'auth'])
    ->name('filament.admin.pages.inputPembayaranKas.saveAll');

Route::get('/', function () {
    return view('welcome');
});
