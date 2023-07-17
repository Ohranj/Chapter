FROM php:8.1-fpm

ARG user=alex
ARG nodeVersion=16

RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get update
RUN apt-get install -y \
    git \
    vim \
    sudo \
    zip \
    unzip

RUN curl -sL https://deb.nodesource.com/setup_{$nodeVersion}.x | sudo -E bash -

RUN apt-get install -y nodejs

# Pull latest composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Add a new user and home dir
RUN useradd -ms /bin/bash $user
RUN usermod -a -G www-data $user