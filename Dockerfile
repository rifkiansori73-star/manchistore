FROM php:8.2-apache

# Install ekstensi yang dibutuhkan Laravel dan dependencies system
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    git \
     && docker-php-ext-configure gd --with-freetype --with-jpeg \
     && docker-php-ext-install gd pdo_mysql zip

# Aktifkan mod_rewrite Apache
RUN a2enmod rewrite

# Install Composer terbaru
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy seluruh file project ke container
COPY . /var/www/html

# Ubah DocumentRoot Apache ke folder public Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -s 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -s 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Install dependencies PHP via Composer (opsional tapi disarankan jika vendor tidak ikut di-copy)
# RUN composer install --no-dev --optimize-autoloader

# Berikan izin kepemilikan dan hak akses penuh ke folder storage & bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Port default web server
EXPOSE 80

# Jalankan Apache di foreground
CMD ["apache2-foreground"]