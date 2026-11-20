<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use App\Http\Controllers\Api\HeroSlideController;
use App\Http\Controllers\Api\BidangController;
use App\Http\Controllers\Api\ArtikelController;
use App\Http\Controllers\Api\PengaturanController;
use App\Http\Controllers\Api\PesanMasukController;
use App\Http\Controllers\Api\KajianController;
use App\Http\Controllers\Api\KegiatanController;
use App\Http\Controllers\Api\AlbumGaleriController;
use App\Http\Controllers\Api\PengurusController;
use App\Http\Controllers\Api\PublicProfileController;

// Rate limiter for contact form
RateLimiter::for('contact', function (Request $request) {
    return Limit::perMinute(3)->by($request->ip());
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/hero-slides', [HeroSlideController::class, 'index']);
Route::get('/bidang', [BidangController::class, 'index']);
Route::get('/artikel', [ArtikelController::class, 'index']);
Route::get('/artikel/{slug}', [ArtikelController::class, 'show']);
Route::get('/pengaturan', [PengaturanController::class, 'index']);
Route::post('/pesan-masuk', [PesanMasukController::class, 'store'])->middleware('throttle:contact');
Route::get('/kajian', [KajianController::class, 'index']);
Route::get('/kajian/{slug}', [KajianController::class, 'show']);
Route::get('/kegiatan', [KegiatanController::class, 'index']);
Route::get('/kegiatan/{slug}', [KegiatanController::class, 'show']);
Route::get('/galeri', [AlbumGaleriController::class, 'index']);
Route::get('/galeri/{id}', [AlbumGaleriController::class, 'show']);
Route::get('/pengurus/{id}/profil', [PublicProfileController::class, 'show']);
Route::get('/pimpinan', [PengurusController::class, 'pimpinan']);