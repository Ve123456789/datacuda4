<?php

namespace App\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;

interface IRepository {
    public function paginate (int $limit):LengthAwarePaginator;
    public function create (array $fields);
    public function find (int $id);
    public function update (int $id, array $data);
}