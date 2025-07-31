<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SparePart extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'images',
        'approval_status',
        'created_by'
    ];

    protected $casts = [
        'images' => 'array',
    ];

    /**
     * Get the user who created this spare part.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope to get approved spare parts only.
     */
    public function scopeApproved($query)
    {
        return $query->where('approval_status', 'approved');
    }

    /**
     * Scope to get pending spare parts only.
     */
    public function scopePending($query)
    {
        return $query->where('approval_status', 'pending');
    }

    /**
     * Scope to get rejected spare parts only.
     */
    public function scopeRejected($query)
    {
        return $query->where('approval_status', 'rejected');
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
     * Get the approval status badge class.
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
     * Get the first image URL.
     */
    public function getFirstImageUrlAttribute()
    {
        if ($this->images && count($this->images) > 0) {
            return asset('storage/' . $this->images[0]);
        }
        return asset('images/default-spare-part.jpg');
    }

    /**
     * Get all image URLs.
     */
    public function getImageUrlsAttribute()
    {
        if ($this->images) {
            return collect($this->images)->map(function ($image) {
                return asset('storage/' . $image);
            });
        }
        return collect();
    }
}
