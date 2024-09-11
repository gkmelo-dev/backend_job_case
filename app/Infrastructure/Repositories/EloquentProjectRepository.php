<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\ProjectRepositoryInterface;
use App\Models\Project;

class EloquentProjectRepository implements ProjectRepositoryInterface
{
    public function findAll()
    {
        return Project::all();
    }

    public function findById($id)
    {
        return Project::find($id);
    }

    public function create(array $data)
    {
        return Project::create([
            'client_id' => $data['client_id'],
            'installation_location' => $data['installation_location'],
            'installation_type' => $data['installation_type'],
            'equipments' => json_encode($data['equipments']) // Serializa os equipamentos para JSON
        ]);
    }

    public function update($project)
    {
        $project->save();
        return $project;
    }

    public function delete($id)
    {
        return Project::destroy($id);
    }
}
