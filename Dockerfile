FROM php:8.2-apache

# Instala extensiones necesarias
RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    git \
    curl \
    && docker-php-ext-install zip

# Habilita mod_rewrite
RUN a2enmod rewrite

# Instala Composer
RUN curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copia el código al contenedor
COPY . /var/www/html/

# Establece el directorio de trabajo
WORKDIR /var/www/html/

# Instala dependencias PHP (ahora que el código ya está copiado)
RUN composer install --no-dev --prefer-dist --no-progress --no-interaction

# Da permisos a Apache
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

# Inicia Apache
CMD ["apache2-foreground"]
