<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    protected $fillable = [
        'name',
        'floor_number',
        'description',
        'is_active'
    ];

    public function locations()
    {
        return $this->hasMany(Location::class);
    }
}
