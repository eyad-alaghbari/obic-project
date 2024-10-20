<?php

namespace App\Services\V1;

use Illuminate\Support\Facades\Storage;
use App\Repositories\Interfaces\VendorRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class VendorService
{
    protected $vendorRepository;

    public function __construct(VendorRepositoryInterface $vendorRepository)
    {
        $this->vendorRepository = $vendorRepository;
    }

    /**
     * Get all vendors
     * @return \Illuminate\Database\Eloquent\Collection|\App\Models\Vendor[]
     */
    public function getAllVendors()
    {
        return $this->vendorRepository->getAll();
    }

    /**
     * Get all vendors with pagination
     * @param int $per_page
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllVendorsWithPagination($per_page = 10) : LengthAwarePaginator
    {
        return $this->vendorRepository->getAllWithPagination($per_page);
    }

    /**
     * Get vendor by field
     * @param string $field
     * @param mixed $value
     * @param int $per_page
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getVendorByField($field, $value, $per_page = 10) : LengthAwarePaginator
    {
        return $this->vendorRepository->findByField($field, $value, $per_page);
    }

    /**
     * Get vendor by id
     * @param int $id
     * @return \App\Models\Vendor|null
     */
    public function getVendorById($id): ?\App\Models\Vendor
    {
        return $this->vendorRepository->findById($id);
    }

    /**
     * @param array $data
     * @return \App\Models\Vendor
     */
    public function createVendor(array $data): \App\Models\Vendor
    {
        if (isset($data['logo'])) {
            $data['logo'] = $this->storeImage($data['logo']);
        }
        return $this->vendorRepository->create($data);
    }

    /**
     * Update vendor
     * @param int $id
     * @param array $data
     * @return \App\Models\Vendor
     */
    public function updateVendor($id, array $data): \App\Models\Vendor
    {
        if (isset($data['logo'])) {
            $data['logo'] = $this->storeImage($data['logo']);
        }
        return $this->vendorRepository->update($id, $data);
    }

    /**
     * Delete vendor
     * @param int $id
     * @return bool|null
     */
    public function deleteVendor($id): ?bool
    {
        $vendor = $this->vendorRepository->findById($id);
        if ($vendor->logo) {
            Storage::delete($vendor->logo);
        }
        return $this->vendorRepository->delete($id);
    }

    /**
     * Store image and return path
     * @param \Illuminate\Http\UploadedFile $image
     * @return string
     */
    private function storeImage($image): string
    {
        $imageName = time() . '.' . $image->getClientOriginalExtension();

        $path = $image->storeAs('uploads/vendors', $imageName, 'public');

        return $path;
    }

}
