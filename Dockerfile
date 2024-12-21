# Use the official PHP image as a base image
FROM php:8.1-apache

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

# Set the document root to the public directory
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf /etc/apache2/apache2.conf

# Install PHP dependencies

#RUN composer install --no-dev --optimize-autoloader || { cat /var/www/html/vendor/composer/installed.json; exit 1; }

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]