<?php

namespace App\Http\Controllers;

use App\Application\UseCases\CreateClientUseCase;
use App\Rules\CpfOrCnpj;
use Illuminate\Http\Request;
use App\Domain\Repositories\ClientRepositoryInterface;
use OpenApi\Annotations as OA;

class ClientController extends Controller
{
    private $createClientUseCase;
    private $clientRepository;

    public function __construct(CreateClientUseCase $createClientUseCase, ClientRepositoryInterface $clientRepository)
    {
        $this->createClientUseCase = $createClientUseCase;
        $this->clientRepository = $clientRepository;
    }

    /**
     * @OA\Post(
     *     path="/api/clients",
     *     summary="Create a new client",
     *     tags={"Clients"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "phone", "cpfCnpj"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="john@example.com"),
     *             @OA\Property(property="phone", type="string", example="1234567890"),
     *             @OA\Property(property="cpfCnpj", type="string", example="12345678909")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Client created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Client created successfully!"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Validation failed"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'phone' => 'required|string|max:20',
            'cpfCnpj' => ['required', new CpfOrCnpj]
        ]);

        $client = $this->createClientUseCase->execute($data);

        return response()->json([
            'message' => 'Client created successfully!',
            'data' => $client
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/clients",
     *     summary="Get all clients",
     *     tags={"Clients"},
     *     @OA\Response(
     *         response=200,
     *         description="List of clients",
     *         @OA\JsonContent(
     *             @OA\Property(property="clients", type="array", @OA\Items(type="object"))
     *         )
     *     )
     * )
     */
    public function index()
    {
        $clients = $this->clientRepository->findAll();
        return response()->json(['clients'=> $clients],200);
    }

    /**
     * @OA\Get(
     *     path="/api/clients/{id}",
     *     summary="Get a specific client",
     *     tags={"Clients"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Client details",
     *         @OA\JsonContent(type="object")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Client not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Client not found")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $client = $this->clientRepository->findById($id);

        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        return response()->json($client, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/clients/{id}",
     *     summary="Update a client",
     *     tags={"Clients"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "phone", "cpfCnpj"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="john@example.com"),
     *             @OA\Property(property="phone", type="string", example="1234567890"),
     *             @OA\Property(property="cpfCnpj", type="string", example="12345678909")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Client updated successfully",
     *         @OA\JsonContent(type="object")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Client not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Client not found")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $id,
            'phone' => 'required|string|max:20',
            'cpfCnpj' => ['required', new CpfOrCnpj]
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

        return response()->json([
            'message' => 'Client updated successfully!',
            'data' => $updatedClient
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/clients/{id}",
     *     summary="Delete a client",
     *     tags={"Clients"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Client deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Client deleted successfully!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Client not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Client not found")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        $client = $this->clientRepository->findById($id);
        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        $this->clientRepository->delete($id);

        return response()->json(['message' => 'Client deleted successfully!'], 200);
    }
}
