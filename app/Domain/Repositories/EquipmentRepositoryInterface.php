<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Equipment;

interface EquipmentRepositoryInterface
{
    public function create(Equipment $equipment): Equipment;
    public function update(Equipment $equipment): Equipment;
    public function findById($id): ?Equipment;
    public function findAll(): array; // Add findAll method to return all clients

    public function delete($id): void;
}
