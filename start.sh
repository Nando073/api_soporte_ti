#!/bin/bash

# Generar documentación de Swagger al inicio (cuando la BD está disponible)
php artisan l5-swagger:generate

# Optimizar Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Iniciar el servidor
php artisan serve --host=0.0.0.0 --port=10000