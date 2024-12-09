FROM php:8.2-fpm

WORKDIR /var/www/html/

RUN apt-get update && apt-get install -y \
    build-essential \
    zip \
    vim \
    libzip-dev \
    unzip \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl gd
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY spa-api /var/www/html/spa-api
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
RUN apt-get install -y nodejs

# RUN chown -R www-data:www-data /var/www/html

RUN chown -R www-data:www-data /var/www/html/spa-api
RUN chmod -R 755 /var/www/html/spa-api
RUN mkdir -p /var/www/html/spa-api/storage/framework/cache/data
RUN chmod -R 775 /var/www/html/spa-api/storage 
RUN chmod -R 775 /var/www/html/spa-api/bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/spa-api/storage
RUN chown -R www-data:www-data /var/www/html/spa-api/bootstrap/cache


