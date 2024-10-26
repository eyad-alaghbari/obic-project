<?php

namespace App\Services\V1;

use App\Models\CustomizationOption;
use App\Repositories\Interfaces\CustomizationOptionRepositoryInterface;
use Illuminate\Support\Collection;

class CustomizationOptionService
{
    protected $customizationOptionRepository;

    public function __construct(CustomizationOptionRepositoryInterface $repository)
    {
        $this->customizationOptionRepository = $repository;
    }

    /**
     * Get all customization options.
     * @param int $perPage
     */
    public function getAll(int $perPage = 10)
    {
        return $this->customizationOptionRepository->all($perPage);
    }

    /**
     * Get a customization option by ID.
     * @param int $id
     * @return CustomizationOption|null
     */
    public function getById(int $id): ?CustomizationOption
    {
        return $this->customizationOptionRepository->find($id);
    }

    /**
     * Get a customization option by Customization ID.
     * @param int $customizationId
     * @return Collection|null
     */
    public function getByCustomizationId(int $customizationId): Collection
    {
        return $this->customizationOptionRepository->getByCustomizationId($customizationId);
    }

    /**
     * Create a new customization option.
     * @param array $data
     * @return CustomizationOption
     */
    public function create(array $data): CustomizationOption
    {
        return $this->customizationOptionRepository->create($data);
    }

    /**
     * Update a customization option.
     * @param int $id
     * @param array $data
     * @return CustomizationOption
     * @throws \Exception
     */
    public function update(int $id, array $data): CustomizationOption
    {
        $option = $this->getById($id);
        if (!$option) {
            throw new \Exception('Customization option not found.');
        }
        return $this->customizationOptionRepository->update($option, $data);
    }

    /**
     * Delete a customization option.
     * @param int $id
     * @throws \Exception
     */
    public function delete(int $id): void
    {
        $option = $this->getById($id);
        if (!$option) {
            throw new \Exception('Customization option not found.');
        }
        $this->customizationOptionRepository->delete($option);
    }
}
