#!/usr/bin/env sh
set -e
mkdir -p storage/framework/cache
mkdir -p storage/framework/views
mkdir -p storage/framework/sessions
mkdir -p bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
exec php-fpm
