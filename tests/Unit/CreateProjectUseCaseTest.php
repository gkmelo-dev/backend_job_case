<?php

namespace Tests\Unit;

use App\Application\UseCases\CreateProjectUseCase;
use App\Domain\Entities\Project;
use App\Domain\Repositories\ProjectRepositoryInterface;
use PHPUnit\Framework\TestCase;

class CreateProjectUseCaseTest extends TestCase
{
    public function test_create_project_successfully()
    {
        // Mock the repository
        $repository = $this->createMock(ProjectRepositoryInterface::class);

        // Define the expected project
        $repository->method('create')
                   ->willReturn(new Project(1, 1, 'SP', 'Laje', [
                       ['name' => 'Módulo', 'quantity' => 10],
                       ['name' => 'Inversor', 'quantity' => 2]
                   ]));

        // Instantiate the use case with the mock repository
        $useCase = new CreateProjectUseCase($repository);

        // Call the use case and assert that it returns the correct project
        $project = $useCase->execute([
            'client_id' => 1,
            'installation_location' => 'SP',
            'installation_type' => 'Laje',
            'equipments' => [
                ['name' => 'Módulo', 'quantity' => 10],
                ['name' => 'Inversor', 'quantity' => 2]
            ]
        ]);

        // Assert the project data is as expected
        $this->assertEquals(1, $project->clientId);
        $this->assertEquals('SP', $project->location);
        $this->assertEquals('Laje', $project->installationType);
        $this->assertCount(2, $project->equipments);
        $this->assertEquals('Módulo', $project->equipments[0]['name']);
    }
}
