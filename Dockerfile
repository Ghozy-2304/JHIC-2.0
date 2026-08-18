# Stage 1: Build Frontend Assets (Vite / Tailwind)
FROM node:20-alpine AS node-builder
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: Production PHP + Nginx Environment
FROM serversideup/php:8.3-fpm-nginx

# Environment settings
ENV WEB_ROOT=/var/www/html/public
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV PORT=8080

WORKDIR /var/www/html

# Install required PHP extensions for MySQL & PostgreSQL
RUN install-php-extensions pdo_mysql pdo_pgsql bcmath gd zip

# Copy source code with correct permissions
COPY --chown=www-data:www-data . .
# Copy compiled assets from node build stage
COPY --chown=www-data:www-data --from=node-builder /app/public/build ./public/build

# Install PHP dependencies for production
RUN composer install --no-dev --optimize-autoloader

# Ensure required storage and cache directories exist with correct permissions
RUN mkdir -p storage/framework/views \
             storage/framework/sessions \
             storage/framework/cache/data \
             storage/logs \
             bootstrap/cache \
             database && \
    touch database/database.sqlite && \
    chown -R www-data:www-data storage bootstrap/cache database

# Set port variables for Nginx
ENV HTTP_PORT=8080
EXPOSE 8080

# Copy startup entrypoint script
COPY --chown=www-data:www-data entrypoint.sh /etc/entrypoint.d/99-laravel.sh
RUN chmod +x /etc/entrypoint.d/99-laravel.sh
