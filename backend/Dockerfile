# syntax=docker/dockerfile:1

# PHP 8.3 CLI (we’ll run `php artisan serve` directly)
FROM php:8.3-cli-alpine

# System dependencies
RUN apk add --no-cache \
    git zip unzip icu-dev libzip-dev oniguruma-dev postgresql-dev

# PHP extensions commonly needed by Laravel + PostgreSQL
RUN docker-php-ext-configure intl \
 && docker-php-ext-install -j"$(nproc)" intl mbstring exif pcntl pdo_pgsql bcmath

# Composer (multi-stage copy)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# App directory
WORKDIR /var/www/html

# If a Laravel app already exists, install deps (safe if empty right now)
RUN if [ -f composer.json ]; then \
      composer install --no-interaction --prefer-dist --optimize-autoloader; \
    fi

EXPOSE 8000

# Run the dev server if artisan exists; otherwise, keep the container alive with a helpful message
CMD ["sh", "-lc", "if [ -f artisan ]; then php artisan serve --host 0.0.0.0 --port 8000; else echo 'Laravel app not detected in /var/www/html. After Step 3, rebuild or restart this service.'; tail -f /dev/null; fi"]
