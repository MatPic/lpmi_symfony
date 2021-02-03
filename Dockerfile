FROM php:7.4-fpm

RUN docker-php-ext-install pdo_mysql

RUN pecl install apcu

RUN apt-get update && \
apt-get install -y \
libzip-dev
RUN apt-get update && apt-get install -y zlib1g-dev libicu-dev g++
RUN docker-php-ext-configure intl 
RUN docker-php-ext-install zip intl
RUN docker-php-ext-enable apcu

WORKDIR /usr/src/app

COPY --chown=1000:1000 . /usr/src/app

RUN PATH=$PATH:/usr/src/app/vendor/bin:bin

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install --no-scripts --prefer-dist \
    && rm -rf "$(composer config cache-dir)" "$(composer config data-dir)"

# RUN php bin/console 