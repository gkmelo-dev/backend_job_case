# Use the official PHP 8.0 image
FROM php:8.3.11

# Install system dependencies and required libraries
RUN apt-get update -y && apt-get install -y \
    openssl \
    zip \
    unzip \
    git \
    libonig-dev # Install oniguruma library for mbstring

# Install PHP extensions
RUN docker-php-ext-install pdo mbstring

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory
WORKDIR /app

# Copy the project files into the container
COPY . /app

# Install project dependencies using Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Run Laravel's built-in server
CMD php artisan serve --host=0.0.0.0 --port=8181

# Expose port 8181
EXPOSE 8181
