<?php

namespace App\Repositories\Purchase;
use App\Repositories\IRepository;

interface IPurchaseRepository extends IRepository {
    public function updateAdminCommission (int $id, float $commission_amount):bool;
}