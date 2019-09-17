<?php

namespace App\Observers;

use App\Purchase;
use App\Events\ResourcePurchased;

class PurchaseObserver
{
    /**
     * Handle the purchase "created" event.
     *
     * @param  \App\Purchase  $purchase
     * @return void
     */
    public function created(Purchase $purchase)
    {
        event (new ResourcePurchased ($purchase));
    }
}
