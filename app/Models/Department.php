<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_active'
    ];

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    public function emails()
    {
        return $this->hasMany(Email::class);
    }
}
