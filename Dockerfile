FROM php:8.2-fpm

# Install system deps
RUN apt-get update && apt-get install -y \
    git curl unzip \
    libicu-dev libonig-dev libzip-dev \
    libfreetype6-dev libjpeg62-turbo-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql mysqli mbstring intl gd zip exif bcmath

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy project files
COPY . /var/www/html/

# Install dependencies
RUN mkdir -p /var/www/html/writable/cache /var/www/html/writable/logs /var/www/html/writable/session /var/www/html/writable/debugbar \
    && composer install --no-interaction --prefer-dist --no-dev \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 777 /var/www/html/writable

EXPOSE 9000
CMD ["php-fpm"]