<?php

namespace App\Observers;

use App\Models\License;
use Carbon\Carbon;

class LicenseObserver
{
    /**
     * Handle the License "retrieved" event.
     */
    public function retrieved(License $license): void
    {
        $this->updateStatusBasedOnExpiry($license);
    }

    /**
     * Handle the License "created" event.
     */
    public function created(License $license): void
    {
        $this->updateStatusBasedOnExpiry($license);
    }

    /**
     * Handle the License "updated" event.
     */
    public function updated(License $license): void
    {
        $this->updateStatusBasedOnExpiry($license);
    }

    /**
     * Update license status based on expiry date.
     */
    private function updateStatusBasedOnExpiry(License $license): void
    {
        if (!$license->expiry_date) {
            return;
        }

        $today = Carbon::today();
        $expiryDate = Carbon::parse($license->expiry_date);
        $oneMonthFromNow = Carbon::today()->addMonth();

        // If already expired, set to inactive
        if ($expiryDate->isPast() && $license->status !== 'inactive') {
            $license->status = 'inactive';
            $license->saveQuietly();
        }
        // If expires within 1 month, set to expired_soon (but not if it's already inactive)
        elseif ($expiryDate->isBetween($today, $oneMonthFromNow) && $license->status !== 'expired_soon' && $license->status !== 'inactive') {
            $license->status = 'expired_soon';
            $license->saveQuietly();
        }
        // If more than 1 month away and currently expired_soon, set back to active
        elseif ($expiryDate->isAfter($oneMonthFromNow) && $license->status === 'expired_soon') {
            $license->status = 'active';
            $license->saveQuietly();
        }
    }
}
