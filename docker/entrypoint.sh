#!/bin/sh
set -e

cd /var/www/html

# storage link for public files (idempotent)
if [ ! -L public/storage ]; then
    php artisan storage:link || true
fi

# wait for DB then migrate
echo "[entrypoint] running migrations..."
php artisan migrate --force || echo "[entrypoint] migrate failed, continuing"

if [ "${RUN_SEEDER:-false}" = "true" ]; then
    echo "[entrypoint] running seeders..."
    php artisan db:seed --force || echo "[entrypoint] seed failed"
fi

php artisan optimize:clear >/dev/null 2>&1 || true
php artisan config:cache >/dev/null 2>&1 || true
php artisan route:cache >/dev/null 2>&1 || true
php artisan view:cache >/dev/null 2>&1 || true

# Publish Livewire/Filament assets ke public/ (image fpm).
# PENTING: nginx sidecar mount public/ dari HOST, jadi setelah ini asset
# harus di-sync ke host volume (lihat DEPLOYMENT.md).
php artisan vendor:publish --tag=livewire:assets --force >/dev/null 2>&1 || true
php artisan filament:assets >/dev/null 2>&1 || true

echo "[entrypoint] starting php-fpm"
exec "$@"
