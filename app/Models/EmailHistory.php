<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailHistory extends Model
{
    protected $fillable = [
        'email_id',
        'user_id',
        'action_type',
        'field_name',
        'old_value',
        'new_value',
        'description'
    ];

    public function email()
    {
        return $this->belongsTo(Email::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
