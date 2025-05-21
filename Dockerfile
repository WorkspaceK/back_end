FROM php:8.2-fpm-alpine

RUN apk --no-cache add \
    freetype-dev libjpeg-turbo-dev libpng-dev shadow libzip-dev gettext gettext-dev icu-dev oniguruma-dev postgresql-dev curl zip unzip bash

RUN docker-php-ext-configure gd --enable-gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ && \
    docker-php-ext-install -j$(nproc) pdo_pgsql mbstring zip gettext intl exif gd opcache

ARG PUID=1000
ARG PGID=1000
RUN addgroup -g ${PGID} laravel && \
    adduser -D -u ${PUID} -G laravel laravel

COPY upload.ini /usr/local/etc/php/conf.d/

WORKDIR /var/www/laravel

COPY composer.json composer.lock ./
RUN apk add --no-cache git && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer install --optimize-autoloader --no-dev --no-interaction --prefer-dist

COPY . .

RUN php artisan storage:link

RUN chown -R laravel:laravel /var/www/laravel && chmod -R 775 storage bootstrap/cache

EXPOSE 9000

USER laravel

CMD ["php-fpm"]
