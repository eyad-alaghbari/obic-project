<?php

namespace App\Services\V1;

use App\Models\Customization;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\CustomizationRepositoryInterface;

class CustomizationService
{
    protected $customizationRepository;

    /**
     * Create a new class instance.
     */
    public function __construct(CustomizationRepositoryInterface $customizationRepository)
    {
        $this->customizationRepository = $customizationRepository;
    }


    /**
     * Get all customizations.
     *
     * @param int $perPage
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllCustomizations(): Collection
    {
        return $this->customizationRepository->getAll();
    }


    /**
     * Get customization by id.
     *
     * @param int $id
     * @return \App\Models\Customization
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getCustomizationById(int $id): Customization
    {
        return $this->customizationRepository->getById($id);
    }


    /**
     * Get customization by search keyword.
     *
     * @param string $keyword
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchCustomizations(string $keyword): Collection
    {
        // dd($keyword);
        return $this->customizationRepository->search($keyword);
    }

    /**
     * Create new customization.
     *
     * @param array $data
     * @return \App\Models\Customization
     */
    public function createCustomization(array $data): Customization
    {
        return $this->customizationRepository->create($data);
    }


    /**
     * Update customization.
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\Customization
     */
    public function updateCustomization(int $id, array $data): Customization
    {
        return $this->customizationRepository->update($id, $data);
    }


    /**
     * Remove the specified customization from storage.
     *
     * @param int $id
     * @return bool
     */
    public function deleteCustomization(int $id): bool
    {
        return $this->customizationRepository->delete($id);
    }



}
