FROM php:8.2-apache

# Install system dependencies + Node.js
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpq-dev libonig-dev libxml2-dev \
    nodejs npm \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql mbstring xml

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# 🔥 Install Node dependencies & build assets
RUN npm install
RUN npm run build

# Set Apache document root to Laravel public folder
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' \
    /etc/apache2/sites-available/000-default.conf

# Allow .htaccess overrides
RUN echo '<Directory /var/www/html/public>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/apache2.conf

# Set permissions
RUN chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# (Optional but recommended) cache Laravel config
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Copy entrypoint
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]