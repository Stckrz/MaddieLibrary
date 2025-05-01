# 1) Front-end build stage (Vite)
# FROM php:8.1-fpm-alpine AS frontend-builder
FROM node:18-alpine AS frontend-builder

WORKDIR /var/www

# copy package files and Vite config
COPY package.json package-lock.json vite.config.js ./

# install Node deps
RUN npm ci

# copy only your source (so rebuilds only when sources change)
COPY resources resources
COPY public public

# run the production build (by default outputs to public/build)
RUN npm run build

# 2) PHP-FPM stage
FROM php:8.2-fpm-alpine AS app

WORKDIR /var/www

# install PHP system deps & extensions
RUN apk add --no-cache \
      libpng-dev \
      libxml2-dev \
      oniguruma-dev \
      zip \
      unzip \
 && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# pull in Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# copy all Laravel code
COPY . .

# ensure storage & cache dirs exist and are owned by www-data
RUN mkdir -p storage/framework/views \
 && chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R ug+rw storage bootstrap/cache

# ensure SQLite file & folder are writeable by www-data
RUN mkdir -p database \
 && touch database/database.sqlite \
 && chown -R www-data:www-data database \
 && chmod -R ug+rw database


# install PHP deps (excluding dev)
RUN composer install --no-dev --optimize-autoloader

# copy over built assets from frontend-builder
COPY --from=frontend-builder /var/www/public/build /var/www/public/build

# set permissions
RUN chown -R www-data:www-data /var/www \
 && chmod -R 755 /var/www/storage

EXPOSE 9000
CMD ["php-fpm"]

