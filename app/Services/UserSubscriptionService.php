<?php

namespace App\Services;

use App\Repositories\UserSubscription\IUserSubscriptionRepository as Repository;

use App\Models\Plan;
use App\User;

class UserSubscriptionService {
    private $repository;

    public function __construct (Repository $repository) {
        $this->repository = $repository;
    }

    public function create (User $user, Plan $plan) {
        return $this->repository->create (['user_id' => $user->id, 'plan_id' => $plan->id]);
    }
}