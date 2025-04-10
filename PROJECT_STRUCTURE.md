# Mobile.bg Car Marketplace Clone - Project Documentation

## Project Overview

This project is a car marketplace platform similar to mobile.bg, allowing users and car dealerships to post vehicle listings. The application supports different user types, comprehensive search functionality, and advanced filtering options.

## Technology Stack

- **Backend**: Laravel 11
- **Frontend**: Vue.js 3 (Composition API)
- **CSS Framework**: TailwindCSS
- **Database**: MySQL
- **Build Tool**: Vite
- **Testing**: PHPUnit, Vitest

## Project Structure

```
project-root/
├── app/
│   ├── Console/
│   ├── Exceptions/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   ├── CarController.php
│   │   │   ├── DealerController.php
│   │   │   ├── ProfileController.php
│   │   │   └── Admin/
│   │   │       └── AdminCarController.php
│   │   └── Middleware/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Car.php
│   │   ├── CarImage.php
│   │   └── Favorite.php
│   └── Providers/
│
├── database/
│   ├── factories/
│   │   ├── CarFactory.php
│   │   ├── CarImageFactory.php
│   │   └── UserFactory.php
│   ├── migrations/
│   │   ├── create_users_table.php
│   │   ├── create_cars_table.php
│   │   ├── create_car_images_table.php
│   │   ├── create_favorites_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── UserSeeder.php
│       ├── CarSeeder.php
│       └── CarImageSeeder.php
│
├── resources/
│   ├── css/
│   │   └── app.css (with Tailwind)
│   ├── js/
│   │   ├── app.js
│   │   ├── components/
│   │   │   ├── CarCard.vue
│   │   │   ├── CarGallery.vue
│   │   │   └── SearchForm.vue
│   │   └── pages/
│   │       ├── Home.vue
│   │       ├── CarShow.vue
│   │       └── DealerProfile.vue
│   └── views/
│       ├── welcome.blade.php
│       ├── layout/
│       │   └── app.blade.php
│       ├── cars/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   └── show.blade.php
│       ├── dealers/
│       │   └── profile.blade.php
│       └── auth/ (registration, login, etc.)
│
├── routes/
│   ├── web.php
│   └── api.php
│
├── storage/
│   └── app/public/cars/ (for using `Storage::disk('public')`)
```

