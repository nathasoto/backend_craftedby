FROM php:8.3-fpm

# Install nano
RUN apt-get update && apt-get install -y nano && apt-get clean

# Update the package repository and install nginx and supervisor
RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mysqli pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


# Copy the Composer files to the working directory
COPY composer.json composer.lock /var/www/html/


# Copy the nginx and supervisor configuration files
COPY nginx.conf /etc/nginx/nginx.conf
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf


# Set the working directory
WORKDIR /var/www/html

# Copy the rest of the application code to the working directory
COPY . /var/www/html

# Install dependencies with Composer
RUN composer install --no-dev --optimize-autoloader

# Generate the Laravel application key
RUN php artisan key:generate

# Ensure the storage directories have the correct permissions (if needed)
#RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chown -R www-data:www-data /var/www/html

#RUN php artisan migrate --seed

# Expose port 80 Nginx
EXPOSE 80

# Start Supervisor, which will manage nginx and PHP-FPM
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
