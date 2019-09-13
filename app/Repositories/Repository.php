<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class Repository implements IRepository {

    protected $model;

    public function __construct (Model $model) {
        $this->model = $model;
    }

    public function paginate (int $limit):LengthAwarePaginator {
        return $this->model->paginate ($limit);
    }

    public function create (array $fields) {
        return $this->model->create ($fields);
    }

    public function find (int $id) {
        return $this->model->findOrFail ($id);
    }

    public function update (int $id, array $data) {
        return $this->find($id)->update ($data);
    }
}