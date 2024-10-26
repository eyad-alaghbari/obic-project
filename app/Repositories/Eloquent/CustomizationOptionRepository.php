<?php

namespace App\Repositories\Eloquent;

use App\Models\CustomizationOption;
use App\Repositories\Interfaces\CustomizationOptionRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CustomizationOptionRepository implements CustomizationOptionRepositoryInterface
{
    /**
     * Get all customization options with pagination.
     */
    public function all(int $perPage = 10): LengthAwarePaginator
    {
        return CustomizationOption::paginate($perPage);
    }

    /**
     * Find a customization option by its ID.
     */
    public function find(int $id): ?CustomizationOption
    {
        return CustomizationOption::find($id);
    }

    /**
     * Get a customization option by Customization ID.
     */
    public function getByCustomizationId(int $customizationId): Collection
    {
        return CustomizationOption::where('customization_id', $customizationId)->get();
    }

    /**
     * Create a new customization option.
     */
    public function create(array $data): CustomizationOption
    {
        return CustomizationOption::create($data);
    }

    /**
     * Update an existing customization option.
     */
    public function update(CustomizationOption $option, array $data): CustomizationOption
    {
        $option->update($data);
        return $option;
    }

    /**
     * Delete a customization option.
     */
    public function delete(CustomizationOption $option): void
    {
        $option->delete();
    }
}
