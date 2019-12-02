FROM php:7.0-fpm

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN curl -sL https://deb.nodesource.com/setup_6.x | bash
RUN apt-get update && apt-get install -y \
        curl \
        gnupg \
        unzip \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libxml2-dev \
        libpng-dev \
        nodejs \
    && docker-php-ext-install -j$(nproc) gd xml mbstring zip pdo pdo_mysql

RUN rm -rf /var/cache/apt/*

RUN usermod -u 1000 www-data
RUN mkdir -p /var/www/html/vendor
RUN chown -R www-data:www-data /var/www/html
USER www-data

WORKDIR /var/www/html

COPY --chown=www-data:www-data . ./

RUN composer install --quiet --no-dev
RUN npm install --silent --no-cache
RUN npm run production

EXPOSE 9000
CMD ["php-fpm"]
