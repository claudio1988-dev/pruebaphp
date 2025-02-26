FROM php:8.2-cli

# Instalar las extensiones que necesites, pdo_mysql, etc.
RUN apt-get update && apt-get install -y \
    libpq-dev zip unzip git \
    && docker-php-ext-install pdo pdo_mysql

# Instalar Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

WORKDIR /var/www/html

# Copia tu proyecto (composer.json, etc.)
COPY . .

# Instalar dependencias dentro del contenedor
RUN composer install

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
