<?php

namespace App\Http\Controllers;

use App\Application\UseCases\CreateProjectUseCase;
use App\Application\UseCases\UpdateProjectUseCase;
use App\Utils\Utils;
use Illuminate\Http\Request;
use App\Domain\Repositories\ProjectRepositoryInterface;

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

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'installation_location' => ['required', 'in:' . implode(',', Utils::getValidUFs())],
            'installation_type' => ['required', 'in:' . implode(',', Utils::getValidInstallationTypes())],
            'equipments' => ['required', 'array'],
            'equipments.*' => ['in:' . implode(',', Utils::getValidEquipments())], // Valida cada equipamento
        ]);

        $project = $this->createProjectUseCase->execute($data);

        return response()->json([
            'message' => 'Project created successfully!',
            'data' => $project
        ], 201);
    }

    public function index()
    {
        $projects = $this->projectRepository->findAll();
        return response()->json(['projects' => $projects], 200);
    }

    public function show($id)
    {
        $project = $this->projectRepository->findById($id);

        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        return response()->json($project, 200);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'installation_location' => ['required', 'in:' . implode(',', Utils::getValidUFs())],
            'installation_type' => ['required', 'in:' . implode(',', Utils::getValidInstallationTypes())],
            'equipments' => ['required', 'array'],
            'equipments.*' => ['in:' . implode(',', Utils::getValidEquipments())], // Valida cada equipamento
        ]);

        $project = $this->projectRepository->findById($id);
        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        $updatedProject = $this->projectRepository->update($project);

        return response()->json([
            'message' => 'Project updated successfully!',
            'data' => $updatedProject
        ], 200);
    }

    public function destroy($id)
    {
        $project = $this->projectRepository->findById($id);
        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        $this->projectRepository->delete($id);

        return response()->json(['message' => 'Project deleted'], 200);
    }
}
