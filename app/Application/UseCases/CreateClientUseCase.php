<?php

namespace App\Application\UseCases;

use App\Domain\Entities\Client;
use App\Domain\Repositories\ClientRepositoryInterface;

class CreateClientUseCase
{
    private $clientRepository;

    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function execute(array $data): Client
    {
        $client = new Client(null, $data['name'], $data['email'], $data['phone'], $data['cpfCnpj']);
        return $this->clientRepository->create($client);
    }
}