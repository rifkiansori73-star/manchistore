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

# Izinkan .htaccess override di direktori web root agar routing Laravel berfungsi
RUN echo '<Directory /var/www/html/public>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/laravel.conf \
    && a2enconf laravel

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

# Buat folder storage & log secara eksplisit dan berikan izin akses penuh ke www-data
RUN mkdir -p /var/www/html/storage/framework/sessions \
    && mkdir -p /var/www/html/storage/framework/views \
    && mkdir -p /var/www/html/storage/framework/cache \
    && mkdir -p /var/www/html/storage/logs \
    && touch /var/www/html/storage/logs/laravel.log \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Install dependencies PHP via Composer
RUN composer install --no-dev --optimize-autoloader

# Pastikan ulang hak akses folder storage aman setelah composer install
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Bersihkan cache konfigurasi
RUN php artisan config:clear || true
RUN php artisan cache:clear || true

# Port default web server
EXPOSE 80

# Jalankan Apache di foreground
CMD ["apache2-foreground"]