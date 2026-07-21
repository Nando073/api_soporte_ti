<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: "API Soporte TI",
    version: "1.0.0",
    description: "Documentación de la API Soporte TI"
)]
#[OA\Server(
    url: "http://localhost:8000",
    description: "Servidor local"
)]
class Swagger
{

}