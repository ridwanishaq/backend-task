# Use an official PHP runtime as a parent image
FROM php:8.2-apache

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Copy the current directory contents into the container at /var/www/html
COPY app/ .

# Install any needed packages specified in requirement.txt
RUN apt-get update
RUN apt-get install -y \
	libmcrypt-dev \
    libzip-dev \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl bcmath gd sockets
    
# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set the 'ServerName' directive to suppress the warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.1.6

# RUN composer require facade/ignition
# RUN composer update
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN composer clear-cache

# Install project dependencies
RUN composer install --no-scripts --no-autoloader

# Set the correct user and group for the storage directory
RUN chown -R www-data:www-data storage

RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

# Change the ownership of the storage and bootstrap/cache directories
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Make storage and bootstrap/cache directories writable
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copy only the necessary files to leverage Docker cache
COPY app/composer.json app/composer.lock ./

# Finish Composer installation
# RUN composer dump-autoload --no-dev --no-scripts
# RUN composer dump-autoload -vvv --optimize --no-dev --classmap-authoritative

# Set up Laravel environment
# RUN cp .env.example .env
RUN php artisan key:generate

# Make port 80 available to the world outside this container
EXPOSE 80

# Define environment variables
ENV APACHE_DOCUMENT_ROOT /var/www/html

