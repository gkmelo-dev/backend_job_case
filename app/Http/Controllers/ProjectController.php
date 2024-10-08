<?php

namespace App\Http\Controllers;

use App\Application\UseCases\CreateProjectUseCase;
use App\Utils\Utils;
use Illuminate\Http\Request;
use App\Domain\Repositories\ProjectRepositoryInterface;

/**
 * @OA\Tag(name="Projects")
 */
class ProjectController extends Controller
{
    private $createProjectUseCase;
    private $projectRepository;

    public function __construct(
        CreateProjectUseCase $createProjectUseCase,
        ProjectRepositoryInterface $projectRepository
    ) {
        $this->createProjectUseCase = $createProjectUseCase;
        $this->projectRepository = $projectRepository;
    }

    /**
     * @OA\Post(
     *     path="/api/projects",
     *     summary="Create a new project",
     *     tags={"Projects"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="client_id", type="integer", example=1),
     *             @OA\Property(property="installation_location", type="string", example="SP"),
     *             @OA\Property(property="installation_type", type="string", example="Laje"),
     *             @OA\Property(property="equipments", type="array", 
     *                 @OA\Items(
     *                     @OA\Property(property="name", type="string", example="Módulo"),
     *                     @OA\Property(property="quantity", type="integer", example=10)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Project created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Project created successfully!"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'installation_location' => ['required', 'in:' . implode(',', Utils::getValidUFs())],
            'installation_type' => ['required', 'in:' . implode(',', Utils::getValidInstallationTypes())],
            'equipments' => ['required', 'array'],
            'equipments.*.name' => ['required', 'in:' . implode(',', Utils::getValidEquipments())],
            'equipments.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        $project = $this->createProjectUseCase->execute($data);

        return response()->json([
            'message' => 'Project created successfully!',
            'data' => $project
        ], 201);
    }

        /**
     * @OA\Get(
     *     path="/api/projects",
     *     summary="List all projects with optional filters",
     *     tags={"Projects"},
     *     @OA\Parameter(
     *         name="client_id",
     *         in="query",
     *         description="Filter by client ID",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="installation_location",
     *         in="query",
     *         description="Filter by installation location (UF)",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="installation_type",
     *         in="query",
     *         description="Filter by installation type",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of projects",
     *         @OA\JsonContent(
     *             @OA\Property(property="projects", type="array", @OA\Items(type="object"))
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        // Filtros opcionais
        $filters = [
            'client_id' => $request->input('client_id'),
            'installation_location' => $request->input('installation_location'),
            'installation_type' => $request->input('installation_type'),
        ];

        // Filtrar apenas pelos campos que estão presentes
        $projects = $this->projectRepository->findWithFilters(array_filter($filters), $request->input('equipments'));

        return response()->json(['projects' => $projects], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/projects/{id}",
     *     summary="Get a specific project",
     *     tags={"Projects"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the project",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Project details",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(response=404, description="Project not found")
     * )
     */
    public function show($id)
    {
        $project = $this->projectRepository->findById($id);

        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        return response()->json($project, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/projects/{id}",
     *     summary="Update a project",
     *     tags={"Projects"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the project to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="installation_location", type="string", example="SP"),
     *             @OA\Property(property="installation_type", type="string", example="Laje"),
     *             @OA\Property(property="equipments", type="array", 
     *                 @OA\Items(
     *                     @OA\Property(property="name", type="string", example="Módulo"),
     *                     @OA\Property(property="quantity", type="integer", example=10)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Project updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Project updated successfully!"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Project not found")
     * )
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'installation_location' => ['required', 'in:' . implode(',', Utils::getValidUFs())],
            'installation_type' => ['required', 'in:' . implode(',', Utils::getValidInstallationTypes())],
            'equipments' => ['required', 'array'],
            'equipments.*.name' => ['required', 'in:' . implode(',', Utils::getValidEquipments())],
            'equipments.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        $project = $this->projectRepository->findById($id);
        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        $project->location = $data['installation_location'];
        $project->installationType = $data['installation_type'];
        $project->equipments = $data['equipments'];

        $updatedProject = $this->projectRepository->update($project);

        return response()->json([
            'message' => 'Project updated successfully!',
            'data' => $updatedProject
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/projects/{id}",
     *     summary="Delete a project",
     *     tags={"Projects"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the project to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Project deleted successfully!",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Project deleted successfully!")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Project not found")
     * )
     */
    public function destroy($id)
    {
        $project = $this->projectRepository->findById($id);
        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        $this->projectRepository->delete($id);

        return response()->json(['message' => 'Project deleted successfully!'], 200);
    }
}
