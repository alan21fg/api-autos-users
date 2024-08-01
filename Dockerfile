FROM php:8.3-fpm

# Instala dependencias y extensiones necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev unzip git \
    mysql-server \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip \
    && docker-php-ext-install pdo pdo_mysql

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY --from=spiralscout/roadrunner:2.4.2 /usr/bin/rr /usr/bin/rr

# Configura el directorio de trabajo
WORKDIR /app
COPY . .

# Instala dependencias de Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader
# Instala paquetes adicionales
RUN composer require laravel/octane spiral/roadrunner

# Configura el entorno y ejecuta comandos de Laravel
COPY .env.example .env
RUN mkdir -p /app/storage/logs

# Inicia el servicio MySQL y ejecuta comandos para configurar la base de datos
RUN service mysql start && \
    mysql -e "CREATE DATABASE apiautos;" && \
    mysql -e "CREATE USER 'root'@'localhost' IDENTIFIED BY '';" && \
    mysql -e "GRANT ALL PRIVILEGES ON *.* TO 'root'@'localhost';" && \
    mysql -e "FLUSH PRIVILEGES;"

# Estos comandos pueden fallar si la base de datos no está lista.
# Puedes ejecutarlos en el contenedor en ejecución si es necesario.
RUN php artisan migrate:refresh --seed

RUN php artisan cache:clear
RUN php artisan view:clear
RUN php artisan config:clear
RUN php artisan octane:install --server="swoole"

CMD php artisan octane:start --server="swoole" --host="0.0.0.0"

EXPOSE 8000
