FROM php:7.2-fpm

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        && apt-get install -y libpq-dev \
        #&& docker-php-ext-install -j$(nproc) mcrypt \
        && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
        && docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-install mbstring
RUN docker-php-ext-install exif
RUN docker-php-ext-install opcache
RUN mkdir /var/run/mysqld
RUN mkfifo /var/run/mysqld/mysqld.sock
RUN docker-php-ext-install pdo_mysql

COPY conf/ /usr/local/etc/php-fpm.d/
COPY php.ini /usr/local/etc/php/conf.d
CMD ["php-fpm"]