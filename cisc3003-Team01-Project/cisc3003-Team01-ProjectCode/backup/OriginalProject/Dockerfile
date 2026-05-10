FROM php:8.2-apache

# Install required PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Cloud Run uses port 8080
RUN sed -ri -e 's!Listen 80!Listen 8080!g' /etc/apache2/ports.conf \
    && sed -ri -e 's!:80>!:8080>!g' /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html
COPY . /var/www/html

# Basic hardening for public web root
RUN chown -R www-data:www-data /var/www/html

EXPOSE 8080
