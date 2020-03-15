FROM php:7.4-fpm
RUN cp /etc/apt/sources.list /etc/apt/sources.list.bk
COPY ./config/sources.list /etc/apt/sources.list
COPY ./composer.phar /usr/local/bin/composer
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libzip-dev \
        inetutils-ping \
        unzip \
        vim \
        git \
        procps \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd bcmath zip pdo pdo_mysql \
    && docker-php-ext-install pcntl
RUN composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/