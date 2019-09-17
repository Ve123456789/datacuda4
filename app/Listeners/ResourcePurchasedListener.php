<?php

namespace App\Listeners;

use App\Events\ResourcePurchased;
use App\Services\PurchaseService;

class ResourcePurchasedListener
{
    private $service;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(PurchaseService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ResourcePurchased $event)
    {
        $this->service->updateShare ($event->purchase);
    }
}
