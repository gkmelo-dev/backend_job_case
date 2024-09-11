<?php

namespace App\Http\Controllers;

use App\Utils\Utils;
use Illuminate\Http\Request;

class UtilityController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/valid-ufs",
     *     summary="List all valid UFs",
     *     tags={"Utilities"},
     *     @OA\Response(
     *         response=200,
     *         description="List of valid UFs",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="ufs", type="array", @OA\Items(type="string", example="SP"))
     *         )
     *     )
     * )
     */
    public function listValidUFs()
    {
        $ufs = Utils::getValidUFs();
        return response()->json(['ufs' => $ufs], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/valid-equipments",
     *     summary="List all valid equipment categories",
     *     tags={"Utilities"},
     *     @OA\Response(
     *         response=200,
     *         description="List of valid equipment categories",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="equipments", type="array", @OA\Items(type="string", example="Módulo"))
     *         )
     *     )
     * )
     */
    public function listValidEquipments()
    {
        $equipments = Utils::getValidEquipments();
        return response()->json(['equipments' => $equipments], 200);
    }
}
