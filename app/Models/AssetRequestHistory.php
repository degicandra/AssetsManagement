<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetRequestHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_request_id',
        'previous_status',
        'new_status',
        'notes',
        'changed_at',
    ];

    protected $casts = [
        'changed_at' => 'datetime',
    ];

    /**
     * Get the asset request that owns this history record.
     */
    public function assetRequest()
    {
        return $this->belongsTo(AssetRequest::class);
    }

    /**
     * Get display name for status
     */
    public function getNewStatusDisplayAttribute()
    {
        $statuses = [
            'request_created' => 'Request Created',
            'finance_approval' => 'Finance Approval',
            'director_approval' => 'Director Approval',
            'submitted_purchasing' => 'Submitted to Purchasing',
            'item_purchased' => 'Item Purchased'
        ];

        return $statuses[$this->new_status] ?? $this->new_status;
    }

    /**
     * Get display name for previous status
     */
    public function getPreviousStatusDisplayAttribute()
    {
        if (!$this->previous_status) {
            return 'Initial';
        }

        $statuses = [
            'request_created' => 'Request Created',
            'finance_approval' => 'Finance Approval',
            'director_approval' => 'Director Approval',
            'submitted_purchasing' => 'Submitted to Purchasing',
            'item_purchased' => 'Item Purchased'
        ];

        return $statuses[$this->previous_status] ?? $this->previous_status;
    }

    /**
     * Get badge color based on status
     */
    public function getStatusBadgeClassAttribute()
    {
        $colors = [
            'request_created' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-200',
            'finance_approval' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200',
            'director_approval' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-200',
            'submitted_purchasing' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-200',
            'item_purchased' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200'
        ];

        return $colors[$this->new_status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-200';
    }
}
