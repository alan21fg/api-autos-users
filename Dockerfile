FROM bitnami/laravel:latest

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

# Configura el directorio de trabajo
WORKDIR /app

# Copia los archivos del proyecto
COPY . .

RUN composer install

# Instala paquetes adicionales
RUN composer require laravel/octane spiral/roadrunner

# Configura el entorno
COPY .env.example .env
RUN mkdir -p /app/storage/logs

# Ejecuta migraciones y otros comandos de Laravel
RUN php artisan migrate --seed
RUN php artisan cache:clear
RUN php artisan view:clear
RUN php artisan config:clear
RUN php artisan octane:install --server="swoole"

# Comando de inicio
CMD ["php", "artisan", "octane:start", "--server=swoole", "--host=0.0.0.0"]

EXPOSE 8000
