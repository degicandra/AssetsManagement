<?php

namespace App\Observers;

use App\Models\AssetRequest;
use App\Models\AssetRequestHistory;

class AssetRequestObserver
{
    /**
     * Handle the AssetRequest "created" event.
     */
    public function created(AssetRequest $assetRequest): void
    {
        // Create initial history record
        AssetRequestHistory::create([
            'asset_request_id' => $assetRequest->id,
            'previous_status' => null,
            'new_status' => $assetRequest->status,
            'notes' => 'Request created',
            'changed_at' => now(),
        ]);
    }

    /**
     * Handle the AssetRequest "updated" event.
     */
    public function updated(AssetRequest $assetRequest): void
    {
        // Record status changes
        if ($assetRequest->isDirty('status')) {
            $previousStatus = $assetRequest->getOriginal('status');
            
            AssetRequestHistory::create([
                'asset_request_id' => $assetRequest->id,
                'previous_status' => $previousStatus,
                'new_status' => $assetRequest->status,
                'changed_at' => now(),
            ]);
        }
    }

    /**
     * Handle the AssetRequest "deleted" event.
     */
    public function deleted(AssetRequest $assetRequest): void
    {
        //
    }

    /**
     * Handle the AssetRequest "restored" event.
     */
    public function restored(AssetRequest $assetRequest): void
    {
        //
    }

    /**
     * Handle the AssetRequest "force deleted" event.
     */
    public function forceDeleted(AssetRequest $assetRequest): void
    {
        //
    }
}
