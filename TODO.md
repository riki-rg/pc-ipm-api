# TODO - Bug Fixes & Improvements

Daftar prioritas perbaikan dan improvement untuk PC IPM Backend API.

---

## 🔴 CRITICAL (Harus segera diperbaiki)

### 1. ✅ Fix Duplicate Route Definition
**File**: `routes/api.php`
**Line**: 21-22 dan 32-33
**Problem**: Route `/galeri` didefinisikan 2 kali dengan controller berbeda

**Action**:
```php
// Hapus line 21-22 (GaleriController sudah tidak dipakai)
// Route::get('/galeri', [GaleriController::class, 'index']);
// Route::get('/galeri/{id}', [GaleriController::class, 'show']);

// Keep only AlbumGaleriController (line 32-33)
Route::get('/galeri', [AlbumGaleriController::class, 'index']);
Route::get('/galeri/{id}', [AlbumGaleriController::class, 'show']);
```

**Files to delete**:
- `app/Http/Controllers/Api/GaleriController.php` (jika masih ada)

**Status**: ⏳ Pending

---

### 2. ✅ Configure CORS Properly
**File**: `config/cors.php`
**Problem**: CORS tidak dikonfigurasi untuk frontend Next.js

**Action**:
```bash
# Install CORS package (jika belum)
composer require fruitcake/laravel-cors

# Edit config/cors.php
```

```php
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    
    'allowed_methods' => ['*'],
    
    'allowed_origins' => [
        'http://localhost:3000',  // Development
        'https://pcipm-mayong.com', // Production (sesuaikan)
    ],
    
    'allowed_origins_patterns' => [],
    
    'allowed_headers' => ['*'],
    
    'exposed_headers' => [],
    
    'max_age' => 0,
    
    'supports_credentials' => true,
];
```

**File**: `bootstrap/app.php`
```php
// Pastikan CORS middleware aktif
->withMiddleware(function (Middleware $middleware) {
    $middleware->api(prepend: [
        \Illuminate\Http\Middleware\HandleCors::class,
    ]);
})
```

**Status**: ⏳ Pending

---

### 3. ✅ Change Production Database to MySQL
**File**: `.env.example`
**Problem**: SQLite tidak cocok untuk production (locking issues)

**Action**:
```env
# Update .env.example untuk production setup
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pc_ipm_production
DB_USERNAME=pc_ipm_user
DB_PASSWORD=secure_password_here

# Keep SQLite untuk development
# DB_CONNECTION=sqlite
```

**Documentation**:
- Update README.md dengan migration guide dari SQLite ke MySQL
- Tambah warning di README tentang SQLite limitation

**Status**: ⏳ Pending

---

## 🟠 HIGH PRIORITY (Penting untuk production)

### 4. ✅ Add API Response Standardization
**Files**: Semua API Controllers di `app/Http/Controllers/Api/`
**Problem**: Response format tidak konsisten

**Action**:
Buat Trait untuk standardize response:

**File**: `app/Traits/ApiResponse.php`
```php
<?php

namespace App\Traits;

trait ApiResponse
{
    protected function successResponse($data, $message = 'Success', $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function errorResponse($message, $code = 400, $errors = null)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }
}
```

**Apply to all controllers**:
```php
use App\Traits\ApiResponse;

class ArtikelController extends Controller
{
    use ApiResponse;
    
    public function index()
    {
        $artikel = Artikel::where('status', 'published')->get();
        return $this->successResponse($artikel);
    }
}
```

**Status**: ⏳ Pending

---

### 5. ✅ Add API Validation
**Files**: All API Controllers
**Problem**: Tidak ada request validation

**Action**:
Buat Form Request untuk setiap endpoint yang menerima input

**Example**: `app/Http/Requests/StorePesanMasukRequest.php`
```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePesanMasukRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'pesan' => 'required|string|max:5000',
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'pesan.required' => 'Pesan harus diisi',
        ];
    }
}
```

**Update Controller**:
```php
public function store(StorePesanMasukRequest $request)
{
    $pesan = PesanMasuk::create($request->validated());
    return $this->successResponse($pesan, 'Pesan berhasil dikirim', 201);
}
```

**Status**: ⏳ Pending

---

### 6. ✅ Add Rate Limiting for Contact Form
**File**: `routes/api.php`
**Problem**: Spam protection untuk form kontak

**Action**:
```php
use Illuminate\Support\Facades\RateLimiter;

// Tambah di RouteServiceProvider atau routes/api.php
RateLimiter::for('contact', function (Request $request) {
    return Limit::perMinute(3)->by($request->ip());
});

// Apply to route
Route::post('/pesan-masuk', [PesanMasukController::class, 'store'])
    ->middleware('throttle:contact');
```

**Status**: ⏳ Pending

---

### 7. ✅ Add Image URL Helper
**File**: `app/Helpers/ImageHelper.php`
**Problem**: Image URL tidak konsisten (uploads vs storage)

**Action**:
```php
<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    public static function getImageUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        // If already full URL
        if (str_starts_with($path, 'http')) {
            return $path;
        }

        // Convert relative path to full URL
        return url('storage/' . ltrim($path, '/'));
    }

    public static function getImageAttribute($model, $attribute)
    {
        $path = $model->attributes[$attribute] ?? null;
        return self::getImageUrl($path);
    }
}
```

**Update Models** (tambahkan accessor):
```php
// app/Models/Artikel.php
use App\Helpers\ImageHelper;

protected function gambarHeader(): Attribute
{
    return Attribute::make(
        get: fn ($value) => ImageHelper::getImageUrl($value),
    );
}
```

**Register Helper**:
```php
// composer.json
"autoload": {
    "files": [
        "app/Helpers/ImageHelper.php"
    ]
}
```

Run: `composer dump-autoload`

**Status**: ⏳ Pending

---

### 8. ✅ Add Error Handling Middleware
**File**: `app/Exceptions/Handler.php`
**Problem**: API error response tidak user-friendly

**Action**:
```php
<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    public function register(): void
    {
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Resource not found',
                ], 404);
            }
        });

        $this->renderable(function (ModelNotFoundException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan',
                ], 404);
            }
        });

        $this->renderable(function (ValidationException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $e->errors(),
                ], 422);
            }
        });
    }
}
```

**Status**: ⏳ Pending

---

## 🟡 MEDIUM PRIORITY (Improvement)

### 9. ✅ Make Payment Nominal Configurable
**File**: `database/migrations/*_create_pembayaran_kas_table.php`
**Problem**: Nominal 10000 di-hardcode

**Action**:
1. Tambah field di table `pengaturan`:
```php
// Migration baru
Schema::table('pengaturan', function (Blueprint $table) {
    $table->integer('nominal_kas_default')->default(10000)->after('alamat');
});
```

2. Update Filament Resource untuk input pembayaran kas agar ambil dari pengaturan

**Status**: ⏳ Pending

---

### 10. ✅ Add API Documentation
**Problem**: Tidak ada dokumentasi API

**Action**:
```bash
composer require --dev knuckleswtf/scribe
php artisan vendor:publish --tag=scribe-config
php artisan scribe:generate
```

**Configure** `config/scribe.php`:
```php
'base_url' => env('APP_URL', 'http://localhost:8000'),
'routes' => [
    [
        'match' => [
            'prefixes' => ['api/*'],
        ],
    ],
],
```

Generate docs: `php artisan scribe:generate`

**Status**: ⏳ Pending

---

### 11. ✅ Add Database Indexes
**Files**: Migrations
**Problem**: Query performance bisa lambat untuk large dataset

**Action**:
```php
// Add indexes untuk frequently queried columns
Schema::table('artikel', function (Blueprint $table) {
    $table->index('slug');
    $table->index('status');
    $table->index('tanggal_publish');
});

Schema::table('kajian', function (Blueprint $table) {
    $table->index('slug');
});

Schema::table('kegiatan', function (Blueprint $table) {
    $table->index('slug');
});

Schema::table('pengurus', function (Blueprint $table) {
    $table->index('bidang_id');
    $table->index('periode');
});
```

**Status**: ⏳ Pending

---

### 12. ✅ Add Soft Deletes
**Files**: Models & Migrations
**Problem**: Data terhapus permanen

**Action**:
Tambah soft deletes untuk models penting:
```php
use Illuminate\Database\Eloquent\SoftDeletes;

class Artikel extends Model
{
    use SoftDeletes;
}
```

Migration:
```php
Schema::table('artikel', function (Blueprint $table) {
    $table->softDeletes();
});
```

**Status**: ⏳ Pending

---

### 13. ✅ Add API Logging
**Problem**: Tidak ada tracking API usage

**Action**:
Buat middleware untuk log API requests:

**File**: `app/Http/Middleware/LogApiRequests.php`
```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class LogApiRequests
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        Log::channel('api')->info('API Request', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => $response->status(),
        ]);

        return $response;
    }
}
```

**Register** di `bootstrap/app.php`:
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->api(append: [
        \App\Http\Middleware\LogApiRequests::class,
    ]);
})
```

**Status**: ⏳ Pending

---

## 🟢 LOW PRIORITY (Nice to have)

### 14. ✅ Add API Versioning
**Problem**: Breaking changes bisa rusak frontend lama

**Action**:
```php
// routes/api.php
Route::prefix('v1')->group(function () {
    // Current API routes
});

// Future v2
Route::prefix('v2')->group(function () {
    // New API routes
});
```

**Status**: ⏳ Pending

---

### 15. ✅ Add Unit Tests
**Problem**: Tidak ada automated testing

**Action**:
```bash
php artisan make:test Api/ArtikelTest
```

```php
<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Artikel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArtikelTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_published_articles()
    {
        Artikel::factory()->create(['status' => 'published']);
        
        $response = $this->getJson('/api/artikel');
        
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'data' => [
                         '*' => ['id', 'judul', 'slug', 'gambar_header']
                     ]
                 ]);
    }
}
```

**Status**: ⏳ Pending

---

### 16. ✅ Add Database Backup
**Problem**: Tidak ada backup strategy

**Action**:
```bash
composer require spatie/laravel-backup

php artisan vendor:publish --provider="Spatie\Backup\BackupServiceProvider"
```

**Configure** `config/backup.php`:
```php
'destination' => [
    'disks' => [
        'local',
        's3', // untuk production
    ],
],
```

**Schedule** di `app/Console/Kernel.php`:
```php
protected function schedule(Schedule $schedule)
{
    $schedule->command('backup:clean')->daily()->at('01:00');
    $schedule->command('backup:run')->daily()->at('02:00');
}
```

**Status**: ⏳ Pending

---

## 📊 Progress Tracker

- **Critical**: 0/3 completed (0%)
- **High**: 0/5 completed (0%)
- **Medium**: 0/5 completed (0%)
- **Low**: 0/3 completed (0%)

**Total**: 0/16 completed (0%)

---

## 🔧 Quick Fixes Script

Untuk fix cepat duplicate route:

```bash
# Backup dulu
cp routes/api.php routes/api.php.backup

# Edit manual atau run:
sed -i '21,22d' routes/api.php  # Hapus line 21-22
```

---

**Last Updated**: August 4, 2026
**Priority**: Start with CRITICAL items
