FROM php:8.3.28-apache
RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN a2enmod rewrite

WORKDIR /var/www/html
COPY ./src .

USER www-data

HEALTHCHECK CMD curl --fail http://localhost/index.php || exit 1
