<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'phone',
        'avatar',
        'slug',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get all cars listed by this user.
     */
    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }

    /**
     * Get all spare parts created by this user.
     */
    public function spareParts(): HasMany
    {
        return $this->hasMany(SparePart::class, 'created_by');
    }

    /**
     * Get the cars the user has favorited.
     */
    public function favoriteCars(): BelongsToMany
    {
        return $this->belongsToMany(Car::class, 'favorites', 'user_id', 'car_id')
            ->withTimestamps();
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'id';
    }

    /**
     * Check if the user is a primary admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if the user is a sub admin.
     */
    public function isSubAdmin(): bool
    {
        return $this->role === 'sub_admin';
    }

    /**
     * Check if the user is a public user.
     */
    public function isPublicUser(): bool
    {
        return $this->role === 'public_user';
    }

    /**
     * Check if the user can approve content (only primary admin).
     */
    public function canApproveContent(): bool
    {
        return $this->isAdmin();
    }

    /**
     * Check if the user can add content (admin, sub admin, and public users).
     */
    public function canAddContent(): bool
    {
        return in_array($this->role, ['admin', 'sub_admin', 'public_user']);
    }

    /**
     * Check if the user can manage users (only primary admin).
     */
    public function canManageUsers(): bool
    {
        return $this->isAdmin();
    }

    /**
     * Check if the user is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Get the role display name.
     */
    public function getRoleDisplayNameAttribute(): string
    {
        return match($this->role) {
            'admin' => 'مدير رئيسي',
            'sub_admin' => 'مدير فرعي',
            'public_user' => 'مستخدم عام',
            default => 'غير محدد'
        };
    }

    /**
     * Get the status display name.
     */
    public function getStatusDisplayNameAttribute(): string
    {
        return match($this->status) {
            'active' => 'نشط',
            'inactive' => 'غير نشط',
            default => 'غير محدد'
        };
    }

    /**
     * Get the role badge class.
     */
    public function getRoleBadgeClassAttribute(): string
    {
        return match($this->role) {
            'admin' => 'bg-red-100 text-red-800',
            'sub_admin' => 'bg-blue-100 text-blue-800',
            'public_user' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    /**
     * Get the status badge class.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'active' => 'bg-green-100 text-green-800',
            'inactive' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    /**
     * Get the user's avatar URL.
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return Storage::url($this->avatar);
        }
        
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Get recent notifications for the user.
     */
    public function getRecentNotifications($limit = 5)
    {
        return $this->notifications()->latest()->take($limit)->get();
    }
}
