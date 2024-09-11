<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Project;
use App\Models\Client;

class ProjectRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_project()
    {
        $client = Client::factory()->create();

        $response = $this->postJson('/api/projects', [
            'client_id' => $client->id,
            'installation_location' => 'SP',
            'installation_type' => 'Laje',
            'equipments' => [
                ['name' => 'Módulo', 'quantity' => 5],
                ['name' => 'Inversor', 'quantity' => 2]
            ]
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Project created successfully!',
                'data' => [
                    'clientId' => $client->id,
                    'location' => 'SP',
                    'installationType' => 'Laje',
                    'equipments' => [
                        ['name' => 'Módulo', 'quantity' => 5],
                        ['name' => 'Inversor', 'quantity' => 2]
                    ]
                ]
            ]);

        $this->assertDatabaseHas('projects', ['client_id' => $client->id]);
    }

    public function test_can_list_projects()
    {
        $client = Client::factory()->create();
        Project::factory()->create([
            'client_id' => $client->id,
            'installation_location' => 'SP',
            'installation_type' => 'Laje',
            'equipments' => json_encode([
                ['name' => 'Módulo', 'quantity' => 5],
                ['name' => 'Inversor', 'quantity' => 2]
            ])
        ]);

        $response = $this->getJson('/api/projects');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'projects' => [
                    '*' => ['id', 'clientId', 'location', 'installationType', 'equipments']
                ]
            ]);
    }

    public function test_can_update_project()
    {
        $client = Client::factory()->create();
        $project = Project::factory()->create([
            'client_id' => $client->id,
            'installation_location' => 'SP',
            'installation_type' => 'Laje',
            'equipments' => json_encode([
                ['name' => 'Módulo', 'quantity' => 5],
                ['name' => 'Inversor', 'quantity' => 2]
            ])
        ]);

        $response = $this->putJson("/api/projects/{$project->id}", [
            'installation_location' => 'RJ',
            'installation_type' => 'Fibrocimento (Metálico)',
            'equipments' => [
                ['name' => 'Cabo vermelho', 'quantity' => 10],
                ['name' => 'Módulo', 'quantity' => 3]
            ]
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Project updated successfully!',
                'data' => [
                    'location' => 'RJ',
                    'installationType' => 'Fibrocimento (Metálico)',
                    'equipments' => [
                        ['name' => 'Cabo vermelho', 'quantity' => 10],
                        ['name' => 'Módulo', 'quantity' => 3]
                    ]
                ]
            ]);

        $this->assertDatabaseHas('projects', ['installation_location' => 'RJ']);
    }

    public function test_can_delete_project()
    {
        $project = Project::factory()->create();

        $response = $this->deleteJson("/api/projects/{$project->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Project deleted successfully!']);

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }
}
