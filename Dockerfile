# 1. Image de base PHP + Apache
FROM php:8.2-apache

# 2. Installation des extensions nécessaires + activation de rewrite
RUN apt-get update \
    && apt-get install -y \
       git \
       unzip \
       libzip-dev \
       libpq-dev \        # <— ajouté pour les headers PostgreSQL
    && docker-php-ext-install \
       zip \
       pdo_pgsql \
       pgsql \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# 3. On dit à Apache de servir /public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri \
    -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf

# 4. Copier tout le projet dans l’image
WORKDIR /var/www/html
COPY . .

# 5. Installer Composer et les dépendances
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# 6. Exposer le bon port
EXPOSE 80

# 7. Lancer Apache en foreground
CMD ["apache2-foreground"]
