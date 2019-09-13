<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Plan\IPlanRepository;
use App\Repositories\Plan\PlanRepository;
use App\Models\Plan;

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
    }
}
