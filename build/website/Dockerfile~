FROM php:apache

EXPOSE 80

COPY ./php.ini /usr/local/etc/php
COPY ./phpmyadmin /var/www/html

RUN docker-php-ext-install pdo pdo_mysql mysqli