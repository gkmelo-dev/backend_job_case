<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Client;

class ClientRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_client()
    {
        $response = $this->postJson('/api/clients', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'cpfCnpj' => '12345678901'
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'name' => 'John Doe',
                     'email' => 'john@example.com'
                 ]);

        $this->assertDatabaseHas('clients', ['email' => 'john@example.com']);
    }

    public function test_can_list_clients()
    {
        Client::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'cpf_cnpj' => '12345678901'
        ]);

        $response = $this->getJson('/api/clients');

        $response->assertStatus(200)
                 ->assertJsonStructure([[
                     'id', 'name', 'email', 'phone', 'cpfCnpj'
                 ]]);
    }

    public function test_can_update_client()
    {
        $client = Client::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'cpf_cnpj' => '12345678901'
        ]);

        $response = $this->putJson("/api/clients/{$client->id}", [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '9876543210',
            'cpfCnpj' => '98765432101'
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'name' => 'Jane Doe',
                     'email' => 'jane@example.com'
                 ]);

        $this->assertDatabaseHas('clients', ['email' => 'jane@example.com']);
    }

    public function test_can_delete_client()
    {
        $client = Client::factory()->create();

        $response = $this->deleteJson("/api/clients/{$client->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Client deleted']);

        $this->assertDatabaseMissing('clients', ['id' => $client->id]);
    }
}
