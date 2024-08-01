FROM php:8.3-fpm

# Instala dependencias y extensiones necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev unzip git \
    libcurl4-openssl-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip \
    && docker-php-ext-install pdo pdo_mysql \
    && pecl install swoole \
    && docker-php-ext-enable swoole

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY --from=spiralscout/roadrunner:2.4.2 /usr/bin/rr /usr/bin/rr

# Configura el directorio de trabajo
WORKDIR /app
COPY . .

# Instala dependencias de Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Configura el entorno
COPY .env.example .env
RUN mkdir -p /app/storage/logs

# Ejecuta comandos de Laravel
RUN php artisan migrate --seed
RUN php artisan cache:clear
RUN php artisan view:clear
RUN php artisan config:clear
RUN php artisan octane:install --server="swoole"

CMD ["php", "artisan", "octane:start", "--server=swoole", "--host=0.0.0.0"]

EXPOSE 8000
