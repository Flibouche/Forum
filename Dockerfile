FROM php:8.2-apache
 
RUN apt-get update && apt-get upgrade -y
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli pdo_mysql && \
apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev libwebp-dev && \
docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ --with-webp && \
docker-php-ext-install gd
 
EXPOSE 80