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
        // Serializa os equipamentos para salvar no banco de dados
        $eloquentProject->equipments = json_encode($project->equipments);
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
        // Serializa os equipamentos para salvar no banco de dados
        $eloquentProject->equipments = json_encode($project->equipments);
        $eloquentProject->save();

        return $project;
    }

    public function findById($id): ?Project
    {
        $eloquentProject = EloquentProject::find($id);

        if (!$eloquentProject) {
            return null;
        }

        // Decodifica os equipamentos do JSON para um array
        $equipments = json_decode($eloquentProject->equipments, true);

        return new Project(
            $eloquentProject->id,
            $eloquentProject->client_id,
            $eloquentProject->installation_location,
            $eloquentProject->installation_type,
            $equipments
        );
    }

    public function findAll(): array
    {
        $eloquentProjects = EloquentProject::all();
    
        return $eloquentProjects->map(function ($project) {
            // Decodifica os equipamentos do JSON para um array
            $equipments = json_decode($project->equipments, true);

            return new Project(
                $project->id,
                $project->client_id,
                $project->installation_location,
                $project->installation_type,
                $equipments
            );
        })->toArray();
    }

    public function findWithFilters(array $filters, $equipment = null): array
    {
        $query = EloquentProject::query();

        // Aplica os filtros fornecidos
        foreach ($filters as $key => $value) {
            $query->where($key, $value);
        }

        // Se houver um equipamento fornecido, adiciona uma condição de busca nos equipamentos
        if ($equipment) {
            $query->where('equipments', 'like', '%' . $equipment . '%');
        }

        $eloquentProjects = $query->get();

        return $eloquentProjects->map(function ($project) {
            $equipments = json_decode($project->equipments, true);

            return new Project(
                $project->id,
                $project->client_id,
                $project->installation_location,
                $project->installation_type,
                $equipments
            );
        })->toArray();
    }

    public function delete($id): bool
    {
        return EloquentProject::destroy($id) > 0;
    }
}
