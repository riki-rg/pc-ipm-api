FROM php:8.3-fpm-alpine

# System deps + PHP extensions required by Laravel 11 + Filament + Spatie
RUN apk add --no-cache \
        bash git curl icu-dev libzip-dev oniguruma-dev \
        libpng-dev libjpeg-turbo-dev freetype-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_mysql bcmath intl zip gd pcntl opcache

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Install PHP deps first (layer cache)
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction \
    || composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction

COPY docker/php.ini /usr/local/etc/php/conf.d/zz-app.ini

# App source
COPY . .

RUN composer dump-autoload --optimize --no-dev --no-interaction \
    && mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R ug+rwX,a+rX storage bootstrap/cache

COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

USER www-data
EXPOSE 9000
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm"]
