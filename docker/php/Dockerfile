FROM php:7.4-fpm
RUN cp /etc/apt/sources.list /etc/apt/sources.list.bk
COPY ./config/sources.list /etc/apt/sources.list
COPY ./composer.phar /usr/local/bin/composer
RUN apt-get update && apt-get install -y \
        vim \
        git \
        procps \
    && docker-php-ext-install pcntl \
    && docker-php-ext-install sockets \