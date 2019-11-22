FROM node AS npm

WORKDIR /build

COPY package.json ./
RUN npm install --silent --no-cache

FROM php:7.0-fpm

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apt-get update && apt-get install -y \
        curl \
        gnupg \
        unzip \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libxml2-dev \
        libpng-dev \
    && docker-php-ext-install -j$(nproc) gd xml mbstring zip pdo pdo_mysql

RUN rm -rf /var/cache/apt/*

RUN usermod -u 1000 www-data
RUN mkdir -p /var/www/html/vendor
RUN chown -R www-data:www-data /var/www/html
USER www-data

WORKDIR /var/www/html

COPY --chown=www-data:www-data . ./

RUN composer install --quiet --no-dev
COPY --chown=www-data:www-data --from=npm /build/node_modules ./node_modules
COPY --from=npm /usr/local/bin/npm /usr/local/bin/npm
COPY --from=npm /usr/local/bin/node /usr/local/bin/node

RUN npm run production

EXPOSE 9000
CMD ["php-fpm"]
