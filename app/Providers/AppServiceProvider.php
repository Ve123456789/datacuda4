<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema; //Import Schema
use Laravel\Cashier\Cashier;

use App\Libs\StripeLib;

use App\Purchase;
use App\Observers\PurchaseObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
            Schema::defaultStringLength(191); //Solved by increasing StringLength
            Cashier::useCurrency('usd', '$');
            Purchase::observe(PurchaseObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {

        $this->app->singleton (StripeLib::class, function ($app) {
            return new StripeLib('sk_test_zh5dQ9OgeCGRYvK0fxnKLVs200KBZm7LzN');
        });
    }
}
