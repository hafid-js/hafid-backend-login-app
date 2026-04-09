# Gunakan PHP + Apache
FROM php:8.2-apache

# Install extension yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip curl \
    && docker-php-ext-install pdo pdo_mysql zip

# Enable rewrite (penting buat Laravel)
RUN a2enmod rewrite

# Copy semua file project
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install dependency Laravel
RUN composer install

# Permission (biar nggak error)
RUN chmod -R 775 storage bootstrap/cache

# Set Apache ke public folder Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

EXPOSE 80
