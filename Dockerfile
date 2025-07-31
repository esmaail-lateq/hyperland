# استخدم صورة PHP الرسمية مع FPM
FROM php:8.2-fpm

# تثبيت امتدادات PDO و PDO_MYSQL المطلوبة
RUN docker-php-ext-install pdo pdo_mysql

# تعيين مجلد العمل داخل الحاوية
WORKDIR /var/www/html
