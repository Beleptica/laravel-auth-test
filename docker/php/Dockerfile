FROM php:8.4-fpm
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libicu-dev libonig-dev libxml2-dev \
    libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo_mysql intl zip bcmath \
    && rm -rf /var/lib/apt/lists/*
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
WORKDIR /var/www/html
ENTRYPOINT ["/entrypoint.sh"]
CMD ["php-fpm"]
