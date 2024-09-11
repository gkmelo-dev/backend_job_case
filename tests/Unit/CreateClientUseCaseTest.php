<?php

namespace Tests\Unit;

use App\Application\UseCases\CreateClientUseCase;
use App\Domain\Entities\Client;
use App\Domain\Repositories\ClientRepositoryInterface;
use PHPUnit\Framework\TestCase;

class CreateClientUseCaseTest extends TestCase
{
    public function test_create_client_successfully()
    {
        // Mock the repository
        $repository = $this->createMock(ClientRepositoryInterface::class);
        
        // Define the expected client
        $repository->method('create')
                   ->willReturn(new Client(1, 'John Doe', 'john@example.com', '1234567890', '12345678901'));

        // Instantiate the use case with the mock repository
        $useCase = new CreateClientUseCase($repository);

        // Call the use case and assert that it returns the correct client
        $client = $useCase->execute([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'cpfCnpj' => '12345678901'
        ]);

        // Assert the client data is as expected
        $this->assertEquals('John Doe', $client->name);
        $this->assertEquals('john@example.com', $client->email);
    }
}

// TODO add delete unit test