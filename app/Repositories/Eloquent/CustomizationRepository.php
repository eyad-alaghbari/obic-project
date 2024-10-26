<?php

namespace App\Repositories\Eloquent;

use App\Models\Customization;
use App\Repositories\Interfaces\CustomizationRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CustomizationRepository implements CustomizationRepositoryInterface
{
    /**
     * Get all customizations.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\App\Models\Customization[]
     */
    public function getAll(): Collection
    {
        return Customization::all();
    }

    /**
     * Get customization by id.
     *
     * @param int $id
     * @return \App\Models\Customization
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getById(int $id): Customization
    {
        return Customization::with('options')->findOrFail($id);
    }



    /**
     * Get customization by search keyword.
     *
     * @param string $keyword
     * @return \Illuminate\Database\Eloquent\Collection|\App\Models\Customization[]
     */
    public function search(string $keyword): Collection
    {
        return Customization::where('name', 'like', '%' . $keyword . '%')->get();
    }

    /**
     * Create new customization.
     *
     * @param array $data
     * @return \App\Models\Customization
     */
    public function create(array $data): Customization
    {
        return Customization::create($data);
    }

    /**
     * Update customization.
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\Customization
     */
    public function update(int $id, array $data): Customization
    {
        $customization = $this->getById($id);
        $customization->update($data);
        return $customization;
    }

    /**
     * Delete customization.
     *
     * @param int $id
     * @return bool|null
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function delete(int $id): ?bool
    {
        $customization = $this->getById($id);
        return $customization->delete();
    }



}
