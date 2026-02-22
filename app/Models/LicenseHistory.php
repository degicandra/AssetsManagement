<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicenseHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'license_id',
        'user_id',
        'action',
        'field_name',
        'old_value',
        'new_value',
        'notes',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function license()
    {
        return $this->belongsTo(License::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getActionIconAttribute()
    {
        return match($this->action) {
            'created' => '➕',
            'updated' => '✏️',
            'deleted' => '🗑️',
            'status_changed' => '🔄',
            default => '📝',
        };
    }

    public function getActionColorAttribute()
    {
        return match($this->action) {
            'created' => 'text-green-600',
            'updated' => 'text-blue-600',
            'deleted' => 'text-red-600',
            'status_changed' => 'text-yellow-600',
            default => 'text-gray-600',
        };
    }
}