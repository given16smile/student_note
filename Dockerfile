# Use the official PHP image with Apache support
FROM php:8.2-apache

# Enable Apache mod_rewrite (required for Symfony)
RUN a2enmod rewrite

# Set the ServerName to avoid the warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Install necessary dependencies for Symfony
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libpq-dev \
    libonig-dev \
    && docker-php-ext-install \
    intl \
    opcache \
    pdo_mysql \
    pdo_pgsql \
    mbstring \
    && docker-php-ext-enable opcache

# Set the working directory in the container
WORKDIR /var/www/html

# Copy the Symfony project files into the container
COPY . .

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Définir la variable d'environnement pour permettre à Composer d'exécuter des plugins en tant que superutilisateur
ENV COMPOSER_ALLOW_SUPERUSER=1

# Install PHP dependencies via Composer
RUN composer install --no-scripts --optimize-autoloader

# Set the document root to the public directory
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Update Apache's configuration to use Symfony's public directory
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

RUN chown -R www-data:www-data /var/www/html/var/cache

RUN chmod -R 775 /var/www/html/var/cache

RUN php bin/console cache:clear --env=dev

# Expose port 80 for HTTP
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]

