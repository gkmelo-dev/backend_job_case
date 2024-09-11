<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Project;

interface ProjectRepositoryInterface
{
    public function create(Project $project): Project;
    public function update(Project $project): Project;
    public function findById($id): ?Project;
    public function findAll(): array;
    /**
    * Finds projects with optional filters.
    *
    * @param array $filters Associative array of filters like 'client_id', 'installation_location', etc.
    * @param string|null $equipment Optional equipment name to filter by.
    * @return array List of filtered projects.
    */
    public function findWithFilters(array $filters, ?string $equipment = null): array;

    public function delete($id): bool;
}
