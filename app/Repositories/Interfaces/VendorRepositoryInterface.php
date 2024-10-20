<?php

namespace App\Repositories\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface VendorRepositoryInterface
{
    /**
     * Get all vendors
     * @return \Illuminate\Database\Eloquent\Collection|\App\Models\Vendor[]
     */
    public function getAll();

    /**
     * Get all vendors with pagination
     * @param int $per_page
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllWithPagination(int $per_page) : LengthAwarePaginator;

    /**
     * Get vendor by field
     * @param string $field
     * @param mixed $value
     * @param int $per_page
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function findByField(string $field, $value, int $per_page) : LengthAwarePaginator;

    /**
     * @param int $id
     * @return \App\Models\Vendor|null
     */
    public function findById(int $id) : ?\App\Models\Vendor;

    /**
     * Get vendor by id
     * @param array $data
     * @return \App\Models\Vendor
     */
    public function create(array $data) : \App\Models\Vendor;

    /**
     * Update vendor
     * @param int $id
     * @param array $data
     * @return \App\Models\Vendor
     */
    public function update(int $id, array $data) : \App\Models\Vendor;

    /**
     * Delete vendor
     * @param int $id
     * @return bool|null
     */
    public function delete(int $id) : ?bool;
}
