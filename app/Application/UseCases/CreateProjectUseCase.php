<?php

namespace App\Application\UseCases;

use App\Domain\Entities\Project;
use App\Domain\Repositories\ProjectRepositoryInterface;

class CreateProjectUseCase
{
    private $projectRepository;

    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function execute(array $data): Project
    {
        $project = new Project(
            null,
            $data['client_id'],
            $data['installation_location'],
            $data['installation_type'],
            $data['equipments']
        );
        return $this->projectRepository->create($project);
    }
}
