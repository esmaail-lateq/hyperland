<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\SparePartController;

use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CarImageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\Profile\AvatarController;
use App\Http\Controllers\UnifiedCarController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\LanguageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Dashboard route
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// About page
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Shipping Services routes
Route::get('/shipping', [ShippingController::class, 'index'])->name('shipping.index');
Route::post('/shipping/track', [ShippingController::class, 'track'])->name('shipping.track');

// Cars routes - browsing for everyone, management for admins/sub-admins only
Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
Route::get('/cars/{car}', [CarController::class, 'show'])->name('cars.show');

// Car management routes (admin/sub-admin only)
Route::middleware(['auth', 'content.management'])->group(function () {
    Route::get('/cars/create', [CarController::class, 'create'])->name('cars.create');
    Route::post('/cars', [CarController::class, 'store'])->name('cars.store');
    Route::get('/cars/{car}/edit', [CarController::class, 'edit'])->name('cars.edit');
    Route::put('/cars/{car}', [CarController::class, 'update'])->name('cars.update');
    Route::delete('/cars/{car}', [CarController::class, 'destroy'])->name('cars.destroy');
});

// Car images routes
Route::middleware('auth')->group(function () {
    Route::delete('/car-images/{image}', [CarImageController::class, 'destroy'])->name('car-images.destroy');
    Route::patch('/car-images/{image}/set-primary', [CarImageController::class, 'setPrimary'])->name('car-images.set-primary');
    Route::post('/cars/{car}/reorder-images', [CarImageController::class, 'reorder'])->name('cars.reorder-images');
});

// Spare Parts routes - browsing for everyone, management for admins/sub-admins only
Route::get('/spare-parts', [SparePartController::class, 'index'])->name('spare-parts.index');
Route::get('/spare-parts/{sparePart}', [SparePartController::class, 'show'])->name('spare-parts.show');
Route::post('/spare-parts/request-custom', [SparePartController::class, 'requestCustom'])->name('spare-parts.request-custom');




// Favorite routes (authenticated users only)
Route::middleware('auth')->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{car}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
});

// User profile routes (authenticated users only)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Avatar routes
    Route::patch('/profile/avatar', [AvatarController::class, 'update'])->name('profile.avatar.update');
    Route::delete('/profile/avatar', [AvatarController::class, 'destroy'])->name('profile.avatar.destroy');
    
    
    
    // Spare Parts Management (admin/sub-admin only)
    Route::middleware('content.management')->group(function () {
        Route::get('/spare-parts/create', [SparePartController::class, 'create'])->name('spare-parts.create');
        Route::post('/spare-parts', [SparePartController::class, 'store'])->name('spare-parts.store');
        Route::get('/spare-parts/{sparePart}/edit', [SparePartController::class, 'edit'])->name('spare-parts.edit');
        Route::put('/spare-parts/{sparePart}', [SparePartController::class, 'update'])->name('spare-parts.update');
        Route::delete('/spare-parts/{sparePart}', [SparePartController::class, 'destroy'])->name('spare-parts.destroy');
    });
    
    // Unified Car Management (admin/sub-admin only)
    Route::middleware('content.management')->group(function () {
        Route::get('/unified-cars', [UnifiedCarController::class, 'index'])->name('unified-cars.index');
        Route::patch('/unified-cars/{car}/update-status', [UnifiedCarController::class, 'updateStatus'])->name('unified-cars.update-status');
        Route::patch('/unified-cars/{car}/toggle-featured', [UnifiedCarController::class, 'toggleFeatured'])->name('unified-cars.toggle-featured');
        Route::patch('/unified-cars/{car}/approve', [UnifiedCarController::class, 'approve'])->name('unified-cars.approve');
        Route::patch('/unified-cars/{car}/reject', [UnifiedCarController::class, 'reject'])->name('unified-cars.reject');
        
        // Spare Parts Management in Unified Panel
        Route::patch('/unified-cars/spare-parts/{sparePart}/approve', [UnifiedCarController::class, 'approveSparePart'])->name('unified-cars.spare-parts.approve');
        Route::patch('/unified-cars/spare-parts/{sparePart}/reject', [UnifiedCarController::class, 'rejectSparePart'])->name('unified-cars.spare-parts.reject');
    });
});

// Admin User Management routes (only for primary admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserManagementController::class);
    Route::patch('/users/{user}/toggle-status', [UserManagementController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::get('/users/statistics', [UserManagementController::class, 'statistics'])->name('users.statistics');
});

// Language routes
Route::get('language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');
Route::get('language/settings', [LanguageController::class, 'settings'])->name('language.settings');
Route::post('language/settings', [LanguageController::class, 'updateSettings'])->name('language.update-settings');

require __DIR__.'/auth.php';
