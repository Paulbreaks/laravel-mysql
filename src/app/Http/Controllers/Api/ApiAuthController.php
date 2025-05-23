<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;

class ApiAuthController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/register",
     *      summary="Register a new user",
     *      tags={"Auth"},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name", "email", "password", "password_confirmation"},
     *              @OA\Property(property="name", type="string", example="John Doe"),
     *              @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *              @OA\Property(property="password", type="string", format="password", example="password123"),
     *              @OA\Property(property="password_confirmation", type="string", format="password", example="password123")
     *          )
     *      ),
     *      @OA\Response(response=201, description="User registered successfully"),
     *      @OA\Response(response=409, description="User already exists"),
     *      @OA\Response(response=422, description="Validation Error")
     * )
     */
    public function register(Request $request)
    {
        // Проверяем, есть ли у пользователя уже токен (он уже залогинен)
        if ($request->bearerToken() && auth('sanctum')->user()) {
            return response()->json([
                'error' => 'Conflict',
                'message' => [
                    'general' => ['Already authenticated']
                ]
            ], 409);
        }

        // Проверяем, существует ли уже пользователь с таким email
        if (User::where('email', $request->email)->exists()) {
            return response()->json([
                'error' => 'Conflict',
                'message' => [
                    'email' => ['Email already exists']
                ]
            ], 409);
        }

        // Валидируем входные данные (убираем `name` из списка обязательных)
        try {
            $request->validate([
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation Error',
                'message' => $e->errors()
            ], 422);
        }

        // Создаем нового пользователя (если `name` не передан, ставим `null` или дефолтное значение)
        $user = User::create([
            'name' => $request->input('name', null),
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Создаем токен для нового пользователя
        $token = $user->createToken('auth_token')->plainTextToken;
        // Успешная регистрация и авторизация
        return response()->json([
            'message' => 'Registered successfully',
            'token' => $token
        ], 201);
    }

    /**
     * @OA\Post(
     *      path="/api/login",
     *      summary="User login and token generation",
     *      tags={"Auth"},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"email", "password"},
     *              @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *              @OA\Property(property="password", type="string", format="password", example="password123")
     *          )
     *      ),
     *      @OA\Response(response=200, description="Login successful, returns token"),
     *      @OA\Response(response=401, description="Unauthorized"),
     *      @OA\Response(response=409, description="User already authenticated")
     * )
     */
    public function login(Request $request)
    {
        // Проверяем, не залогинен ли уже пользователь
        if (auth('sanctum')->check()) {
            return response()->json([
                'error' => 'Conflict',
                'message' => [
                    'general' => ['Already authenticated']
                ]
            ], 409);
        }

        // Валидируем входные данные
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation Error',
                'message' => $e->errors()
            ], 422);
        }

        // Ищем пользователя
        $user = User::where('email', $request->email)->first();

        // Проверяем пароль
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => [
                    'token' => ['Wrong credentials']
                ]
            ], 401);
        }

        // Удаляем старые токены пользователя перед выдачей нового
        $user->tokens()->delete();

        // Генерируем новый токен
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token
        ], 200);
    }

    /**
     * @OA\Get(
     *      path="/api/user",
     *      summary="Get authenticated user details",
     *      tags={"Auth"},
     *      security={{"bearerAuth": {}}},
     *      @OA\Response(response=200, description="Authenticated user data"),
     *      @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function user(Request $request) // метод для запроса данных пользователя
    {
        return response()->json($request->user());
    }

    /**
     * @OA\Post(
     *      path="/api/logout",
     *      summary="Logout user (invalidate token)",
     *      tags={"Auth"},
     *      security={{"bearerAuth": {}}},
     *      @OA\Response(response=200, description="Successfully logged out"),
     *      @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function logout(Request $request)
    {
        // Проверяем, есть ли активный пользователь
        if (!$request->user()) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => [
                    'general' => ['Not authenticated']
                ]
            ], 401);
        }

        // Удаляем только текущий токен
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout successful'
        ], 200);
    }
}
