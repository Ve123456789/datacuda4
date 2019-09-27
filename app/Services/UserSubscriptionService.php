<?php

namespace App\Services;

use App\Repositories\UserSubscription\IUserSubscriptionRepository as Repository;

use App\Models\Plan;
use App\User;
use App\Models\UserSubscription;

class UserSubscriptionService {
    private $repository;

    const DAYS_IN_MONTHS = 30;
    const DAYS_IN_YEAR = 365;

    public function __construct (Repository $repository) {
        $this->repository = $repository;
    }

    public function create (User $user, Plan $plan) {
        if ($this->checkAdditional ($plan)) {
            $activePlan = $this->getLastActivePlan ($user);

            if ($activePlan && $this->checkPlanValid($activePlan)) {
                return $activePlan->update ([
                    'storage_quantity' => $activePlan->storage_quantity + $this->castMemoryInBytes ($plan),
                ]);
            }
        }

        return $this->repository->create ([
            'user_id' => $user->id, 
            'plan_id' => $plan->id,
            'storage_quantity' => $this->castMemoryInBytes ($plan),
            'amount' => $plan->amount,
            'expire_at' => $this->getExpiry ($plan)
        ]);
    }

    private function getExpiry (Plan $plan):?string {
        if (empty ($plan->vailidity_quantity)) {
            return null;
        }

        switch (strtoupper ($plan->validity_unit)) {
            case 'DAYS':
                return $this->calculateExpiry ($plan->vailidity_quantity);
            case 'MONTHS':
                return $this->calculateExpiry ($plan->vailidity_quantity * self::DAYS_IN_MONTHS);
            case 'YEARS':
                return $this->calculateExpiry ($plan->vailidity_quantity * self::DAYS_IN_YEAR);
            default:
                return null;
        }
    }

    private function calculateExpiry (int $days):string {
        return date ('Y-m-d', strtotime ("+ {$days} days"));
    }

    private function castMemoryInBytes (Plan $plan):int {
        return memoryConverterToBytes ($plan->storage_quantity, $plan->storage_unit);
    }

    private function checkPlanValid (UserSubscription $activePlan):bool {
        return $activePlan->expire_at ? strtotime ($activePlan->expire_at) > time() : true;
    }

    private function checkAdditional (Plan $plan):bool {
        return $plan->additional;
    }

    private function getLastActivePlan (User $user) {
        return $user->subscriptions()->where('status', true)->latest()->first();
    }
}