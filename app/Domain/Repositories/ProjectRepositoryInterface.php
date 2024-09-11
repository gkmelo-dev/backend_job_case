<?php

namespace App\Domain\Repositories;

use App\Models\Project;

interface ProjectRepositoryInterface
{
    public function findAll(): \Illuminate\Database\Eloquent\Collection;

    public function findById($id): ?Project;

    public function create(array $data): Project;

    public function update(Project $project): Project;

    public function delete($id): bool;
}
