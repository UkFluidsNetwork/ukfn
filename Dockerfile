FROM php:7.0-fpm

# Get composer binary
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Install laravel dependencies, php extensions, and npm
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

# Don't keep kipple
RUN rm -rf /var/cache/apt/*

# Define project's root
WORKDIR /var/www/html
# Create www-data user
RUN usermod -u 1000 www-data
# Make www-data own the project's root
RUN chown -R www-data:www-data /var/www/html
# Let's run everything else as www-data
USER www-data

# Get dependency files and their locks
COPY --chown=www-data:www-data composer.json .
COPY --chown=www-data:www-data composer.lock .
COPY --chown=www-data:www-data package.json .
COPY --chown=www-data:www-data package-lock.json .

# Install composer packages, **without** setting up autload, otherwise we'll need to copy the source beforehand, which we want to avoid to speed up image build
RUN composer install --quiet --no-dev --no-autoloader --no-scripts
# Install npm packages
RUN npm install --silent --no-cache

# Get the source code
COPY --chown=www-data:www-data . ./

# Peform composer autoload and laravel's post installation scripts now that we have the source in place
RUN composer dump-autoload --optimize --no-interaction
RUN composer run-script post-update-cmd
# Run gulp tasks
RUN npm run production

EXPOSE 9000
CMD ["php-fpm"]
