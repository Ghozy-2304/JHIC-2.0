# Stage 1: Build Frontend Assets (Vite / Tailwind)
FROM node:20-alpine AS node-builder
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: Production PHP + Nginx Environment
FROM serversideup/php:8.3-fpm-nginx

# Set web root to Laravel public folder
ENV WEB_ROOT=/var/www/html/public

WORKDIR /var/www/html

# Copy source code with correct permissions
COPY --chown=www-data:www-data . .
# Copy compiled assets from node build stage
COPY --chown=www-data:www-data --from=node-builder /app/public/build ./public/build

# Install PHP dependencies for production
RUN composer install --no-dev --optimize-autoloader

# Ensure SQLite file exists & storage permissions are correct
RUN touch database/database.sqlite && \
    chown -R www-data:www-data storage bootstrap/cache database
