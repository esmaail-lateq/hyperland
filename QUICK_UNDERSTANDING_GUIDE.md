# 🚀 Quick Understanding Guide - Auto-Market Project

## 🎯 Project Snapshot

**Auto-Market** is a comprehensive car marketplace built with Laravel 10.x, featuring:
- 🚗 Car listings with approval system
- 🔧 Spare parts marketplace
- 👥 Multi-role user system (Admin, Sub-Admin, User)
- 🌍 Multi-language support (Arabic/English with RTL)
- 🔔 Real-time notification system
- 🐳 Docker-based development environment

## 🏗️ Architecture Overview

```
Frontend: Blade + TailwindCSS + Alpine.js + Vue.js
Backend:  Laravel 10.x (PHP 8.1+)
Database: MySQL 8.0
Container: Docker & Docker Compose
```

## 🐳 Environment Setup (Docker)

### Services & Ports
- **Web Application**: `http://localhost:8001`
- **Database**: `localhost:3306` (MySQL)
- **phpMyAdmin**: `http://localhost:8081`
- **PHP-FPM**: `localhost:9000`

### Quick Start
```bash
# Start all services
docker compose up -d

# Access application
open http://localhost:8001

# Database management
open http://localhost:8081
```

## 📁 Key File Structure

### Core Models
```
app/Models/
├── User.php          # Authentication & roles
├── Car.php           # Vehicle listings
├── CarImage.php      # Car images
├── SparePart.php     # Spare parts
├── Favorite.php      # User favorites
└── Notification.php  # Real-time notifications
```

### Controllers
```
app/Http/Controllers/
├── CarController.php           # Car CRUD
├── SparePartController.php     # Spare parts
├── UnifiedCarController.php    # Admin approval
├── NotificationController.php  # Notifications
├── LanguageController.php      # Multi-language
└── Admin/                      # Admin panel
```

### Views & Assets
```
resources/
├── views/           # Blade templates
├── lang/           # Translations (ar/en)
├── css/            # TailwindCSS
└── js/             # Vue.js components
```

## 👥 User Roles & Permissions

### Role Hierarchy
1. **Admin**: Full system access, content approval
2. **Sub-Admin**: Content creation, limited management  
3. **User**: Basic marketplace access

### Key Permissions
- **Admin**: Approve/reject content, manage users, view statistics
- **Sub-Admin**: Create cars/spare parts, limited admin features
- **User**: Browse, favorite, create listings

## 🌍 Multi-Language System

### Supported Languages
- **English (en)**: Default language
- **Arabic (ar)**: Full RTL support

### Translation Files
```
resources/lang/
├── en/
│   ├── cars.php
│   ├── auth.php
│   ├── navigation.php
│   └── [modules].php
└── ar/
    ├── cars.php
    ├── auth.php
    ├── navigation.php
    └── [modules].php
```

### Language Switching
- **Route**: `/language/{locale}`
- **Controller**: `LanguageController@switch`
- **Middleware**: `SetLocale` (automatic detection)

## 🔔 Notification System

### Notification Types
1. **Content Addition**: Sub-admin → Main Admin
   - `CarAddedNotification`
   - `SparePartAddedNotification`

2. **Approval/Rejection**: Admin → User
   - `CarApprovalNotification` / `CarRejectionNotification`
   - `SparePartApprovalNotification` / `SparePartRejectionNotification`

### Channels
- **Database**: Persistent storage
- **Email**: SMTP delivery
- **Broadcast**: Real-time updates

## 🚗 Core Features

### Car Management
- **CRUD Operations**: Create, Read, Update, Delete
- **Image Management**: Multiple images per car
- **Approval System**: Admin approval workflow
- **Search & Filter**: Advanced filtering options
- **Favorites**: User bookmarking system

### Spare Parts
- **Marketplace**: Spare parts listings
- **Categories**: Organized by vehicle type
- **Approval System**: Admin review process

## 🛠️ Development Commands

### Essential Commands
```bash
# Start environment
docker compose up -d

# Install dependencies
docker compose exec app composer install
docker compose exec app npm install

# Database setup
docker compose exec app php artisan migrate --seed

# Asset compilation
docker compose exec app npm run dev

# Queue processing
docker compose exec app php artisan queue:work

# Run tests
docker compose exec app php artisan test
```

### Database Commands
```bash
# Access database
docker compose exec app php artisan tinker

# Reset database
docker compose exec app php artisan migrate:fresh --seed

# Create seeder
docker compose exec app php artisan make:seeder CarSeeder
```

### Development Tools
```bash
# Clear caches
docker compose exec app php artisan cache:clear
docker compose exec app php artisan config:clear
docker compose exec app php artisan view:clear

# Generate key
docker compose exec app php artisan key:generate

# Create storage link
docker compose exec app php artisan storage:link
```

## 📊 Database Schema

### Key Tables
```sql
users (id, name, email, role, status, phone, avatar)
cars (id, title, description, make, model, year, price, status, approval_status)
car_images (id, car_id, image_path, is_primary)
favorites (user_id, car_id)
spare_parts (id, title, description, price, condition)
notifications (id, user_id, type, data, read_at)
```

## 🔧 Configuration Files

### Environment
- **Docker**: `docker-compose.yml`, `Dockerfile`
- **Laravel**: `.env` (environment variables)
- **PHP**: `docker/php.ini`
- **Nginx**: `docker/nginx.conf`

### Build Tools
- **Composer**: `composer.json` (PHP dependencies)
- **NPM**: `package.json` (Frontend dependencies)
- **Vite**: `vite.config.js` (Asset building)
- **Tailwind**: `tailwind.config.js` (CSS framework)

## 🧪 Testing Strategy

### Test Types
- **Feature Tests**: End-to-end functionality
- **Unit Tests**: Individual component testing
- **Browser Tests**: User interaction testing

### Test Files
```
tests/
├── Feature/
│   ├── Auth/
│   ├── CarManagement/
│   ├── LanguageTest.php
│   └── NotificationTest.php
└── Unit/
    └── ExampleTest.php
```

## 🔒 Security Features

### Authentication & Authorization
- **Laravel Breeze**: Secure authentication
- **Policy-based**: Model-level permissions
- **Middleware**: Route protection
- **CSRF Protection**: Cross-site request forgery

### Data Protection
- **Input Validation**: Request validation
- **SQL Injection**: Eloquent ORM protection
- **XSS Prevention**: Blade template escaping
- **File Upload**: Secure image handling

## 📈 Performance Optimization

### Areas of Focus
- **Database Queries**: Eager loading, indexing
- **Asset Compilation**: Vite optimization
- **Caching**: Route, config, view caching
- **Queue Processing**: Background job handling
- **Image Optimization**: Storage and delivery

## 🚀 Deployment Checklist

### Production Requirements
- [ ] Environment variables configured
- [ ] Database optimized and indexed
- [ ] Queue workers running
- [ ] SSL/HTTPS enabled
- [ ] File storage configured
- [ ] Monitoring setup
- [ ] Backup strategy implemented

## 📝 Development Guidelines

### Code Standards
- **Laravel Conventions**: Follow Laravel best practices
- **PSR-4**: Autoloading standards
- **Type Hinting**: Use PHP 8.1+ features
- **Documentation**: Comprehensive code comments

### Multi-language Requirements
- **Always implement**: Both Arabic and English translations
- **RTL Support**: Proper Arabic text direction
- **Translation Keys**: Use consistent naming conventions
- **Testing**: Verify both languages work correctly

### Notification Integration
- **Add notifications**: For important user actions
- **Error handling**: Use try-catch blocks
- **Queue processing**: Ensure notifications are queued
- **Testing**: Verify notification delivery

## 🎯 Quick Task Understanding

### When Analyzing Tasks
1. **Identify Scope**: Which components are affected?
2. **Check Dependencies**: What other features might be impacted?
3. **Consider Multi-language**: Does this need translation?
4. **Add Notifications**: Are notifications needed?
5. **Update Tests**: What tests need to be modified?
6. **Document Changes**: Update relevant documentation

### Common Patterns
- **CRUD Operations**: Follow Laravel conventions
- **Form Validation**: Use Form Request classes
- **Authorization**: Implement policies
- **Notifications**: Add to relevant controllers
- **Testing**: Create feature and unit tests

---

## 🔗 Quick Access Links

- **Application**: http://localhost:8001
- **Database**: http://localhost:8081
- **Documentation**: See README.md files
- **Tests**: `docker compose exec app php artisan test`

This guide provides a quick overview for understanding the Auto-Market project structure and development workflow. 