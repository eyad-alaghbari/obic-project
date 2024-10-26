<?php

namespace App\Repositories\Interfaces;

use App\Models\CustomizationOption;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface CustomizationOptionRepositoryInterface
{

    public function all(int $perPage = 10): LengthAwarePaginator;

    public function find(int $id): ?CustomizationOption;

    public function getByCustomizationId(int $customizationId): Collection;

    public function create(array $data): CustomizationOption;

    public function update(CustomizationOption $option, array $data): CustomizationOption;

    public function delete(CustomizationOption $option): void;


}
