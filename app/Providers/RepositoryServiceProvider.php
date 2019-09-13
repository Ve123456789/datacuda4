<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Plan\IPlanRepository;
use App\Repositories\Plan\PlanRepository;
use App\Models\Plan;

use App\Repositories\UserSubscription\IUserSubscriptionRepository;
use App\Repositories\UserSubscription\UserSubscriptionRepository;
use App\Models\UserSubscription;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(IPlanRepository::class, function ($app) {
            return new PlanRepository(new Plan);
        });

        $this->app->singleton(IUserSubscriptionRepository::class, function ($app) {
            return new UserSubscriptionRepository(new UserSubscription);
        });
    }
}
