<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\SparePartController;
use App\Http\Controllers\DealerController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminCarController;
use App\Http\Controllers\CarImageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\Profile\AvatarController;
use App\Http\Controllers\UnifiedCarController;

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

// Cars routes
Route::resource('cars', CarController::class);

// Car images routes
Route::middleware('auth')->group(function () {
    Route::delete('/car-images/{image}', [CarImageController::class, 'destroy'])->name('car-images.destroy');
    Route::patch('/car-images/{image}/set-primary', [CarImageController::class, 'setPrimary'])->name('car-images.set-primary');
    Route::post('/cars/{car}/reorder-images', [CarImageController::class, 'reorder'])->name('cars.reorder-images');
});

// Spare Parts routes
Route::get('/spare-parts', [SparePartController::class, 'index'])->name('spare-parts.index');
Route::post('/spare-parts/request-custom', [SparePartController::class, 'requestCustom'])->name('spare-parts.request-custom');

// Dealer routes (keeping for backward compatibility)
Route::get('/dealers', [DealerController::class, 'index'])->name('dealers.index');
Route::get('/dealers/{dealer}', [DealerController::class, 'show'])->name('dealers.show');

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
    
    Route::get('/my-cars', [ProfileController::class, 'myCars'])->name('profile.my-cars');
    Route::patch('/my-cars/{car}/update-status', [ProfileController::class, 'updateCarStatus'])->name('profile.cars.update-status');
    
    // Spare Parts Management
    Route::resource('spare-parts', SparePartController::class)->except(['index']);
    
    // Unified Car Management
    Route::get('/unified-cars', [UnifiedCarController::class, 'index'])->name('unified-cars.index');
    Route::patch('/unified-cars/{car}/update-status', [UnifiedCarController::class, 'updateStatus'])->name('unified-cars.update-status');
    Route::patch('/unified-cars/{car}/toggle-featured', [UnifiedCarController::class, 'toggleFeatured'])->name('unified-cars.toggle-featured');
    Route::patch('/unified-cars/{car}/approve', [UnifiedCarController::class, 'approve'])->name('unified-cars.approve');
    Route::patch('/unified-cars/{car}/reject', [UnifiedCarController::class, 'reject'])->name('unified-cars.reject');
    
    // Spare Parts Management in Unified Panel
    Route::patch('/unified-cars/spare-parts/{sparePart}/approve', [UnifiedCarController::class, 'approveSparePart'])->name('unified-cars.spare-parts.approve');
    Route::patch('/unified-cars/spare-parts/{sparePart}/reject', [UnifiedCarController::class, 'rejectSparePart'])->name('unified-cars.spare-parts.reject');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/cars', [AdminCarController::class, 'index'])->name('cars.index');
    Route::patch('/cars/{car}/approve', [AdminCarController::class, 'approve'])->name('cars.approve');
    Route::patch('/cars/{car}/reject', [AdminCarController::class, 'reject'])->name('cars.reject');
    Route::patch('/cars/{car}/mark-sold', [AdminCarController::class, 'markAsSold'])->name('cars.mark-sold');
    Route::patch('/cars/{car}/toggle-featured', [AdminCarController::class, 'toggleFeatured'])->name('cars.toggle-featured');
    Route::patch('/cars/{car}/update-status', [AdminCarController::class, 'updateStatus'])->name('cars.update-status');
});

// Language switching
Route::get('language/{locale}', [App\Http\Controllers\LanguageController::class, 'switchLanguage'])->name('language.switch');

require __DIR__.'/auth.php';
