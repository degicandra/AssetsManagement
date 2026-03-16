<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'item_description',
        'department_id',
        'floor_id',
        'location_id',
        'requested_by',
        'request_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'request_date' => 'date',
    ];

    /**
     * Get the department that owns the asset request.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the floor associated with the asset request.
     */
    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    /**
     * Get the location associated with the asset request.
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get the history records for this asset request.
     */
    public function histories()
    {
        return $this->hasMany(AssetRequestHistory::class)->orderBy('changed_at', 'desc');
    }

    /**
     * Get the status display name
     */
    public function getStatusDisplayAttribute()
    {
        $statuses = [
            'request_created' => 'Request Created',
            'finance_approval' => 'Finance Approval',
            'director_approval' => 'Director Approval',
            'submitted_purchasing' => 'Submitted to Purchasing',
            'item_purchased' => 'Item Purchased'
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    /**
     * Determine if the request is completed
     */
    public function isCompleted()
    {
        return $this->status === 'item_purchased';
    }
}
