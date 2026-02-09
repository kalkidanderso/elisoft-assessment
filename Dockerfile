FROM php:8.3-cli

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
        libicu-dev \
        libpq-dev \
    && docker-php-ext-install intl pdo_pgsql pgsql \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction

COPY . .

# Ensure .env exists for CodeIgniter (fallback to 'env' file)
RUN if [ ! -f .env ]; then cp env .env; fi

# Ensure writable directories exist and have proper permissions
RUN mkdir -p writable/cache writable/logs writable/session writable/uploads \
    && chmod -R 777 writable

ENV CI_ENVIRONMENT=production

CMD ["sh", "-c", "php -S 0.0.0.0:${PORT:-10000} -t public"]
