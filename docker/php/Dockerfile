FROM php:8.4-fpm-alpine

# Install system dependencies & PHP extensions
RUN apk add --no-cache \
        bash \
        mysql-client \
        libzip-dev \
        oniguruma-dev \
        autoconf \
        gcc \
        g++ \
        make \
    && docker-php-ext-install pdo_mysql bcmath zip mbstring

WORKDIR /var/www/html
