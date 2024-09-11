<?php

namespace App\Http\Controllers;

use App\Application\UseCases\CreateClientUseCase;
// use App\Application\UseCases\UpdateClientUseCase;
use Illuminate\Http\Request;
use App\Domain\Repositories\ClientRepositoryInterface;

class ClientController extends Controller
{
    private $createClientUseCase;
    private $clientRepository;

    public function __construct(CreateClientUseCase $createClientUseCase, ClientRepositoryInterface $clientRepository)
    {
        $this->createClientUseCase = $createClientUseCase;
        $this->clientRepository = $clientRepository;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'cpfCnpj' => 'required|cpf_or_cnpj'
        ]);

        $client = $this->createClientUseCase->execute($data);

        return response()->json($client, 201);
    }

    public function index()
    {
        $clients = $this->clientRepository->findAll();
        return response()->json($clients, 200);
    }

    public function show($id)
    {
        $client = $this->clientRepository->findById($id);

        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        return response()->json($client, 200);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'cpfCnpj' => 'required|cpf_or_cnpj'
        ]);

        $client = $this->clientRepository->findById($id);
        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        $client->name = $data['name'];
        $client->email = $data['email'];
        $client->phone = $data['phone'];
        $client->cpfCnpj = $data['cpfCnpj'];

        $updatedClient = $this->clientRepository->update($client);

        return response()->json($updatedClient, 200);
    }

    public function destroy($id)
    {
        $client = $this->clientRepository->findById($id);
        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        $this->clientRepository->delete($id);

        return response()->json(['message' => 'Client deleted'], 200);
    }
}

