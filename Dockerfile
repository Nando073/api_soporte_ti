FROM php:8.3-cli

WORKDIR /var/www/html

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensiones de PHP
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar los archivos del proyecto
COPY . .

# Instalar dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader

# ========== CONFIGURACIÓN DE SWAGGER ==========
# Publicar assets de Swagger
RUN php artisan vendor:publish --force --provider "L5Swagger\L5SwaggerServiceProvider"

# Limpiar y regenerar caché
RUN php artisan config:clear
RUN php artisan cache:clear
RUN php artisan view:clear
RUN php artisan route:clear

# Generar documentación de Swagger
RUN php artisan l5-swagger:generate

# Optimizar para producción
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# Establecer permisos
RUN chmod -R 775 storage
RUN chmod -R 775 bootstrap/cache
# ============================================

# Crear directorio para logs (opcional)
RUN mkdir -p storage/logs && chmod -R 775 storage/logs

# Exponer el puerto
EXPOSE 10000

# Comando para iniciar el servidor
CMD php artisan serve --host=0.0.0.0 --port=10000