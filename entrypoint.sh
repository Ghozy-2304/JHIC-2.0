#!/bin/sh

# Ensure storage & cache directories exist
mkdir -p /var/www/html/storage/framework/views \
         /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/cache/data \
         /var/www/html/storage/logs \
         /var/www/html/bootstrap/cache

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true

# Run database migrations safely (don't exit on error so Nginx can start)
php /var/www/html/artisan migrate --force || echo "Migration failed or database not ready"

# Create storage link
php /var/www/html/artisan storage:link --force 2>/dev/null || true

# Clear and optimize cache safely
php /var/www/html/artisan config:cache || true
php /var/www/html/artisan route:cache || true
php /var/www/html/artisan view:cache || true
