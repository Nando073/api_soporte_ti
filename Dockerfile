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
RUN composer install --optimize-autoloader

# ========== CONFIGURACIÓN DE SWAGGER ==========
# Publicar assets de Swagger
RUN php artisan vendor:publish --force --provider "L5Swagger\L5SwaggerServiceProvider"

# NO generamos la documentación aquí (falla en Docker)
# En su lugar, copiamos el archivo generado localmente
# RUN php artisan l5-swagger:generate  # <--- COMENTADO

# Crear directorio para logs
RUN mkdir -p storage/logs && chmod -R 775 storage logs bootstrap/cache
# ============================================

# Copiar script de inicio y dar permisos de ejecución
COPY start.sh /start.sh
RUN chmod +x /start.sh

# Exponer el puerto
EXPOSE 10000

# Comando para iniciar con el script
CMD /start.sh