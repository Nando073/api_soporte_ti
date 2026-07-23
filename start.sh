#!/bin/bash

# Optimizar Laravel (esto debe ir ANTES de generar Swagger)
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Generar documentación de Swagger (después de las optimizaciones)
php artisan l5-swagger:generate

# Iniciar el servidor
php artisan serve --host=0.0.0.0 --port=10000