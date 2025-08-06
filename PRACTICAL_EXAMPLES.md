# 🛠️ Practical Examples Guide - Auto-Market Project

## 🎯 Overview
This guide provides practical examples and code snippets for common development tasks in the Auto-Market project. Use these examples as reference for implementing similar functionality.

## 🚗 Car Management Examples

### 1. Creating a New Car Controller Method

```php
// app/Http/Controllers/CarController.php

public function store(Request $request)
{
    // Validate input
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'make' => 'required|string|max:100',
        'model' => 'required|string|max:100',
        'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
        'price' => 'required|numeric|min:0',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    // Create car
    $car = Car::create([
        'title' => $validated['title'],
        'description' => $validated['description'],
        'make' => $validated['make'],
        'model' => $validated['model'],
        'year' => $validated['year'],
        'price' => $validated['price'],
        'user_id' => auth()->id(),
        'status' => 'pending',
        'approval_status' => 'pending'
    ]);

    // Handle image uploads
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('cars', 'public');
            CarImage::create([
                'car_id' => $car->id,
                'image_path' => $path,
                'is_primary' => $index === 0 // First image is primary
            ]);
        }
    }

    // Send notification to admin if user is sub-admin
    if (auth()->user()->isSubAdmin()) {
        try {
            $mainAdmins = User::where('role', 'admin')->where('status', 'active')->get();
            foreach ($mainAdmins as $admin) {
                $admin->notify(new CarAddedNotification($car, auth()->user()));
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send car added notification: ' . $e->getMessage());
        }
    }

    return redirect()->route('cars.show', $car)
        ->with('success', __('cars.messages.created_successfully'));
}
```

### 2. Car Model with Relationships

```php
// app/Models/Car.php

class Car extends Model
{
    protected $fillable = [
        'title', 'description', 'make', 'model', 'year', 
        'price', 'status', 'approval_status', 'user_id'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'year' => 'integer',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(CarImage::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(CarImage::class)->where('is_primary', true);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('approval_status', 'approved');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    // Accessors
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 2) . ' ' . __('common.currency');
    }

    public function getStatusLabelAttribute()
    {
        return __('cars.status.' . $this->status);
    }
}
```

### 3. Car Search and Filtering

```php
// app/Http/Controllers/CarController.php

public function index(Request $request)
{
    $query = Car::with(['user', 'primaryImage'])
        ->approved()
        ->available();

    // Search by title, make, or model
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('make', 'like', "%{$search}%")
              ->orWhere('model', 'like', "%{$search}%");
        });
    }

    // Filter by price range
    if ($request->filled('min_price')) {
        $query->where('price', '>=', $request->min_price);
    }
    if ($request->filled('max_price')) {
        $query->where('price', '<=', $request->max_price);
    }

    // Filter by year range
    if ($request->filled('min_year')) {
        $query->where('year', '>=', $request->min_year);
    }
    if ($request->filled('max_year')) {
        $query->where('year', '<=', $request->max_year);
    }

    // Filter by make
    if ($request->filled('make')) {
        $query->where('make', $request->make);
    }

    // Sort results
    $sortBy = $request->get('sort', 'created_at');
    $sortOrder = $request->get('order', 'desc');
    $query->orderBy($sortBy, $sortOrder);

    $cars = $query->paginate(12);

    return view('cars.index', compact('cars'));
}
```

## 🔔 Notification System Examples

### 1. Creating a Custom Notification

```php
// app/Notifications/CarApprovalNotification.php

class CarApprovalNotification extends Notification
{
    use Queueable;

    public $car;
    public $approver;

    public function __construct($car, $approver)
    {
        $this->car = $car;
        $this->approver = $approver;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'car_approval',
            'car_id' => $this->car->id,
            'car_title' => $this->car->title,
            'approver_name' => $this->approver->name,
            'message_en' => "Your car '{$this->car->title}' has been approved by {$this->approver->name}.",
            'message_ar' => "تمت الموافقة على سيارتك '{$this->car->title}' بواسطة {$this->approver->name}.",
            'action_url' => route('cars.show', $this->car->id)
        ];
    }

    public function toMail($notifiable)
    {
        $locale = app()->getLocale();
        $message = $locale === 'ar' ? $this->toArray($notifiable)['message_ar'] : $this->toArray($notifiable)['message_en'];

        return (new MailMessage)
            ->subject(__('notifications.car_approval.subject'))
            ->line($message)
            ->action(__('notifications.view_car'), route('cars.show', $this->car->id))
            ->line(__('notifications.thank_you'));
    }
}
```

### 2. Sending Notifications in Controller

```php
// Example: Approving a car

public function approve(Car $car)
{
    // Check authorization
    $this->authorize('approve', $car);

    // Update car status
    $car->update([
        'approval_status' => 'approved',
        'status' => 'available'
    ]);

    // Send notification to car owner
    try {
        $car->user->notify(new CarApprovalNotification($car, auth()->user()));
    } catch (\Exception $e) {
        \Log::error('Failed to send car approval notification: ' . $e->getMessage());
    }

    return redirect()->back()
        ->with('success', __('cars.messages.approved_successfully'));
}
```

## 🌍 Multi-Language Examples

### 1. Translation File Structure

```php
// resources/lang/en/cars.php

return [
    'title' => 'Cars',
    'add_car' => 'Add Car',
    'edit_car' => 'Edit Car',
    'car_details' => 'Car Details',
    
    'fields' => [
        'title' => 'Title',
        'description' => 'Description',
        'make' => 'Make',
        'model' => 'Model',
        'year' => 'Year',
        'price' => 'Price',
        'status' => 'Status',
    ],
    
    'status' => [
        'available' => 'Available',
        'sold' => 'Sold',
        'pending' => 'Pending',
        'rejected' => 'Rejected',
    ],
    
    'messages' => [
        'created_successfully' => 'Car created successfully!',
        'updated_successfully' => 'Car updated successfully!',
        'deleted_successfully' => 'Car deleted successfully!',
        'approved_successfully' => 'Car approved successfully!',
        'rejected_successfully' => 'Car rejected successfully!',
    ],
    
    'validation' => [
        'title_required' => 'Car title is required.',
        'price_numeric' => 'Price must be a number.',
        'year_valid' => 'Please enter a valid year.',
    ],
];
```

```php
// resources/lang/ar/cars.php

return [
    'title' => 'السيارات',
    'add_car' => 'إضافة سيارة',
    'edit_car' => 'تعديل السيارة',
    'car_details' => 'تفاصيل السيارة',
    
    'fields' => [
        'title' => 'العنوان',
        'description' => 'الوصف',
        'make' => 'الماركة',
        'model' => 'الموديل',
        'year' => 'السنة',
        'price' => 'السعر',
        'status' => 'الحالة',
    ],
    
    'status' => [
        'available' => 'متاح',
        'sold' => 'مباع',
        'pending' => 'في الانتظار',
        'rejected' => 'مرفوض',
    ],
    
    'messages' => [
        'created_successfully' => 'تم إنشاء السيارة بنجاح!',
        'updated_successfully' => 'تم تحديث السيارة بنجاح!',
        'deleted_successfully' => 'تم حذف السيارة بنجاح!',
        'approved_successfully' => 'تمت الموافقة على السيارة بنجاح!',
        'rejected_successfully' => 'تم رفض السيارة بنجاح!',
    ],
    
    'validation' => [
        'title_required' => 'عنوان السيارة مطلوب.',
        'price_numeric' => 'السعر يجب أن يكون رقماً.',
        'year_valid' => 'يرجى إدخال سنة صحيحة.',
    ],
];
```

### 2. Using Translations in Blade Templates

```php
{{-- resources/views/cars/index.blade.php --}}

@extends('layouts.app')

@section('title', __('cars.title'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
            {{ __('cars.title') }}
        </h1>
        
        @can('create', App\Models\Car::class)
        <a href="{{ route('cars.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            {{ __('cars.add_car') }}
        </a>
        @endcan
    </div>

    {{-- Search Form --}}
    <form method="GET" action="{{ route('cars.index') }}" class="mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="{{ __('cars.fields.title') }}"
                   class="border rounded px-3 py-2">
            
            <select name="make" class="border rounded px-3 py-2">
                <option value="">{{ __('cars.fields.make') }}</option>
                @foreach($makes as $make)
                    <option value="{{ $make }}" {{ request('make') == $make ? 'selected' : '' }}>
                        {{ $make }}
                    </option>
                @endforeach
            </select>
            
            <input type="number" name="min_price" value="{{ request('min_price') }}"
                   placeholder="{{ __('cars.fields.price') }}"
                   class="border rounded px-3 py-2">
            
            <button type="submit" 
                    class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                {{ __('common.search') }}
            </button>
        </div>
    </form>

    {{-- Cars Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($cars as $car)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            @if($car->primaryImage)
            <img src="{{ Storage::url($car->primaryImage->image_path) }}" 
                 alt="{{ $car->title }}"
                 class="w-full h-48 object-cover">
            @endif
            
            <div class="p-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                    {{ $car->title }}
                </h3>
                
                <p class="text-gray-600 dark:text-gray-400 mb-2">
                    {{ $car->make }} {{ $car->model }} ({{ $car->year }})
                </p>
                
                <p class="text-xl font-bold text-blue-600 dark:text-blue-400 mb-2">
                    {{ $car->formatted_price }}
                </p>
                
                <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded">
                    {{ $car->status_label }}
                </span>
                
                <div class="mt-4">
                    <a href="{{ route('cars.show', $car) }}" 
                       class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                        {{ __('common.view_details') }}
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $cars->links() }}
    </div>
</div>
@endsection
```

## 👥 User Management Examples

### 1. User Model with Role Methods

```php
// app/Models/User.php

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'status', 'phone', 'avatar'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Role checking methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isSubAdmin()
    {
        return $this->role === 'sub-admin';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function hasAnyRole($roles)
    {
        return in_array($this->role, (array) $roles);
    }

    // Relationships
    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    public function spareParts()
    {
        return $this->hasMany(SparePart::class);
    }

    public function favoriteCars()
    {
        return $this->belongsToMany(Car::class, 'favorites');
    }

    public function notifications()
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }
}
```

### 2. Authorization Policy Example

```php
// app/Policies/CarPolicy.php

class CarPolicy
{
    public function viewAny(User $user)
    {
        return true; // Anyone can view cars
    }

    public function view(User $user, Car $car)
    {
        return true; // Anyone can view car details
    }

    public function create(User $user)
    {
        return $user->hasAnyRole(['admin', 'sub-admin', 'user']);
    }

    public function update(User $user, Car $car)
    {
        return $user->id === $car->user_id || $user->isAdmin();
    }

    public function delete(User $user, Car $car)
    {
        return $user->id === $car->user_id || $user->isAdmin();
    }

    public function approve(User $user, Car $car)
    {
        return $user->isAdmin();
    }

    public function reject(User $user, Car $car)
    {
        return $user->isAdmin();
    }
}
```

## 🧪 Testing Examples

### 1. Feature Test for Car Creation

```php
// tests/Feature/CarManagementTest.php

class CarManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_car()
    {
        $user = User::factory()->create(['role' => 'user']);
        
        $carData = [
            'title' => 'Test Car',
            'description' => 'A test car description',
            'make' => 'Toyota',
            'model' => 'Camry',
            'year' => 2020,
            'price' => 25000,
        ];

        $response = $this->actingAs($user)
            ->post(route('cars.store'), $carData);

        $response->assertRedirect();
        $this->assertDatabaseHas('cars', [
            'title' => 'Test Car',
            'user_id' => $user->id,
            'status' => 'pending'
        ]);
    }

    public function test_admin_can_approve_car()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);
        $car = Car::factory()->create([
            'user_id' => $user->id,
            'approval_status' => 'pending'
        ]);

        $response = $this->actingAs($admin)
            ->patch(route('cars.approve', $car));

        $response->assertRedirect();
        $this->assertDatabaseHas('cars', [
            'id' => $car->id,
            'approval_status' => 'approved',
            'status' => 'available'
        ]);
    }

    public function test_notification_sent_when_car_approved()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);
        $car = Car::factory()->create([
            'user_id' => $user->id,
            'approval_status' => 'pending'
        ]);

        $this->actingAs($admin)
            ->patch(route('cars.approve', $car));

        $this->assertDatabaseHas('notifications', [
            'notifiable_id' => $user->id,
            'notifiable_type' => User::class,
            'type' => CarApprovalNotification::class,
        ]);
    }
}
```

### 2. Language Test Example

```php
// tests/Feature/LanguageTest.php

class LanguageTest extends TestCase
{
    public function test_can_switch_to_arabic()
    {
        $response = $this->get(route('language.switch', 'ar'));
        
        $response->assertRedirect();
        $this->assertEquals('ar', session('locale'));
    }

    public function test_can_switch_to_english()
    {
        $response = $this->get(route('language.switch', 'en'));
        
        $response->assertRedirect();
        $this->assertEquals('en', session('locale'));
    }

    public function test_ignores_invalid_language()
    {
        $response = $this->get(route('language.switch', 'fr'));
        
        $response->assertRedirect();
        $this->assertNull(session('locale'));
    }

    public function test_translations_work_correctly()
    {
        // Test English
        app()->setLocale('en');
        $this->assertEquals('Cars', __('cars.title'));
        
        // Test Arabic
        app()->setLocale('ar');
        $this->assertEquals('السيارات', __('cars.title'));
    }
}
```

## 🔧 Middleware Examples

### 1. Admin Middleware

```php
// app/Http/Middleware/AdminMiddleware.php

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!auth()->user()->isAdmin()) {
            abort(403, __('auth.unauthorized'));
        }

        return $next($request);
    }
}
```

### 2. Approval Middleware

```php
// app/Http/Middleware/ApprovalMiddleware.php

class ApprovalMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!auth()->user()->hasAnyRole(['admin', 'sub-admin'])) {
            abort(403, __('auth.unauthorized'));
        }

        return $next($request);
    }
}
```

## 📊 Database Migration Examples

### 1. Cars Table Migration

```php
// database/migrations/2023_04_08_000001_create_cars_table.php

public function up()
{
    Schema::create('cars', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('description');
        $table->string('make');
        $table->string('model');
        $table->integer('year');
        $table->decimal('price', 10, 2);
        $table->enum('status', ['available', 'sold', 'pending', 'rejected'])
              ->default('pending');
        $table->enum('approval_status', ['pending', 'approved', 'rejected'])
              ->default('pending');
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->timestamps();
        
        $table->index(['status', 'approval_status']);
        $table->index(['make', 'model']);
        $table->index('price');
    });
}
```

### 2. Notifications Table Migration

```php
// database/migrations/2025_08_02_161514_create_notifications_table.php

public function up()
{
    Schema::create('notifications', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->string('type');
        $table->morphs('notifiable');
        $table->text('data');
        $table->timestamp('read_at')->nullable();
        $table->timestamps();
        
        $table->index(['notifiable_type', 'notifiable_id']);
        $table->index(['notifiable_type', 'notifiable_id', 'read_at']);
    });
}
```

## 🎨 Frontend Component Examples

### 1. Vue.js Car Card Component

```vue
<!-- resources/js/components/CarCard.vue -->

<template>
  <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
    <img v-if="car.primary_image" 
         :src="car.primary_image_url" 
         :alt="car.title"
         class="w-full h-48 object-cover">
    
    <div class="p-4">
      <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
        {{ car.title }}
      </h3>
      
      <p class="text-gray-600 dark:text-gray-400 mb-2">
        {{ car.make }} {{ car.model }} ({{ car.year }})
      </p>
      
      <p class="text-xl font-bold text-blue-600 dark:text-blue-400 mb-2">
        {{ formatPrice(car.price) }}
      </p>
      
      <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded">
        {{ getStatusLabel(car.status) }}
      </span>
      
      <div class="mt-4 flex justify-between items-center">
        <a :href="car.show_url" 
           class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
          {{ $t('common.view_details') }}
        </a>
        
        <button @click="toggleFavorite" 
                :class="isFavorited ? 'text-red-500' : 'text-gray-400'"
                class="hover:text-red-500 transition-colors">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
          </svg>
        </button>
      </div>
    </div>
</div>
</template>

<script>
export default {
  props: {
    car: {
      type: Object,
      required: true
    }
  },
  
  data() {
    return {
      isFavorited: this.car.is_favorited || false
    }
  },
  
  methods: {
    formatPrice(price) {
      return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
      }).format(price);
    },
    
    getStatusLabel(status) {
      return this.$t(`cars.status.${status}`);
    },
    
    async toggleFavorite() {
      try {
        const response = await axios.post(`/favorites/${this.car.id}`);
        this.isFavorited = response.data.is_favorited;
      } catch (error) {
        console.error('Error toggling favorite:', error);
      }
    }
  }
}
</script>
```

### 2. Alpine.js Search Component

```html
<!-- resources/views/components/search-form.blade.php -->

<div x-data="searchForm()" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
  <form @submit.prevent="submitSearch" method="GET" action="{{ route('cars.index') }}">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
      <!-- Search Input -->
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
          {{ __('cars.fields.title') }}
        </label>
        <input type="text" 
               name="search" 
               x-model="filters.search"
               placeholder="{{ __('cars.fields.title') }}"
               class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                </div>
      
      <!-- Make Select -->
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
          {{ __('cars.fields.make') }}
        </label>
        <select name="make" 
                x-model="filters.make"
                class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
          <option value="">{{ __('common.select_make') }}</option>
          @foreach($makes as $make)
            <option value="{{ $make }}">{{ $make }}</option>
          @endforeach
        </select>
            </div>
      
      <!-- Price Range -->
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
          {{ __('cars.fields.price') }}
        </label>
        <div class="flex space-x-2">
          <input type="number" 
                 name="min_price" 
                 x-model="filters.min_price"
                 placeholder="{{ __('common.min') }}"
                 class="w-1/2 border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
          <input type="number" 
                 name="max_price" 
                 x-model="filters.max_price"
                 placeholder="{{ __('common.max') }}"
                 class="w-1/2 border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
        </div>
      </div>
      
      <!-- Submit Button -->
      <div class="flex items-end">
        <button type="submit" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition-colors">
          {{ __('common.search') }}
        </button>
        </div>
    </div>
  </form>
</div>

<script>
function searchForm() {
  return {
    filters: {
      search: '{{ request('search') }}',
      make: '{{ request('make') }}',
      min_price: '{{ request('min_price') }}',
      max_price: '{{ request('max_price') }}'
    },
    
    submitSearch() {
      const params = new URLSearchParams();
      
      Object.keys(this.filters).forEach(key => {
        if (this.filters[key]) {
          params.append(key, this.filters[key]);
        }
      });
      
      window.location.href = '{{ route('cars.index') }}?' + params.toString();
    }
  }
}
</script>
```

---

## 🚀 Quick Reference Commands

### Development Commands
```bash
# Start environment
docker compose up -d

# Install dependencies
docker compose exec app composer install
docker compose exec app npm install

# Database operations
docker compose exec app php artisan migrate --seed
docker compose exec app php artisan migrate:fresh --seed

# Asset compilation
docker compose exec app npm run dev
docker compose exec app npm run build

# Testing
docker compose exec app php artisan test
docker compose exec app php artisan test --filter=CarManagementTest

# Queue processing
docker compose exec app php artisan queue:work
docker compose exec app php artisan queue:restart
```

### Useful Artisan Commands
```bash
# Create new components
docker compose exec app php artisan make:controller CarController
docker compose exec app php artisan make:model Car -m
docker compose exec app php artisan make:notification CarAddedNotification
docker compose exec app php artisan make:policy CarPolicy
docker compose exec app php artisan make:middleware AdminMiddleware

# Clear caches
docker compose exec app php artisan cache:clear
docker compose exec app php artisan config:clear
docker compose exec app php artisan view:clear
docker compose exec app php artisan route:clear

# Generate keys and links
docker compose exec app php artisan key:generate
docker compose exec app php artisan storage:link
```

This practical examples guide provides real-world code snippets and patterns for working with the Auto-Market project. Use these examples as reference for implementing similar functionality in your development tasks. 