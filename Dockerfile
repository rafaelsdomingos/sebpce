FROM php:8.4-apache

# Copia o código da aplicação para o container
COPY . /var/www/html

# Instala o Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    unzip \
    zip \
    libxml2-dev \
    libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath opcache intl zip \
    && chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite \
    && /usr/bin/composer install


# Expõe a porta 80
EXPOSE 80

