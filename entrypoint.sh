#!/bin/sh

echo "[INFO] Running Laravel startup entrypoint..."

# Remove hot reload file if exists
rm -f /var/www/html/public/hot

# Ensure storage & cache directories exist
mkdir -p /var/www/html/storage/framework/views \
         /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/cache/data \
         /var/www/html/storage/logs \
         /var/www/html/bootstrap/cache

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public 2>/dev/null || true
chmod -R 755 /var/www/html/public 2>/dev/null || true

# Run database migrations safely
php /var/www/html/artisan migrate --force 2>&1 || echo "[WARNING] Migration failed or database not ready yet."

# Create storage link
php /var/www/html/artisan storage:link --force 2>/dev/null || true

# Clear and optimize cache
php /var/www/html/artisan config:clear 2>&1 || true
php /var/www/html/artisan view:clear 2>&1 || true
php /var/www/html/artisan route:clear 2>&1 || true

echo "[INFO] Laravel startup entrypoint completed."
