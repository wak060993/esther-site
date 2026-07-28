FROM php:8.4-apache

# Extensions PHP nécessaires pour Symfony + Doctrine + PostgreSQL + VichUploader
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

# Active mod_rewrite (indispensable pour les routes Symfony)
RUN a2enmod rewrite

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Active AllowOverride All pour que le .htaccess de Symfony fonctionne
RUN sed -ri -e 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Installe Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copie le code
COPY . .

# Installe les dépendances PHP (sans les paquets de dev, optimisé prod)
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Installe les assets JS (Stimulus, etc.) requis par AssetMapper/EasyAdmin
RUN php bin/console importmap:install --env=prod

# Compile les assets CSS/JS pour la production
RUN php bin/console asset-map:compile --env=prod

# Publie les assets des bundles (CSS/JS d'EasyAdmin notamment)
RUN php bin/console assets:install public --env=prod

# Crée les dossiers nécessaires et les bons droits
RUN mkdir -p var/cache var/log public/uploads/articles public/uploads/livres \
    && chown -R www-data:www-data var public/uploads \
    && chmod -R 775 var public/uploads

EXPOSE 80