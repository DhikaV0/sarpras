# Use official PHP with extensions
FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libonig-dev libzip-dev libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip

# Install Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy everything
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Generate optimized Laravel cache
RUN php artisan config:clear
RUN php artisan route:clear

# Ensure storage & bootstrap cache writable
RUN chmod -R 777 storage bootstrap/cache

# Expose port
EXPOSE 8000

# Start Laravel using PHP built-in server
CMD [ "php", "artisan", "serve", "--host=0.0.0.0", "--port=8000" ]
