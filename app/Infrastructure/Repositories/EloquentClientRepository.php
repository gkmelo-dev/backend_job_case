<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Client;
use App\Domain\Repositories\ClientRepositoryInterface;
use App\Models\Client as EloquentClient;

class EloquentClientRepository implements ClientRepositoryInterface
{
    public function create(Client $client): Client
    {
        $eloquentClient = new EloquentClient();
        $eloquentClient->name = $client->name;
        $eloquentClient->email = $client->email;
        $eloquentClient->phone = $client->phone;
        $eloquentClient->cpf_cnpj = $client->cpfCnpj;
        $eloquentClient->save();

        $client->id = $eloquentClient->id;
        return $client;
    }

    public function update(Client $client): Client
    {
        $eloquentClient = EloquentClient::find($client->id);
        
        if (!$eloquentClient) {
            throw new \Exception('Client not found');
        }

        $eloquentClient->name = $client->name;
        $eloquentClient->email = $client->email;
        $eloquentClient->phone = $client->phone;
        $eloquentClient->cpf_cnpj = $client->cpfCnpj;
        $eloquentClient->save();

        return $client;
    }

    public function findById($id): ?Client
    {
        $eloquentClient = EloquentClient::find($id);

        if (!$eloquentClient) {
            return null;
        }

        return new Client(
            $eloquentClient->id,
            $eloquentClient->name,
            $eloquentClient->email,
            $eloquentClient->phone,
            $eloquentClient->cpf_cnpj
        );
    }

    public function delete($id): void
    {
        $eloquentClient = EloquentClient::find($id);
        
        if ($eloquentClient) {
            $eloquentClient->delete();
        }
    }

    public function findAll(): array
    {
        $eloquentClients = EloquentClient::all();

        return $eloquentClients->map(function ($eloquentClient) {
            return new Client(
                $eloquentClient->id,
                $eloquentClient->name,
                $eloquentClient->email,
                $eloquentClient->phone,
                $eloquentClient->cpf_cnpj
            );
        })->toArray();
    }
}
