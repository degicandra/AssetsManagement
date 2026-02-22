<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\License;
use App\Observers\LicenseObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        License::observe(LicenseObserver::class);
    }
}
