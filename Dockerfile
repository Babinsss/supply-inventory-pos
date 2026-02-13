FROM php:8.2-apache

# 1. Install system packages and Node.js
RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    libzip-dev \
    libpng-dev \
    git \
    curl \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# 2. Install PHP extensions
RUN docker-php-ext-install pdo_mysql zip gd

# 3. Configure Apache to point to public folder
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite

# 4. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Set working directory
WORKDIR /var/www/html

# 6. Copy application files
COPY . .

# 7. Run Build Commands
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache