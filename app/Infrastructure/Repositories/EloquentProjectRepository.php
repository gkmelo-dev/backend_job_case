<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\ProjectRepositoryInterface;
use App\Models\Project as EloquentProject;
use Illuminate\Database\Eloquent\Collection;

class EloquentProjectRepository implements ProjectRepositoryInterface
{
    public function findAll(): Collection
    {
        return EloquentProject::all();
    }

    public function findById($id): ?EloquentProject
    {
        return EloquentProject::find($id);
    }

    public function create(array $data): EloquentProject
    {
        return EloquentProject::create([
            'client_id' => $data['client_id'],
            'installation_location' => $data['installation_location'],
            'installation_type' => $data['installation_type'],
            'equipments' => $data['equipments'] // O Laravel faz o cast para JSON
        ]);
    }

    public function update(EloquentProject $project): EloquentProject
    {
        $project->save();
        return $project;
    }

    public function delete($id): bool
    {
        return EloquentProject::destroy($id) > 0;
    }
}
