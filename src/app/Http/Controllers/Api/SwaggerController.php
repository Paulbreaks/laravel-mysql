<?php

namespace App\Http\Controllers\Api;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Laravel API",
 *      description="Документация API с Swagger",
 *      @OA\Contact(email="your@email.com"),
 * )
 *
 * @OA\Server(
 *      url="http://localhost:8080",
 *      description="Локальный сервер API"
 * )
 *
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      type="http",
 *      scheme="bearer",
 *      bearerFormat="JWT"
 * )
 */
class SwaggerController
{
    // Этот контроллер нужен только для Swagger-аннотаций
}
