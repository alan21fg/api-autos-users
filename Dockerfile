# Usa una imagen base oficial de PHP con FPM
FROM php:8.3-fpm

# Instala dependencias y extensiones necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev unzip git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip \
    && docker-php-ext-install pdo pdo_mysql

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configura el directorio de trabajo
WORKDIR /app

# Copia el código de la aplicación al contenedor
COPY . .

# Instala las dependencias de Composer
RUN composer install --prefer-dist --no-scripts --no-progress --no-interaction

# Copia el archivo de entorno
COPY .env.example .env

# Ejecuta comandos de Artisan para configurar la aplicación
RUN php artisan key:generate
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# Exponer el puerto en el que Laravel Octane estará escuchando
EXPOSE 8000

# Comando por defecto para iniciar Laravel Octane
CMD ["php", "artisan", "octane:start", "--server=swoole", "--host=0.0.0.0"]
