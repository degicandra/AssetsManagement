<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $fillable = [
        'email',
        'name',
        'position',
        'department_id',
        'status',
        'description',
        'is_active'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function histories()
    {
        return $this->hasMany(EmailHistory::class);
    }
}
