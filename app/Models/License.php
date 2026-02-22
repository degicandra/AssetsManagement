<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    use HasFactory;

    protected $fillable = [
        'software_name',
        'license_key',
        'asset_id',
        'purchase_date',
        'expiry_date',
        'status',
        'quantity',
        'department_id',
        'notes',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'expiry_date' => 'date',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function licenseHistories()
    {
        return $this->hasMany(LicenseHistory::class)->orderBy('created_at', 'desc');
    }

    public function getDaysUntilExpiryAttribute()
    {
        if ($this->expiry_date) {
            return (int) now()->diffInDays($this->expiry_date, false);
        }
        return null;
    }

    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'active' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200',
            'inactive' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-200',
            'expired_soon' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200',
            default => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200',
        };
    }
}