# Deployment Notes — PC IPM API

## Fix Livewire/Filament (15 Nov 2026)

**Masalah**: FileUpload error "required" terus + RichEditor tidak bisa diketik.

**Akar masalah**:
1. Livewire v3.6.4 tidak kompatibel dengan Filament v3.3.43 → downgrade ke **livewire/livewire 3.5.20** (pinned di composer.json).
2. Container `pc-ipm-api-web` (nginx) mount `public/` dari HOST volume, sedangkan `vendor:publish` menulis asset ke `public/` di dalam image fpm → nginx 404 untuk `vendor/livewire/livewire.min.js` → Livewire JS gagal load → semua form Filament rusak.

**Setelah build/deploy, WAJIB jalankan**:

```bash
# 1. Publish asset livewire di dalam image fpm
docker exec -u root pc-ipm-api php artisan vendor:publish --tag=livewire:assets --force

# 2. Copy asset dari image fpm ke host volume (yang di-mount oleh nginx sidecar)
docker cp pc-ipm-api:/var/www/html/public/vendor /tmp/pc-vendor
mkdir -p /DATA/Projects/pc-ipm-api/public/vendor
cp -r /tmp/pc-vendor/livewire /DATA/Projects/pc-ipm-api/public/vendor/

# 3. Clear cache
docker exec pc-ipm-api php artisan optimize:clear

# 4. Restart nginx sidecar (clear DNS cache)
docker restart pc-ipm-api-web webstack-nginx
```

**Alternatif permanen**: tambahkan step di Dockerfile fpm:
```dockerfile
RUN php artisan vendor:publish --tag=livewire:assets --force
```
dan pastikan asset di-copy ke host volume (karena nginx sidecar mount public/ dari host, bukan image).

## Catatan lain
- `php artisan filament:assets` juga perlu dijalankan setelah upgrade Filament.
- Jika 502 Bad Gateway setelah restart container: restart `webstack-nginx` (DNS cache internal nginx menunjuk IP lama).

## Fix Final (16 Nov 2026) — Upload 401 & Mixed Content

**Rantai proxy**: Cloudflare Tunnel (https) -> webstack-nginx:80 -> sidecar nginx:80 -> php-fpm

**3 masalah & fix**:
1. webstack-nginx mengirim `X-Forwarded-Proto: http` ke sidecar -> Laravel melihat request http
   -> Fix: `proxy_set_header X-Forwarded-Proto https;` di webstack-nginx vhost (file di server: `/opt/docker/webstack/nginx/conf.d/pc-ipm-mayong.conf`)
2. Sidecar nginx tidak meneruskan skema ke php-fpm
   -> Fix: `fastcgi_param HTTPS on; fastcgi_param X-Forwarded-Proto https;` di `nginx/default.conf` (repo)
3. Komponen lazy-load Filament (x-load) generate URL http di halaman https -> browser blokir mixed content -> FileUpload/RichEditor mati
   -> Fix: `URL::forceScheme('https') + URL::forceRootUrl(config('app.url'))` di AppServiceProvider (production)

**Verifikasi**: upload cover "Pengunggahan selesai" (200), semua POST 200, tanpa 401.

**Catatan**: conf webstack-nginx (`pc-ipm-mayong.conf`) berada di HOST server (`/opt/docker/webstack/nginx/conf.d/`), tidak di repo — backup manual jika rebuild server.
