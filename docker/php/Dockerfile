# syntax=docker/dockerfile:1
ARG FPM_VERSION=alpine3.17
ARG PHP_VERSION=8.2.3

FROM php:${PHP_VERSION}-fpm-${FPM_VERSION} as base

RUN docker-php-ext-install opcache

FROM base as dev

RUN apk --update-cache \
    add \
    autoconf \
    gcc \
    icu-dev \
    libzip-dev \
    linux-headers \
    make \
    musl-dev \
    sqlite \
    && pecl install xdebug \
    && docker-php-ext-install intl zip \
    && docker-php-ext-enable xdebug intl zip \
    && rm -rf /var/lib/apt/lists/* /var/cache/apk/*

COPY --from=composer:2.2.7 /usr/bin/composer /usr/bin/