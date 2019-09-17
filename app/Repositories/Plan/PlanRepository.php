<?php

namespace App\Repositories\Plan;

use App\Repositories\Repository;

class PlanRepository extends Repository implements IPlanRepository {
    public function pluck () {
        return $this->model->pluck('name', 'id');
    }

    public function getActive () {
        return $this->model->select(['id', 'name', 'storage_quantity', 'storage_unit', 'benifits', 'amount'])->where('active', true)->get();
    }
}