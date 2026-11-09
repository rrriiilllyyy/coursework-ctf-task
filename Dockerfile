FROM php:8.1-fpm

RUN docker-php-ext-install pdo pdo_mysql mysqli

RUN apt-get update && apt-get install -y \
    libxml2-dev \
    curl \
    && docker-php-ext-install xml

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html

EXPOSE 9000
