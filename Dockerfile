FROM php:7.4.3-fpm

RUN apt-get update

RUN apt-get install -y --no-install-recommends libpq-dev

RUN apt-get install -y \
      curl \
      libmagickwand-dev \
      libpq-dev \
      libmagick++-dev \
      libwebp-dev \
      libjpeg-dev \
      libpng-dev \
      libfreetype6-dev \
      libssl-dev \
      libmcrypt-dev \
      libxpm-dev \
      nano \
      git \
      dnsutils

RUN apt-get -yqq install exiftool

RUN docker-php-ext-install iconv

RUN docker-php-ext-install pdo_mysql

RUN docker-php-ext-install opcache  && \
     docker-php-ext-enable opcache

RUN docker-php-ext-configure exif \
  && docker-php-ext-configure exif \
  && docker-php-ext-install exif \
  && docker-php-ext-enable exif

RUN docker-php-ext-configure gd \
  --with-jpeg \
  --with-freetype \
  --with-webp \
  --with-xpm \
  && docker-php-ext-install gd

RUN docker-php-ext-install mysqli pdo_pgsql pdo_mysql

RUN curl -s http://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer