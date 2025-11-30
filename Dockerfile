FROM php:8.3.28-apache
RUN apt-get update && apt-get install -y \
	libmariadb-dev \
	xz-utils \
	&& docker-php-ext-install mysqli pdo_mysql

RUN a2enmod rewrite

WORKDIR /var/www/html
COPY ./src .

USER www-data

HEALTHCHECK CMD curl --fail http://localhost/index.php || exit 1
