FROM php:8.1-apache

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public \
    PORT=10000 \
    DB_CONNECTION=sqlite \
    DB_DATABASE=/var/data/attendance.sqlite

RUN apt-get update && apt-get install -y --no-install-recommends \
        libcurl4-openssl-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libonig-dev \
        libpng-dev \
        libsqlite3-dev \
        libzip-dev \
        unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" bcmath curl gd mbstring pdo_sqlite zip \
    && a2enmod rewrite headers \
    && sed -ri "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf \
    && sed -ri '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --ignore-platform-req=php \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R ug+rwx storage bootstrap/cache

CMD ["sh", "-c", "mkdir -p \"$(dirname \"$DB_DATABASE\")\" && touch \"$DB_DATABASE\" && chown -R www-data:www-data \"$(dirname \"$DB_DATABASE\")\" && php artisan migrate --force && php artisan db:seed --force && sed -ri 's/^Listen .*/Listen ${PORT}/' /etc/apache2/ports.conf && sed -ri 's/<VirtualHost \\*:.*>/<VirtualHost *:${PORT}>/' /etc/apache2/sites-available/000-default.conf && apache2-foreground"]