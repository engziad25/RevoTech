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

# حذف ملفات Laravel المؤقتة
RUN rm -rf /var/www/html

# إعداد Nginx
RUN echo "server {
    listen 8000;
    server_name _;
    root /app/public;
    index index.php;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
        include fastcgi_params;
    }
}" > /etc/nginx/sites-available/default

# تحديد المنفذ
ENV PORT=8000
EXPOSE $PORT

# بدء الخدمات
CMD service nginx start && php-fpm -F