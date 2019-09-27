<?php

namespace App\Services;
use App\Purchase;

use App\Repositories\Purchase\IPurchaseRepository as Repository;

class PurchaseService {

    private $repository;

    const PERCENTAGE = 100;

    public function __construct (Repository $repository) {
        $this->repository = $repository;
    }

    public function updateShare (Purchase $purchase) {
        $this->repository->updateAdminCommission ($purchase->id, $this->calculateCommission ($purchase->by_amount, $this->getPlanCommission ($purchase)));
    }

    private function calculateCommission (float $amount, float $commission):float {
        return $amount * ($commission/self::PERCENTAGE);
    }

    private function getPlanCommission (Purchase $purchase):float {
        $subscription = $purchase->shareImage()->first()->users()->first()->subscriptions()->latest()->first();
        return $subscription ? $subscription->plan()->first()->commission : 0;
    }
}