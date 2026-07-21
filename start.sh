#!/bin/bash

# Optimizar Laravel (ahora con la BD disponible)
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Iniciar el servidor
php artisan serve --host=0.0.0.0 --port=10000