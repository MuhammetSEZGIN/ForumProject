#!/bin/sh
set -eu

key_file=/var/www/html/.docker-secrets/app_key

mkdir -p "$(dirname "$key_file")" \
    storage/app/private \
    storage/app/public \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    FTP/INBOX \
    FTP/OUTBOX \
    FTP/ERROR

if [ -z "${APP_KEY:-}" ]; then
    if [ ! -s "$key_file" ]; then
        umask 077
        php artisan key:generate --show > "$key_file"
    fi

    APP_KEY="$(tr -d '\r\n' < "$key_file")"
    export APP_KEY
fi

echo "Veritabanı bağlantısı bekleniyor..."
attempt=0
until php -r '
    try {
        new PDO(
            "mysql:host=".getenv("DB_HOST").";port=".getenv("DB_PORT").";dbname=".getenv("DB_DATABASE"),
            getenv("DB_USERNAME"),
            getenv("DB_PASSWORD")
        );
    } catch (Throwable $exception) {
        exit(1);
    }
'; do
    attempt=$((attempt + 1))
    if [ "$attempt" -ge 60 ]; then
        echo "Veritabanına bağlanılamadı." >&2
        exit 1
    fi
    sleep 2
done

php artisan migrate --force --no-interaction
php artisan config:cache

chown -R www-data:www-data \
    /var/www/html/.docker-secrets \
    bootstrap/cache \
    storage \
    FTP

exec "$@"
