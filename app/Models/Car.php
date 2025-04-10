<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Car extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'make',
        'model',
        'year',
        'mileage',
        'price',
        'transmission',
        'fuel_type',
        'condition',
        'location',
        'user_id',
        'status',
        'is_featured',
        'has_air_conditioning',
        'has_leather_seats',
        'has_navigation',
        'has_parking_sensors',
        'has_parking_camera',
        'has_heated_seats',
        'has_bluetooth',
        'has_led_lights'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'year' => 'integer',
        'mileage' => 'integer',
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
        'has_air_conditioning' => 'boolean',
        'has_leather_seats' => 'boolean',
        'has_navigation' => 'boolean',
        'has_parking_sensors' => 'boolean',
        'has_parking_camera' => 'boolean',
        'has_heated_seats' => 'boolean',
        'has_bluetooth' => 'boolean',
        'has_led_lights' => 'boolean'
    ];

    /**
     * Get the user that owns the car.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the images for the car.
     */
    public function images(): HasMany
    {
        return $this->hasMany(CarImage::class);
    }

    /**
     * Get the users who favorited this car.
     */
    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites', 'car_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * Scope a query to only include approved cars.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to only include pending cars.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include rejected cars.
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Scope a query to only include featured cars.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Get the main image for the car.
     */
    public function getMainImageAttribute()
    {
        $primaryImage = $this->images()
            ->where('is_primary', true)
            ->first();
            
        if ($primaryImage) {
            return $primaryImage->image_path;
        }
        
        // If no primary image, try to get any image
        $anyImage = $this->images()->first();
        
        if ($anyImage) {
            return $anyImage->image_path;
        }
        
        // Default fallback image
        return 'images/default-car.svg';
    }

    /**
     * Get the formatted price with currency.
     */
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 0) . ' €';
    }
} 