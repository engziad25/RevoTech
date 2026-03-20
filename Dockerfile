FROM php:8.2-cli

WORKDIR /app

# تثبيت الاعتماديات
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo pdo_mysql zip

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# نسخ الملفات
COPY . .

# تثبيت الحزم
RUN composer install --no-dev --optimize-autoloader

# إعداد الصلاحيات
RUN chmod -R 775 storage bootstrap/cache

# تحديد المنفذ
ENV PORT=8000
EXPOSE $PORT

# بدء الخادم
CMD php artisan serve --host=0.0.0.0 --port=$PORT