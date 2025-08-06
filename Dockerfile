# استخدم صورة PHP الرسمية مع FPM
FROM php:8.2-fpm

# تثبيت التبعيات المطلوبة
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# تعيين مجلد العمل داخل الحاوية
WORKDIR /var/www/html

# نسخ ملفات التطبيق
COPY . .

# تثبيت تبعيات PHP
RUN composer install --no-dev --optimize-autoloader

# تعيين صلاحيات الملفات
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 /var/www/html/storage \
    && chmod -R 777 /var/www/html/bootstrap/cache

# إنشاء مجلد للسجلات
RUN mkdir -p /var/log && touch /var/log/php_errors.log \
    && chown -R www-data:www-data /var/log/php_errors.log
