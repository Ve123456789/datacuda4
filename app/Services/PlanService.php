<?php

namespace App\Services;

use App\Repositories\Plan\IPlanRepository as Repository;
use Illuminate\Http\Request;

class PlanService {

    private $repository;

    public function __construct (Repository $repository) {
        $this->repository = $repository;
    }

    public function paginate (Request $request) {
        return $this->repository->paginate($request->input('limit', env('PAGINATION_LIMIT', 10)));
    }

    public function create(Request $request) {
        return $this->repository->create($request->all());
    }

    public function get(Request $request) {
        return $this->repository->find((int) $request->route()->parameter('planId'));
    }

    public function update(Request $request) {
        return $this->repository->update ((int) $request->route()->parameter('planId'), $request->all());
    }

    public function pluck() {
        return $this->repository->pluck ();
    }

    public function getActive (Request $request) {
        return $this->repository->getActive ();
    }
}