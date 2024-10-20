<?php

namespace App\Repositories\Eloquent;

use App\Models\Vendor;
use App\Repositories\Interfaces\VendorRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class VendorRepository implements VendorRepositoryInterface
{
    protected $model;

    public function __construct(Vendor $vendor)
    {
        $this->model = $vendor;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getAllWithPagination($per_page = 10): LengthAwarePaginator
    {
        return $this->model->paginate($per_page);
    }

    public function findByField($field, $value, $per_page = 10) : LengthAwarePaginator
    {

        return $this->model->where($field, $value)->paginate($per_page);
    }

    public function findById($id): Vendor
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data): Vendor
    {
        return $this->model->create($data);
    }

    public function update($id, array $data): Vendor
    {
        $vendor = $this->findById($id);
        $vendor->update($data);
        return $vendor;
    }

    public function delete($id): bool
    {
        $vendor = $this->findById($id);
        return $vendor->delete();
    }
}
