<?php

namespace App\Libs;

use Stripe\Stripe;
use Stripe\Charge;

class StripeLib {

    public function __construct (string $token) {
        $this->setToken ($token);
    }

    private function setToken ($token) {
        Stripe::setApiKey($token);
    }

    public function charge (float $amount, array $data) {
        return Charge::create([
            "amount" => $amount * 100,
            "currency" => "usd",
            "source" => $data['id'], // obtained with Stripe.js
            //"description" => "Charge for jenny.rosen@example.com"
          ]);
    }
}