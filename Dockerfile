FROM bitnami/laravel:latest

# Instala herramientas de desarrollo necesarias
RUN apt-get update && apt-get install -y \
    pkg-config \
    libc-ares-dev \
    libssl-dev \
    libcurl4-openssl-dev \
    libbrotli-dev \
    build-essential \
    autoconf \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libicu-dev \
    libxml2-dev \
    libonig-dev \
    && rm -rf /var/lib/apt/lists/*

# Instala extensiones PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql bcmath gd mbstring opcache
RUN pecl install swoole redis && docker-php-ext-enable swoole redis

# Configura el directorio de trabajo
WORKDIR /app

# Copia los archivos del proyecto
COPY . .

# Instala Composer (verifica si ya está en la imagen base)
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

# Instala las dependencias del proyecto
RUN composer install

# Configura el entorno
COPY .env.example .env
RUN mkdir -p /app/storage/logs

# Ejecuta comandos de Laravel durante la construcción (opcional)
RUN php artisan migrate --seed || true
RUN php artisan cache:clear || true
RUN php artisan view:clear || true
RUN php artisan config:clear || true
RUN php artisan octane:install --server="swoole" || true

# Comando de inicio
CMD ["php", "artisan", "octane:start", "--server=swoole", "--host=0.0.0.0"]

EXPOSE 8000
