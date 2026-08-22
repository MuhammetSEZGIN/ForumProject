FROM php:8.3-fpm-bookworm AS app

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libfreetype6-dev \
        libicu-dev \
        libjpeg62-turbo-dev \
        libonig-dev \
        libpng-dev \
        libxml2-dev \
        libxslt1-dev \
        libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        bcmath \
        exif \
        ftp \
        gd \
        intl \
        mbstring \
        opcache \
        pcntl \
        pdo_mysql \
        xsl \
        zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-progress \
    --no-scripts \
    --prefer-dist

COPY . .

RUN composer dump-autoload --no-dev --optimize --no-interaction \
    && php artisan package:discover --ansi \
    && mkdir -p \
        bootstrap/cache \
        storage/app/private \
        storage/app/public \
        storage/framework/cache/data \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
        FTP/INBOX \
        FTP/OUTBOX \
        FTP/ERROR \
        /var/www/html/.docker-secrets \
    && chown -R www-data:www-data bootstrap/cache storage FTP /var/www/html/.docker-secrets

COPY docker/php.ini /usr/local/etc/php/conf.d/99-forum.ini
COPY docker/entrypoint.sh /usr/local/bin/forum-entrypoint

RUN chmod +x /usr/local/bin/forum-entrypoint

ENTRYPOINT ["forum-entrypoint"]
CMD ["php-fpm"]


FROM nginx:1.27-alpine AS web

WORKDIR /var/www/html

COPY docker/nginx.conf /etc/nginx/conf.d/default.conf
COPY --from=app /var/www/html/public ./public
