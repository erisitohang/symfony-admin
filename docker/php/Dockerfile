FROM php:8.0-fpm

RUN apt-get update && apt-get install --no-install-recommends --no-install-suggests -y \
        libicu-dev \
        libzip-dev\
    && rm -rf /var/lib/apt/lists/*

RUN set -xe \
    && docker-php-ext-configure \
        intl \
    && docker-php-ext-install \
        intl \
        opcache \
        zip \
    && pecl install \
        mongodb

COPY php.ini /usr/local/etc/php/php.ini

COPY xdebug.ini /tmp/xdebug.ini
RUN cat /tmp/xdebug.ini >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN rm /tmp/xdebug.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# # https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
# ENV COMPOSER_ALLOW_SUPERUSER 1
# # create composer cache directory
# RUN mkdir -p /var/www/.composer && chown -R www-data /var/www/.composer

# RUN usermod -u 1000 www-data

WORKDIR /srv