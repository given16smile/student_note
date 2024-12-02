# Use the official PHP 8.2 CLI image
FROM php:8.2-cli

# Set working directory
WORKDIR /app

# Install required system packages and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    && docker-php-ext-install \
    pdo_pgsql \
    && docker-php-ext-enable pdo_pgsql

# Install Composer globally
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Copy Symfony project files into the container
COPY . .

# Install dependencies and handle cache
RUN composer install --optimize-autoloader

# Expose the default Symfony port
EXPOSE 8000

# Default command to run the Symfony built-in server
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
