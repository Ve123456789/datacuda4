<?php

namespace App\Events;
use App\Purchase;

class ResourcePurchased
{
    public $purchase;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Purchase $purchase)
    {
        $this->purchase = $purchase;
    }
}
