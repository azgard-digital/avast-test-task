FROM php:7.4.16-fpm

WORKDIR /var/www

RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data

COPY ./ /var/www

RUN pecl install apcu
RUN pecl install -o -f redis

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    wget \
    zlib1g-dev \
    libxml2-dev \
    libzip-dev \
    libpq-dev \
    libmcrypt-dev \
    libssl-dev \
    pkg-config \
    libcurl4-openssl-dev

RUN docker-php-ext-install opcache \
exif \
intl \
bcmath

RUN docker-php-ext-enable apcu opcache redis
RUN pecl install xdebug-2.9.0 && docker-php-ext-enable xdebug

RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN curl -sS https://getcomposer.org/installer | \
php -- --install-dir=/usr/bin/ --filename=composer

EXPOSE 9000

CMD ["php-fpm"]