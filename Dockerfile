# Usa una imagen base oficial de PHP con FPM
FROM php:8.3-fpm

# Instala dependencias y extensiones necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev unzip git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instala RoadRunner
COPY --from=spiralscout/roadrunner:2.4.2 /usr/bin/rr /usr/bin/rr

# Configura el directorio de trabajo
WORKDIR /app

# Copia el código de la aplicación
COPY . .

# Instala dependencias de Composer y configura la aplicación
RUN composer install --no-interaction --prefer-dist --optimize-autoloader \
    && composer require laravel/octane spiral/roadrunner \
    && cp .env.example .env \
    && php artisan key:generate \
    && php artisan cache:clear \
    && php artisan view:clear \
    && php artisan config:clear \
    && php artisan octane:install --server="swoole"

# Asegura que el directorio de almacenamiento tenga los permisos correctos
RUN mkdir -p /app/storage/logs \
    && chown -R www-data:www-data /app/storage /app/bootstrap/cache

# Expone el puerto 8000 para la API
EXPOSE 8000

# Comando para iniciar la aplicación
CMD ["php", "artisan", "octane:start", "--server=swoole", "--host=0.0.0.0"]
