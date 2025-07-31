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
        'cylinders',
        'fuel_type',
        'condition',
        'location',
        'user_id',
        'status',
        'approval_status',
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
        'cylinders' => 'integer',
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
        return $query->where('approval_status', 'approved');
    }

    /**
     * Scope a query to only include pending cars.
     */
    public function scopePending($query)
    {
        return $query->where('approval_status', 'pending');
    }

    /**
     * Scope a query to only include rejected cars.
     */
    public function scopeRejected($query)
    {
        return $query->where('approval_status', 'rejected');
    }

    /**
     * Scope a query to only include sold cars.
     */
    public function scopeSold($query)
    {
        return $query->where('status', 'sold');
    }

    /**
     * Scope a query to only include available cars (not sold).
     */
    public function scopeAvailable($query)
    {
        return $query->whereIn('status', ['available', 'at_customs', 'in_transit', 'purchased']);
    }

    /**
     * Scope a query to only include cars available in Yemen.
     */
    public function scopeAvailableInYemen($query)
    {
        return $query->where('status', 'available');
    }

    /**
     * Scope a query to only include cars available at customs.
     */
    public function scopeAvailableAtCustoms($query)
    {
        return $query->where('status', 'at_customs');
    }

    /**
     * Scope a query to only include cars shipping to Yemen.
     */
    public function scopeShippingToYemen($query)
    {
        return $query->where('status', 'in_transit');
    }

    /**
     * Scope a query to only include recently purchased cars.
     */
    public function scopeRecentlyPurchased($query)
    {
        return $query->where('status', 'purchased');
    }

    /**
     * Get the status display text.
     */
    public function getStatusDisplayAttribute()
    {
        $statusMap = [
            'available' => 'متوفرة للبيع في اليمن',
            'at_customs' => 'متوفرة في المنافذ الجمركية',
            'in_transit' => 'قيد الشحن إلى اليمن',
            'purchased' => 'تم شراؤها مؤخراً من المزاد',
            'sold' => 'تم البيع'
        ];

        return $statusMap[$this->status] ?? $this->status;
    }

    /**
     * Get the status badge color class.
     */
    public function getStatusBadgeClassAttribute()
    {
        $badgeMap = [
            'available' => 'bg-green-100 text-green-800',
            'at_customs' => 'bg-blue-100 text-blue-800',
            'in_transit' => 'bg-yellow-100 text-yellow-800',
            'purchased' => 'bg-purple-100 text-purple-800',
            'sold' => 'bg-gray-100 text-gray-800'
        ];

        return $badgeMap[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    /**
     * Get the status icon.
     */
    public function getStatusIconAttribute()
    {
        $iconMap = [
            'available' => 'M5 13l4 4L19 7',
            'at_customs' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
            'in_transit' => 'M13 10V3L4 14h7v7l9-11h-7z',
            'purchased' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
            'sold' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
        ];

        return $iconMap[$this->status] ?? 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z';
    }

    /**
     * Get the approval status display text.
     */
    public function getApprovalStatusDisplayAttribute()
    {
        $approvalMap = [
            'pending' => 'في انتظار الموافقة',
            'approved' => 'تمت الموافقة',
            'rejected' => 'مرفوضة'
        ];

        return $approvalMap[$this->approval_status] ?? $this->approval_status;
    }

    /**
     * Get the approval status badge color class.
     */
    public function getApprovalStatusBadgeClassAttribute()
    {
        $approvalBadgeMap = [
            'pending' => 'bg-orange-100 text-orange-800',
            'approved' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800'
        ];

        return $approvalBadgeMap[$this->approval_status] ?? 'bg-gray-100 text-gray-800';
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

    /**
     * Get the advertisement number for the car.
     */
    public function getAdNumberAttribute()
    {
        return 'AD-' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Check if the car is new (less than 7 days old).
     */
    public function getIsNewAttribute()
    {
        return $this->created_at->diffInDays(now()) <= 7;
    }
} 