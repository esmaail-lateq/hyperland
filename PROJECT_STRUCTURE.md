# Mobile.bg Car Marketplace Clone - Project Documentation

## About the Developer

I am a top senior developer with extensive experience in Laravel, Vue.js, and modern web development. I specialize in building high-performance, scalable, and secure web applications, following industry best practices and coding standards. My expertise includes full-stack development with Laravel, Vue.js, MySQL, and TailwindCSS.

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

## Database Structure

### Main Tables

1. **users**
   - id, name, email, password
   - type (enum: 'user', 'dealer')
   - phone, avatar, dealer_name (for dealerships)
   - profile information

2. **cars**
   - id, user_id (owner of the listing)
   - title, make, model, year, price, mileage
   - fuel_type, transmission, description, location
   - is_approved, is_featured
   - created_at, updated_at

3. **car_images**
   - id, car_id, image_path

4. **favorites**
   - user_id, car_id (pivot table)
   - timestamps

## Core Features

### User Types
- **Regular Users**: Can post their personal car listings
- **Car Dealerships**: Have a public profile with all their listings

### Car Listings
- Title, make, model, year, fuel type, transmission, mileage, price
- Multiple images (gallery)
- Description
- Location

### Dealership Profiles
- Company information
- Logo
- All active listings on one page (e.g., /dealers/dealership-name)

### Listing Form
- Dynamic dropdowns (e.g., make → model)
- Multiple image upload

### Search with Filters
- Filters: make, model, year, price, mileage, fuel type, transmission

### Favorites (Optional)
- List of saved cars

### Admin Panel (Optional)
- Listing approval
- User visibility management

## Seeder Logic
- 15 car dealerships with realistic names and profiles
- 50 regular users
- 300 cars with plausible fake data
- 2-5 images per car, stored locally

## Main Routes
- `/` - Home page with search and listings
- `/cars` - All cars
- `/cars/{id}` - Details for a specific car
- `/cars/create` - Add a new listing
- `/dealers/{slug}` - Public dealership profile
- `/login`, `/register` - Authentication

## Development Steps

### Phase 1: Project Setup
- [x] Install Laravel
- [ ] Configure database
- [ ] Set up user authentication
- [ ] Create models and migrations

### Phase 2: Core Functionality
- [ ] Implement user roles (regular and dealer)
- [ ] Create car CRUD operations
- [ ] Implement image upload and management
- [ ] Build search and filtering functionality

### Phase 3: Frontend Development
- [ ] Set up Tailwind CSS
- [ ] Create Vue components
- [ ] Build responsive UI
- [ ] Implement dynamic forms

### Phase 4: Advanced Features
- [ ] Dealership profiles
- [ ] Favorites functionality
- [ ] Admin panel (optional)

### Phase 5: Testing and Deployment
- [ ] Database seeding with realistic data
- [ ] Unit and feature testing
- [ ] Performance optimization
- [ ] Deployment preparation

## Code Standards

- **PHP**: PSR-12, Laravel best practices
- **JavaScript**: Airbnb Style Guide, ESLint
- **Vue**: Vue 3 Composition API
- **CSS**: Tailwind conventions

## Project Goal
- Create a realistic, complete project for portfolio
- Potential for further development into a real product
- Fully responsive, clean UI, and logically separated code 