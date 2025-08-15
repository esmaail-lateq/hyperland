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
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# تعيين مجلد العمل داخل الحاوية
WORKDIR /var/www/html

# نسخ composer files first for better caching
COPY composer.json composer.lock ./

# تثبيت تبعيات PHP
RUN composer install --no-dev --optimize-autoloader --no-scripts

# نسخ باقي ملفات التطبيق
COPY . .

# إنشاء المجلدات المطلوبة إذا لم تكن موجودة
RUN mkdir -p storage/framework/cache \
    && mkdir -p storage/framework/sessions \
    && mkdir -p storage/framework/views \
    && mkdir -p storage/logs \
    && mkdir -p bootstrap/cache

# تعيين صلاحيات الملفات
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 /var/www/html/storage \
    && chmod -R 777 /var/www/html/bootstrap/cache

# إنشاء مجلد للسجلات
RUN mkdir -p /var/log && touch /var/log/php_errors.log \
    && chown -R www-data:www-data /var/log/php_errors.log

# تعيين المستخدم
USER www-data
