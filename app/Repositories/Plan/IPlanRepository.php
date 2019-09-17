<?php

namespace App\Repositories\Plan;

use App\Repositories\IRepository;

interface IPlanRepository extends IRepository {
    public function pluck ();
    public function getActive ();
}