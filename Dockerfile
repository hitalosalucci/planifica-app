FROM php:8.4-fpm-alpine

WORKDIR /var/www

# dependências do sistema para o laravel e vuejs (rodando no mesmo container)
RUN apk update && apk add --no-cache \
    zip \
    git \
    curl \
    unzip \
    libzip-dev \
    oniguruma-dev \
    mariadb-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libxml2-dev \
    libxslt-dev \
    nodejs \
    npm \
    && rm -rf /var/cache/apk/* \
;

# extensões PHP
RUN docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath gd

RUN docker-php-ext-enable pdo_mysql

# composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# configuração usuário não-root
RUN addgroup -g 1000 -S www && \
    adduser -u 1000 -S www -G www && \
    mkdir -p /home/www/.composer && \
    chown -R www:www /home/www

# variáveis de ambiente para npm
ENV NPM_CONFIG_PREFIX=/var/www/.npm-global
ENV PATH=/var/www/.npm-global/bin:$PATH

# permissões para o diretório de trabalho
RUN mkdir -p /var/www/node_modules /var/www/storage/framework/cache/data \
    /var/www/storage/framework/sessions \
    /var/www/storage/framework/views \
    /var/www/storage/app/public \
    /var/www/storage/logs \
    && chown -R www:www /var/www

# pacotes para a configuração inicial
COPY --chown=www:www package*.json ./

# utiliza o usuário criado - não root
USER www

# copia o restante dos arquivos do projeto
COPY --chown=www:www . /var/www

COPY docker/php/custom.ini /usr/local/etc/php/conf.d/custom.ini

# expor porta do php-fmp e vite
EXPOSE 9000 5173

#iniciar php-fmp
CMD ["php-fpm"]