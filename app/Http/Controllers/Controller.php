<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="API de Gestão de Projetos de Energia Solar",
 *     version="1.0.0",
 *     description="Esta é a documentação da API para gestão de projetos de energia solar.",
 *     @OA\Contact(
 *         email="suporte@empresa.com"
 *     ),
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="Servidor principal"
 * )
 */

abstract class Controller
{
    //
}
