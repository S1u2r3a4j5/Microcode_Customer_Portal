# PHP image ka use karo (FPM ke saath)
FROM php:8.1-fpm

# Zaroori dependencies aur PHP extensions install karo
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libicu-dev \
    g++ \
    make \
    pkg-config \
    libonig-dev \  
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && docker-php-ext-enable zip

# Composer install karo
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Working directory set karo
WORKDIR /var/www

# Application code copy karo
COPY . .

# Composer dependencies install karo
RUN composer install
