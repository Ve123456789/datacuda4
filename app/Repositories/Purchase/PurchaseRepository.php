<?php

namespace App\Repositories\Purchase;
use App\Repositories\Repository;

class PurchaseRepository extends Repository implements IPurchaseRepository {

    public function updateAdminCommission (int $id, float $commission_amount):bool {
        return $this->update ($id, ['admin_amount' => $commission_amount]);
    }
}