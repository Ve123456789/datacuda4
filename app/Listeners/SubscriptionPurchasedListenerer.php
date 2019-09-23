<?php

namespace App\Listeners;

use App\Events\SubscriptionPurchased;
use App\Services\UserSubscriptionService;

class SubscriptionPurchasedListenerer
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(UserSubscriptionService $service) {
        $this->service = $service;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(SubscriptionPurchased $event) {
        $this->service->create ($event->user, $event->plan);
    }
}
