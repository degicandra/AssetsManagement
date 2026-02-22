<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = [
        'company',
        'asset_code',
        'serial_number',
        'model',
        'brand',
        'type_id',
        'status',
        'location_id',
        'department_id',
        'person_in_charge',
        'purchase_date',
        'warranty_expiration',
        'processor',
        'storage_type',
        'storage_size',
        'ram',
        'specification_upgraded',
        'image_path',
        'notes',
        'is_active'
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'warranty_expiration' => 'date'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function type()
    {
        return $this->belongsTo(AssetType::class, 'type_id');
    }

    public function histories()
    {
        return $this->hasMany(AssetHistory::class)->latest();
    }

    public function licenses()
    {
        return $this->hasMany(License::class);
    }

    public function locationWithFloor()
    {
        return $this->location()->with('floor');
    }
}
