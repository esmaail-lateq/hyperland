# 🐳 دليل إعداد Docker - Auto-Market

## 📋 نظرة عامة على إعداد Docker

مشروع Auto-Market يستخدم Docker لتوفير بيئة تطوير موحدة ومتسقة. يتكون الإعداد من 4 خدمات رئيسية:

### الخدمات المتوفرة
1. **app** - تطبيق Laravel (PHP-FPM 8.2)
2. **webserver** - خادم Nginx
3. **db** - قاعدة بيانات MySQL 8.0
4. **phpmyadmin** - واجهة إدارة قاعدة البيانات

## 🏗️ هيكلية ملفات Docker

### الملفات الرئيسية
```
Auto-Market/
├── docker-compose.yml      # تكوين الخدمات
├── Dockerfile              # صورة تطبيق Laravel
└── docker/
    ├── nginx.conf          # تكوين Nginx
    └── php.ini             # إعدادات PHP
```

### تفاصيل الملفات

#### 1. docker-compose.yml
```yaml
services:
  app:                    # تطبيق Laravel
    build: .
    container_name: laravel_app
    working_dir: /var/www/html
    volumes:
      - ./:/var/www/html
      - ./docker/php.ini:/usr/local/etc/php/conf.d/custom.ini
    networks:
      - laravel-network
    depends_on:
      - db
    ports:
      - "9000:9000"

  webserver:              # خادم Nginx
    image: nginx:alpine
    container_name: laravel_webserver
    depends_on:
      - app
    ports:
      - "8001:80"
    volumes:
      - ./:/var/www/html
      - ./docker/nginx.conf:/etc/nginx/conf.d/default.conf
    networks:
      - laravel-network

  db:                     # قاعدة البيانات
    image: mysql:8.0
    container_name: laravel_db
    restart: unless-stopped
    environment:
      MYSQL_ROOT_PASSWORD: rootpassword
      MYSQL_DATABASE: hybridland
    ports:
      - "3306:3306"
    volumes:
      - dbdata:/var/lib/mysql
    networks:
      - laravel-network

  phpmyadmin:             # واجهة إدارة قاعدة البيانات
    image: phpmyadmin/phpmyadmin
    container_name: laravel_phpmyadmin
    restart: unless-stopped
    ports:
      - "8081:80"
    environment:
      PMA_HOST: laravel_db
      MYSQL_ROOT_PASSWORD: rootpassword
    depends_on:
      - db
    networks:
      - laravel-network
```

#### 2. Dockerfile
```dockerfile
# استخدم صورة PHP الرسمية مع FPM
FROM php:8.2-fpm

# تثبيت امتدادات PDO و PDO_MYSQL المطلوبة
RUN docker-php-ext-install pdo pdo_mysql

# تعيين مجلد العمل داخل الحاوية
WORKDIR /var/www/html
```

#### 3. docker/nginx.conf
```nginx
server {
    listen 80;
    index index.php index.html;
    server_name localhost;
    root /var/www/html/public;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass laravel_app:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

#### 4. docker/php.ini
```ini
display_errors=On
error_reporting=E_ALL
```

## 🚀 أوامر Docker الأساسية

### تشغيل وإيقاف الخدمات
```bash
# تشغيل جميع الخدمات في الخلفية
docker-compose up -d

# تشغيل جميع الخدمات مع عرض السجلات
docker-compose up

# إيقاف جميع الخدمات
docker-compose down

# إيقاف جميع الخدمات وحذف البيانات
docker-compose down -v
```

### إعادة بناء الخدمات
```bash
# إعادة بناء جميع الخدمات
docker-compose up --build

# إعادة بناء خدمة معينة
docker-compose up --build app

# إعادة بناء بدون كاش
docker-compose build --no-cache
```

### إدارة الحاويات
```bash
# عرض الحاويات النشطة
docker-compose ps

# عرض سجلات جميع الخدمات
docker-compose logs

# عرض سجلات خدمة معينة
docker-compose logs app
docker-compose logs webserver
docker-compose logs db
docker-compose logs phpmyadmin

# متابعة السجلات في الوقت الفعلي
docker-compose logs -f
```

### الدخول إلى الحاويات
```bash
# الدخول إلى حاوية التطبيق
docker-compose exec app bash

# الدخول إلى قاعدة البيانات
docker-compose exec db mysql -u root -p

# الدخول إلى حاوية Nginx
docker-compose exec webserver sh
```

## 🔧 إعداد المشروع مع Docker

### الخطوة 1: تشغيل الخدمات
```bash
# تشغيل جميع الخدمات
docker-compose up -d

# التحقق من حالة الخدمات
docker-compose ps
```

### الخطوة 2: إعداد البيئة
```bash
# نسخ ملف البيئة
docker-compose exec app cp .env.example .env

# توليد مفتاح التطبيق
docker-compose exec app php artisan key:generate
```

### الخطوة 3: إعداد قاعدة البيانات
```bash
# تشغيل الهجرات
docker-compose exec app php artisan migrate

# تشغيل الهجرات مع البيانات التجريبية
docker-compose exec app php artisan migrate --seed

# إنشاء رابط التخزين
docker-compose exec app php artisan storage:link
```

### الخطوة 4: الوصول للتطبيق
- **التطبيق الرئيسي:** http://localhost:8001
- **phpMyAdmin:** http://localhost:8081
  - **اسم المستخدم:** root
  - **كلمة المرور:** rootpassword

## 🛠️ أوامر Artisan مع Docker

### الأوامر الأساسية
```bash
# تشغيل التطبيق
docker-compose exec app php artisan serve

# عرض قائمة الأوامر المتوفرة
docker-compose exec app php artisan list

# مسح الكاش
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan view:clear

# تحسين التطبيق
docker-compose exec app php artisan optimize
```

### إدارة قاعدة البيانات
```bash
# تشغيل الهجرات
docker-compose exec app php artisan migrate

# التراجع عن آخر هجرة
docker-compose exec app php artisan migrate:rollback

# إعادة تشغيل جميع الهجرات
docker-compose exec app php artisan migrate:fresh

# إعادة تشغيل الهجرات مع البيانات التجريبية
docker-compose exec app php artisan migrate:fresh --seed
```

### إنشاء ملفات جديدة
```bash
# إنشاء Controller
docker-compose exec app php artisan make:controller NewController

# إنشاء Model
docker-compose exec app php artisan make:model NewModel

# إنشاء Model مع Migration
docker-compose exec app php artisan make:model NewModel -m

# إنشاء Middleware
docker-compose exec app php artisan make:middleware NewMiddleware

# إنشاء Request
docker-compose exec app php artisan make:request NewRequest
```

## 🔍 استكشاف الأخطاء

### مشاكل شائعة وحلولها

#### 1. مشكلة في الاتصال بقاعدة البيانات
```bash
# التحقق من حالة قاعدة البيانات
docker-compose logs db

# إعادة تشغيل قاعدة البيانات
docker-compose restart db

# الدخول إلى قاعدة البيانات للتحقق
docker-compose exec db mysql -u root -p
```

#### 2. مشكلة في Nginx
```bash
# التحقق من سجلات Nginx
docker-compose logs webserver

# إعادة تشغيل Nginx
docker-compose restart webserver

# التحقق من تكوين Nginx
docker-compose exec webserver nginx -t
```

#### 3. مشكلة في تطبيق Laravel
```bash
# التحقق من سجلات التطبيق
docker-compose logs app

# إعادة تشغيل التطبيق
docker-compose restart app

# مسح كاش Laravel
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
```

#### 4. مشكلة في الصلاحيات
```bash
# تغيير صلاحيات الملفات
docker-compose exec app chmod -R 755 storage
docker-compose exec app chmod -R 755 bootstrap/cache

# تغيير مالك الملفات
docker-compose exec app chown -R www-data:www-data storage
docker-compose exec app chown -R www-data:www-data bootstrap/cache
```

## 📊 مراقبة الأداء

### عرض إحصائيات الحاويات
```bash
# عرض إحصائيات جميع الحاويات
docker stats

# عرض إحصائيات حاوية معينة
docker stats laravel_app
docker stats laravel_db
```

### مراقبة استخدام الموارد
```bash
# عرض معلومات الشبكة
docker network ls
docker network inspect auto-market_laravel-network

# عرض معلومات التخزين
docker volume ls
docker volume inspect auto-market_dbdata
```

## 🔒 الأمان

### إعدادات الأمان الموصى بها
```bash
# تغيير كلمة مرور قاعدة البيانات
# تعديل docker-compose.yml
environment:
  MYSQL_ROOT_PASSWORD: your_secure_password

# إضافة متغيرات بيئية للتطبيق
# في ملف .env
DB_HOST=laravel_db
DB_PORT=3306
DB_DATABASE=hybridland
DB_USERNAME=root
DB_PASSWORD=rootpassword
```

## 📝 ملاحظات مهمة

### 1. البيانات المستمرة
- بيانات قاعدة البيانات محفوظة في volume `dbdata`
- ملفات التطبيق محفوظة في مجلد المشروع المحلي

### 2. المنافذ المستخدمة
- **8001:** Nginx Web Server
- **9000:** PHP-FPM
- **3306:** MySQL Database
- **8081:** phpMyAdmin

### 3. الشبكة
- جميع الخدمات متصلة بشبكة `laravel-network`
- الخدمات تتواصل عبر أسماء الحاويات

### 4. التطوير
- التغييرات في الكود تنعكس فوراً
- لا حاجة لإعادة تشغيل الحاويات عند تعديل الكود

---

**ملاحظة:** هذا الدليل يوفر معلومات شاملة لإعداد وإدارة Docker في مشروع Auto-Market. 