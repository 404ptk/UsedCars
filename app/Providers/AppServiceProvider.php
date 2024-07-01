<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

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
        //Paginator::useBootstrap();
        //Gate::policy(Country::class, CountryPolicy::class);

        Gate::define('is-admin', function (User $user) {
            return $user->role_id == 1;
        });
        Paginator::useBootstrapFive();
    }
    protected $listen = [
        'App\Events\AuctionEnded' => [
            'App\Listeners\HandleAuctionEnd',
        ],
    ];
}
