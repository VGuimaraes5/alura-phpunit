FROM php:8.1-apache

RUN apt-get update -y && \
        apt-get install libxml2-dev -y

RUN docker-php-ext-install dom