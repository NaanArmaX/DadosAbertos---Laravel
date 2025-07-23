FROM php:8.3-fpm

# Instalar dependências do PHP, extensões e redis
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    libpq-dev \
    supervisor \
    && docker-php-ext-install pdo pdo_mysql zip \
    && pecl install redis && docker-php-ext-enable redis

# Instalar composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

WORKDIR /var/www

# Copiar package.json e package-lock.json antes para aproveitar cache
COPY package*.json ./

# Copiar todo o código da aplicação
COPY . .

# Instalar dependências PHP via composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Copiar arquivo do supervisord
COPY ./supervisord.conf /etc/supervisor/conf.d/supervisord.conf

CMD ["/usr/bin/supervisord", "-n"]
