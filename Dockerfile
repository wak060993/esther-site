FROM php:8.4-apache

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    && docker-php-ext-install \
    intl \
    pdo \
    pdo_pgsql \
    zip \
    gd \
    opcache

# Augmente les limites d'upload (par défaut 2M, trop bas pour des photos)
RUN { \
    echo 'upload_max_filesize = 10M'; \
    echo 'post_max_size = 10M'; \
    echo 'memory_limit = 256M'; \
    } > /usr/local/etc/php/conf.d/uploads.ini

RUN a2enmod rewrite

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN sed -ri -e 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-scripts

RUN php bin/console importmap:install --env=prod
RUN php bin/console asset-map:compile --env=prod
RUN php bin/console assets:install public --env=prod

RUN mkdir -p var/cache var/log public/uploads/articles public/uploads/livres \
    && chown -R www-data:www-data var public/uploads \
    && chmod -R 775 var public/uploads

EXPOSE 80