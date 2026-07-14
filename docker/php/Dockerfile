FROM php:8.1-fpm-alpine

# Install required packages
RUN apk add --no-cache \
    mysql-client \
    libzip-dev \
    hiredis-dev \
    autoconf \
    g++ \
    make \
    pcre-dev \
    zlib-dev

# Install required PHP extensions
RUN docker-php-ext-install mysqli pdo_mysql zip

# Install Redis and OpenTelemetry extensions
RUN pecl install redis && docker-php-ext-enable redis \
    && pecl install opentelemetry && docker-php-ext-enable opentelemetry
