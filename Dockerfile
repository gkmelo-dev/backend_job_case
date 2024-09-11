# Use an official PHP runtime as a parent image
FROM php:8.0-fpm

# Set the working directory inside the container
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy existing application directory contents to the working directory inside the container
COPY . /var/www

# Give permission for Laravel directory
RUN chown -R www-data:www-data /var/www

# Install PHP dependencies via Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Copy the existing application directory contents to the working directory

# Expose port 9000 and start PHP-FPM server
EXPOSE 9000

CMD ["php-fpm"]
