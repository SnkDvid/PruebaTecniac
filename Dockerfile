# Use the official PHP image as a base image
FROM php:8.0-apache

# Set the working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpq-dev \
    unzip \
    git \
    && docker-php-ext-install intl pdo pdo_pgsql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy the application code
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader || { cat /var/www/html/vendor/composer/installed.json; exit 1; }

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]