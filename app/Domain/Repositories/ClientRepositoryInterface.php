<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Client;

interface ClientRepositoryInterface
{
    public function create(Client $client): Client;
    public function update(Client $client): Client;
    public function findById($id): ?Client;
    public function findAll(): array;
    public function delete($id): void;
}