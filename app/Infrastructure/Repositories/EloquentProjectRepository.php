<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Project;
use App\Models\Project as EloquentProject;
use App\Domain\Repositories\ProjectRepositoryInterface;

class EloquentProjectRepository implements ProjectRepositoryInterface
{
    public function create(Project $project): Project
    {
        $eloquentProject = new EloquentProject();
        $eloquentProject->client_id = $project->clientId;
        $eloquentProject->installation_location = $project->location;
        $eloquentProject->installation_type = $project->installationType;
        $eloquentProject->equipments = $project->equipments;
        $eloquentProject->save();

        $project->id = $eloquentProject->id;
        return $project;
    }

    public function update(Project $project): Project
    {
        $eloquentProject = EloquentProject::find($project->id);
        
        if (!$eloquentProject) {
            throw new \Exception('Project not found');
        }

        $eloquentProject->client_id = $project->clientId;
        $eloquentProject->installation_location = $project->location;
        $eloquentProject->installation_type = $project->installationType;
        $eloquentProject->equipments = $project->equipments;
        $eloquentProject->save();

        return $project;
    }

    public function findById($id): ?Project
    {
        $eloquentProject = EloquentProject::find($id);

        if (!$eloquentProject) {
            return null;
        }

        return new Project(
            $eloquentProject->id,
            $eloquentProject->client_id,
            $eloquentProject->installation_location,
            $eloquentProject->installation_type,
            $eloquentProject->equipments
        );
    }

    public function findAll(): array
    {
        $eloquentProjects = EloquentProject::all();
    
        return $eloquentProjects->map(function ($project) {
            return new Project(
                $project->id,
                $project->client_id,
                $project->installation_location,
                $project->installation_type,
                $project->equipments
            );
        })->toArray();
    }




    public function delete($id): bool
    {
        return EloquentProject::destroy($id) > 0;
    }
}
