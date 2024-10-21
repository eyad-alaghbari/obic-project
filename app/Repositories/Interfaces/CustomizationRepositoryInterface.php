<?php

namespace App\Repositories\Interfaces;

interface CustomizationRepositoryInterface
{


    public function getAll();

    public function getById(int $id);

    public function search(string $keyword);

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);


}
