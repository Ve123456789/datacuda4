<?php

namespace App\Events;

use App\Models\Plan;
use App\User;

class SubscriptionPurchased
{
    public $plan;
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Plan $plan, User $user) {
        $this->plan = $plan;
        $this->user = $user;
    }
}
