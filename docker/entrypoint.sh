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

echo "[entrypoint] starting php-fpm"
exec "$@"
