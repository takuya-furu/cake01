FROM php:8.2-apache

# パッケージ
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    libzip-dev \
    zlib1g-dev \
    zip \
    unzip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# PHP拡張
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-configure zip

RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    intl \
    zip

# Node.js 20
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Apache設定
RUN a2enmod rewrite

COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# ★これが今回の本命（超重要）
RUN printf "<Directory /var/www/html/public>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>\n" >> /etc/apache2/apache2.conf

# 作業ディレクトリ
WORKDIR /var/www/html
