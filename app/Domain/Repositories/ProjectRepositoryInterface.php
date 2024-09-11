<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Project;

interface ProjectRepositoryInterface
{
    public function create(Project $project): Project;
    public function update(Project $project): Project;
    public function findById($id): ?Project;
    public function findAll(): array;
    public function delete($id): bool;
}
