# PC IPM Mayong - Backend API

Backend API untuk website PC IPM (Pimpinan Cabang Ikatan Pelajar Muhammadiyah) Mayong yang dibangun dengan Laravel 11. API ini menyediakan endpoint untuk manajemen konten organisasi, publikasi, galeri, dan dilengkapi dengan admin panel berbasis Filament.

## 🚀 Tech Stack

- **Framework**: Laravel 11.x
- **PHP**: ^8.2
- **Database**: SQLite (dapat diganti MySQL/PostgreSQL)
- **Admin Panel**: Filament 3.2
- **Authentication**: Laravel Sanctum 4.0
- **Authorization**: Spatie Laravel Permission 6.23 + Filament Shield 3.9
- **Frontend Asset**: Vite + Tailwind CSS 4.0

## 📋 Fitur Utama

### 1. **Admin Panel (Filament)**
- Dashboard admin yang modern dan responsive
- CRUD resources untuk semua entitas
- Role & Permission management dengan Filament Shield
- Custom page untuk input pembayaran kas
- File upload management
- Rich text editor untuk konten

### 2. **Manajemen Konten**
- **Bidang**: Divisi/departemen organisasi dengan pengurus
- **Pengurus**: Anggota organisasi dengan foto, jabatan, dan periode
- **Artikel**: Berita organisasi dengan status draft/published
- **Kajian**: Event kajian Islam (artikel/poster) dengan pemateri
- **Kegiatan**: Activity tracking dengan daftar peserta
- **Galeri**: Album foto dengan kategori
- **Hero Slides**: Carousel homepage (foto/video YouTube)
- **Pengaturan**: Site settings (logo, kontak, sosial media)

### 3. **Sistem Pembayaran Kas**
- Tracking pembayaran kas anggota per bulan
- Status: belum/sudah bayar
- Metode: transfer/cash/kajian internal
- Nominal default: Rp 10.000
- Pencatatan oleh user admin

### 4. **API REST**
- 14 public endpoints untuk frontend
- Response format JSON konsisten
- CORS support untuk frontend Next.js
- Image serving via storage symlink

### 5. **Authentication & Authorization**
- Laravel Sanctum untuk API tokens
- Role-based access control (RBAC)
- Spatie Permission integration
- Protected admin routes

## 🛠️ Prerequisites

- **PHP**: >= 8.2
- **Composer**: Latest version
- **SQLite**: (atau MySQL/PostgreSQL)
- **Node.js**: >= 18 (untuk build assets)
- **npm/yarn**: Package manager

## ⚙️ Environment Variables

Copy file `.env.example` ke `.env` dan sesuaikan konfigurasi:

```env
APP_NAME="PC IPM Mayong"
APP_ENV=local
APP_KEY=base64:your-generated-key
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database - SQLite (default)
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=pc_ipm
# DB_USERNAME=root
# DB_PASSWORD=

# Session & Cache
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

# Storage
FILESYSTEM_DISK=public

# Mail (optional)
MAIL_MAILER=log
```

## 📦 Instalasi

### 1. Clone Repository
```bash
git clone <repository-url>
cd pc-ipm-api
```

### 2. Install Dependencies
```bash
# PHP dependencies
composer install

# Node dependencies (untuk Vite)
npm install
```

### 3. Setup Environment
```bash
# Copy .env file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Setup Database
```bash
# Buat file SQLite (jika belum ada)
touch database/database.sqlite

# Run migrations
php artisan migrate

# (Optional) Run seeders untuk data dummy
php artisan db:seed
```

### 5. Storage Symlink
```bash
# Buat symlink untuk public storage
php artisan storage:link
```

### 6. Build Assets
```bash
# Development
npm run dev

# Production
npm run build
```

### 7. Run Server
```bash
# Development server
php artisan serve

# Server akan berjalan di: http://localhost:8000
```

## 🏗️ Struktur Database

### Core Tables

| Table | Deskripsi |
|-------|-----------|
| `users` | User authentication |
| `roles` | User roles (Admin, Editor, etc) |
| `permissions` | Permission definitions |
| `personal_access_tokens` | Sanctum API tokens |

### Application Tables

| Table | Deskripsi | Kolom Utama |
|-------|-----------|-------------|
| `bidang` | Divisi organisasi | nama, icon, deskripsi, gambar |
| `pengurus` | Anggota pengurus | nama_lengkap, jabatan, foto_profil, bidang_id |
| `pembayaran_kas` | Tracking pembayaran | pengurus_id, bulan, tahun, nominal, status |
| `artikel` | Berita/artikel | judul, slug, isi_konten, status, user_id |
| `kajian` | Event kajian | judul, jenis, pemateri, waktu, lokasi |
| `kegiatan` | Kegiatan/event | judul, lokasi, waktu, deskripsi |
| `kegiatan_pengurus` | Peserta kegiatan | kegiatan_id, pengurus_id |
| `album_galeri` | Album foto | judul, cover, kategori |
| `foto_galeri` | Foto dalam album | album_galeri_id, foto, keterangan |
| `slides` | Hero carousel | type, url_gambar, video_id_youtube |
| `pengaturan` | Site settings | nama_website, logo, email, whatsapp |
| `pesan_masuk` | Contact messages | nama, email, pesan, is_read |

## 🔌 API Endpoints

**Base URL**: `http://localhost:8000/api`

### Public Endpoints

| Method | Endpoint | Deskripsi | Response |
|--------|----------|-----------|----------|
| GET | `/hero-slides` | List hero slides | Array of slides (image/video) |
| GET | `/pengaturan` | Site settings | Logo, nama, kontak, sosmed |
| GET | `/bidang` | List bidang + pengurus | Array of divisions with members |
| GET | `/pimpinan` | Ketua & Sekretaris | Leadership info |
| GET | `/artikel` | List artikel published | Array of news articles |
| GET | `/artikel/{slug}` | Detail artikel | Article with full content |
| GET | `/kajian` | List kajian | Array of kajian events |
| GET | `/kajian/{slug}` | Detail kajian | Kajian detail (pemateri, waktu, lokasi) |
| GET | `/kegiatan` | List kegiatan | Array of activities |
| GET | `/kegiatan/{slug}` | Detail kegiatan | Activity + attendees list |
| GET | `/galeri` | List album galeri | Array of photo albums |
| GET | `/galeri/{id}` | Detail album + foto | Album with all photos |
| POST | `/pesan-masuk` | Submit contact form | Success message |

### Protected Endpoints

| Method | Endpoint | Auth | Deskripsi |
|--------|----------|------|-----------|
| GET | `/user` | Sanctum | Get authenticated user |

### Response Format

**Success:**
```json
{
  "status": "success",
  "data": {
    // response data
  }
}
```

**Error:**
```json
{
  "status": "error",
  "message": "Error message"
}
```

## 🎨 Admin Panel

Akses admin panel di: `http://localhost:8000/admin`

### Default Admin Account
Buat admin user dengan tinker:
```bash
php artisan tinker

# Buat user admin
$user = \App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@pcipm.com',
    'password' => bcrypt('password')
]);

# Assign role (jika ada seeder role)
$user->assignRole('super_admin');
```

### Admin Resources

Filament menyediakan CRUD untuk:
- ✅ Bidang & Pengurus
- ✅ Artikel (dengan Rich Editor)
- ✅ Kajian & Kegiatan
- ✅ Album Galeri & Foto
- ✅ Hero Slides
- ✅ Pembayaran Kas (Custom Page)
- ✅ Pesan Masuk
- ✅ Pengaturan Website
- ✅ User & Role Management

## 🎯 Artisan Commands

```bash
# Database
php artisan migrate              # Run migrations
php artisan migrate:fresh        # Fresh migration (hapus data)
php artisan db:seed              # Run seeders

# Cache
php artisan cache:clear          # Clear cache
php artisan config:clear         # Clear config cache
php artisan route:clear          # Clear route cache

# Storage
php artisan storage:link         # Create storage symlink

# Filament
php artisan filament:user        # Create Filament admin user

# Permission
php artisan shield:install       # Install Filament Shield
php artisan shield:generate      # Generate permissions

# Development
php artisan serve                # Start dev server
php artisan tinker               # Laravel REPL
```

## 📁 Struktur Project

```
pc-ipm-api/
├── app/
│   ├── Filament/                    # Filament Admin Panel
│   │   ├── Pages/                   # Custom admin pages
│   │   │   └── InputPembayaranKas.php
│   │   └── Resources/               # CRUD Resources (14 resources)
│   │       ├── ArtikelResource.php
│   │       ├── BidangResource.php
│   │       ├── KajianResource.php
│   │       └── ...
│   │
│   ├── Http/
│   │   └── Controllers/
│   │       └── Api/                 # API Controllers
│   │           ├── ArtikelController.php
│   │           ├── BidangController.php
│   │           ├── KajianController.php
│   │           └── ...
│   │
│   ├── Models/                      # Eloquent Models (13 models)
│   │   ├── User.php
│   │   ├── Bidang.php
│   │   ├── Pengurus.php
│   │   ├── Artikel.php
│   │   └── ...
│   │
│   └── Providers/
│       └── Filament/
│           └── AdminPanelProvider.php
│
├── database/
│   ├── migrations/                  # 18 migration files
│   ├── seeders/                     # Database seeders
│   ├── factories/                   # Model factories
│   └── database.sqlite              # SQLite database
│
├── routes/
│   ├── api.php                      # API routes (14 endpoints)
│   ├── web.php                      # Web routes (Filament)
│   └── console.php
│
├── storage/
│   └── app/
│       └── public/                  # File uploads (symlinked)
│           ├── artikel/
│           ├── bidang/
│           ├── galeri/
│           ├── kajian/
│           ├── kegiatan/
│           ├── pengurus/
│           └── slides/
│
├── public/
│   ├── storage/                     # Symlink ke storage/app/public
│   ├── index.php
│   └── .htaccess
│
├── config/                          # Configuration files
├── resources/                       # Views & assets
├── tests/                           # PHPUnit tests
└── vendor/                          # Composer dependencies
```

## 🔒 Security

### CORS Configuration

Edit `config/cors.php` atau install `fruitcake/laravel-cors`:

```php
// config/cors.php
return [
    'paths' => ['api/*'],
    'allowed_origins' => ['http://localhost:3000'],
    'allowed_methods' => ['*'],
    'allowed_headers' => ['*'],
    'credentials' => true,
];
```

### Authentication

Laravel Sanctum untuk API authentication:
```bash
# Generate token
$token = $user->createToken('token-name')->plainTextToken;

# Use in frontend
headers: {
  'Authorization': `Bearer ${token}`
}
```

### File Upload Security

- File validation di Filament Resources
- Max size: 2MB untuk foto
- Allowed types: jpg, jpeg, png
- Storage di `storage/app/public/`

## 🐛 Troubleshooting

### Storage symlink error
```bash
php artisan storage:link
# Jika masih error, buat manual:
ln -s ../storage/app/public public/storage
```

### Permission denied (storage/logs)
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### SQLite database locked
```bash
# Pastikan tidak ada proses lain yang menggunakan database
# Atau gunakan MySQL/PostgreSQL untuk production
```

### Image tidak muncul dari API
```bash
# Pastikan storage symlink sudah dibuat
php artisan storage:link

# Check file permissions
chmod -R 775 storage/app/public
```

### Vite manifest not found
```bash
# Build assets terlebih dahulu
npm run build

# Atau run dev server
npm run dev
```

## 🚀 Deployment

### Production Checklist

```bash
# 1. Set environment
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# 2. Optimize
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 3. Build assets
npm run build

# 4. Set permissions
chmod -R 755 storage bootstrap/cache

# 5. Run migrations
php artisan migrate --force
```

### Database Production

Untuk production, gunakan MySQL/PostgreSQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pc_ipm_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

### Web Server Configuration

**Nginx:**
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /var/www/pc-ipm-api/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## 📊 Seeder Data

Run seeders untuk data awal:

```bash
php artisan db:seed

# Atau specific seeder
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=RoleSeeder
```

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=ExampleTest

# With coverage
php artisan test --coverage
```

## 📝 API Documentation

Untuk dokumentasi API lengkap, pertimbangkan menggunakan:
- **Swagger/OpenAPI**: Laravel Swagger
- **Postman**: Export collection
- **Scribe**: `composer require --dev knuckleswtf/scribe`

## 🤝 Contributing

1. Fork repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## 📄 License

Private project - All rights reserved

## 👨‍💻 Developer

Dikembangkan untuk PC IPM Mayong

## 📞 Support

Untuk pertanyaan atau issue, hubungi tim development.

---

**Last Updated**: August 2026
