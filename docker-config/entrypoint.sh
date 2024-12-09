#!/bin/bash
cd /var/www/html/spa-api
php artisan migrate
php artisan db:seed
php-fpm