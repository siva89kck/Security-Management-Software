<?php

namespace App\Providers;
use App\Models\UniformIssueItem;
use App\Models\UniformPurchaseItem;
use App\Observers\UniformIssueItemObserver;
use App\Observers\UniformPurchaseItemObserver;
use Illuminate\Support\ServiceProvider;

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
        //

    }
}
