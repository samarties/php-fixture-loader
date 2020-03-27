FROM php:7.4 AS base

RUN apt-get update

WORKDIR /app

# ---

FROM base AS php

RUN apt-get install -y libpq-dev

RUN pecl install xdebug-2.9.1

# ---

FROM base AS composer

RUN apt-get install -y git zip

RUN curl --silent --show-error https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

# ---

FROM php AS xdebug

COPY .docker/php/xdebug/xdebug.ini "/usr/local/etc/php/conf.d/"
