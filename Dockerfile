FROM php:8.2-apache

# Instala extensiones necesarias
RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip

# Habilita mod_rewrite
RUN a2enmod rewrite

# Copia el código al contenedor
COPY . /var/www/html/

# Establece el directorio de trabajo
WORKDIR /var/www/html/

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instala dependencias
RUN composer install

# Da permisos a Apache
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
