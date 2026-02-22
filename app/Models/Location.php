<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'name',
        'floor_id',
        'description',
        'is_active'
    ];

    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }
}
