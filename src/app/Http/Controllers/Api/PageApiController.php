<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageApiController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/home",
     *      summary="Home API-page",
     *      tags={"Home"},
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Welcome to API!")
     *          )
     *      )
     * )
     */
    public function home()
    {
        return response()->json([
            'message' => 'Hi its Laravel API Home!',
            'status' => 200
        ]);
    }

    /**
     * @OA\Get(
     *      path="/api/about",
     *      summary="Страница 'О нас'",
     *      tags={"About"},
     *      @OA\Response(
     *          response=200,
     *          description="Успешный ответ",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="info", type="string", example="Это API о нас!")
     *          )
     *      )
     * )
     */
    public function about()
    {
        return response()->json([
            'message' => 'About US',
            'status' => 200
        ]);
    }
    /**
     * @OA\Get(
     *      path="/api/test",
     *      operationId="getTest",
     *      tags={"Test"},
     *      summary="Пример тестового запроса",
     *      description="Этот эндпоинт возвращает тестовые данные",
     *      @OA\Response(
     *          response=200,
     *          description="Успешный ответ",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="API работает!")
     *          )
     *      )
     * )
     */
    public function test()
    {
        return response()->json(['message' => 'API тест работает!']);
    }
}
