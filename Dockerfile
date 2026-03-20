FROM php:8.2-fpm

WORKDIR /app

# تثبيت الاعتماديات
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libzip-dev \
    zip \
    nginx \
    && docker-php-ext-install pdo pdo_mysql zip

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# نسخ الملفات
COPY . .

# تثبيت الحزم
RUN composer install --no-dev --optimize-autoloader

# إعداد الصلاحيات
RUN chmod -R 775 storage bootstrap/cache

# إعداد Nginx
COPY docker/nginx.conf /etc/nginx/sites-available/default

# تحديد المنفذ
ENV PORT=8000
EXPOSE $PORT

# بدء الخدمات
CMD php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    service nginx start && \
    php-fpm -F