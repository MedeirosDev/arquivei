FROM php:7.3-fpm
LABEL maintainer="smedeiros.flavio@gmail.com"

RUN apt-get update && apt-get install -y \
  build-essential \
  mariadb-client \
  libpng-dev \
  libjpeg62-turbo-dev \
  libfreetype6-dev \
  libzip-dev \
  locales \
  zip \
  jpegoptim \
  optipng \
  pngquant \
  gifsicle \
  cron

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath opcache
RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
RUN docker-php-ext-install gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ENV COMPOSER_MEMORY_LIMIT=-1

RUN echo pt_BR.UTF-8 UTF-8 > /etc/locale.gen && locale-gen

# Add crontab file in the cron directory
COPY laravel-cron /etc/cron.d/laravel-cron

# Give execution rights on the cron job
RUN chmod 0644 /etc/cron.d/laravel-cron

WORKDIR /application

CMD php-fpm -D; cron -f
