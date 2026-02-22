<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetType extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_active'
    ];

    public function assets()
    {
        return $this->hasMany(Asset::class, 'type_id');
    }
}
