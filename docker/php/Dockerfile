FROM php:7.4-apache

RUN apt-get update

# development packages
RUN apt-get install -y \
    git \
    zip \
    curl \
    sudo \
    libonig-dev \
    unzip \
    libicu-dev \
    libbz2-dev \
    libpng-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libreadline-dev \
    libfreetype6-dev \
    libzip-dev \
    g++ \
    ca-certificates \
    fonts-liberation \
    libappindicator3-1 \
    libasound2 \
    libatk-bridge2.0-0 \
    libatk1.0-0 \
    libc6 \
    libcairo2 \
    libcups2 \
    libdbus-1-3 \
    libexpat1 \
    libfontconfig1 \
    libgbm1 \
    libgcc1 \
    libglib2.0-0 \
    libgtk-3-0 \
    libnspr4 \
    libnss3 \
    libpango-1.0-0 \
    libpangocairo-1.0-0 \
    libstdc++6 \
    libx11-6 \
    libx11-xcb1 \
    libxcb1 \
    libxcomposite1 \
    libxcursor1 \
    libxdamage1 \
    libxext6 \
    libxfixes3 \
    libxi6 \
    libxrandr2 \
    libxrender1 \
    libxss1 \
    libxtst6 \
    lsb-release \
    wget \
    xdg-utils \
    librabbitmq-dev \
    libssh-dev

RUN a2enmod rewrite headers

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN pecl install amqp

RUN docker-php-ext-install \
    bz2 \
    intl \
    iconv \
    bcmath \
    opcache \
    calendar \
    mbstring \
    pdo_mysql \
    pcntl \
    sockets \
    gd \
    zip \
    amqp

RUN pecl install xdebug-3.0.1
RUN docker-php-ext-enable xdebug

RUN echo "xdebug.mode=debug" >> /usr/local/etc/php/php.ini

RUN curl -sL https://deb.nodesource.com/setup_12.x  | bash -
RUN apt-get -y install nodejs

RUN npm install -g yarn

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ./sites/*.conf /etc/apache2/sites-enabled/

ARG uid
RUN useradd -G www-data -u $uid -d /home/devuser devuser
RUN mkdir -p /home/devuser/.composer && \
    chown -R devuser:devuser /home/devuser
