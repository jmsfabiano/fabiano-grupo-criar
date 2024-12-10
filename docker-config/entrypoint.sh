#!/bin/bash
cd /var/www/html/spa-api
composer install
php artisan migrate
php artisan db:seed
php-fpm