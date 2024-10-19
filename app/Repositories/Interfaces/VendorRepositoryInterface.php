<?php

namespace App\Repositories\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface VendorRepositoryInterface
{
    public function getAll();
    public function getAllWithPagination($per_page) : LengthAwarePaginator;
    public function findByField($field, $value, $per_page ) : LengthAwarePaginator;
    public function findById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
