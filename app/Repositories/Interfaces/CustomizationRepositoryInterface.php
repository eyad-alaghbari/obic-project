<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface CustomizationRepositoryInterface
{


    public function getAll();

    public function getById(int $id);

    public function search(string $keyword): Collection;

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);


}
