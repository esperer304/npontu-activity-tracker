# syntax=docker/dockerfile:1
FROM php:8.4-cli-bookworm

ENV DEBIAN_FRONTEND=noninteractive
ENV COMPOSER_ALLOW_SUPERUSER=1

# System deps + PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
        git unzip curl ca-certificates \
        libpq-dev libzip-dev libicu-dev libonig-dev \
        zlib1g-dev libpng-dev libxml2-dev \
        nodejs npm \
    && docker-php-ext-install -j$(nproc) \
        pdo pdo_pgsql pgsql zip intl bcmath mbstring opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Install PHP deps first to leverage layer cache
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --optimize-autoloader

# Install node deps
COPY package.json package-lock.json ./
RUN npm ci

# Copy the app
COPY . .

# Generate autoloader after the full app is in place; build front-end
RUN composer dump-autoload --optimize \
    && npm run build \
    && npm prune --production

# Permissions for storage + bootstrap cache
RUN chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# Entrypoint: run migrations then start the server
COPY docker-entrypoint.sh /usr/local/bin/entrypoint
RUN chmod +x /usr/local/bin/entrypoint

EXPOSE 8000
CMD ["entrypoint"]
