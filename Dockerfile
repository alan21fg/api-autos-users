FROM bitnami/laravel:latest

# Configura el directorio de trabajo
WORKDIR /app

# Copia los archivos del proyecto
COPY . .

# Instala Composer (verifica si ya está en la imagen base)
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

# Instala las dependencias del proyecto
RUN composer install

# Instala paquetes adicionales (si es necesario)
RUN composer require laravel/octane spiral/roadrunner

# Configura el entorno
COPY .env.example .env
RUN mkdir -p /app/storage/logs

# Ejecuta comandos de Laravel durante la construcción (opcional)
# Puedes optar por ejecutar estos comandos en un contenedor separado durante el despliegue
RUN php artisan migrate --seed || true
RUN php artisan cache:clear || true
RUN php artisan view:clear || true
RUN php artisan config:clear || true
RUN php artisan octane:install --server="swoole" || true

# Comando de inicio
CMD ["php", "artisan", "octane:start", "--server=swoole", "--host=0.0.0.0"]

EXPOSE 8000
