<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        // Обрабатываем ошибку "Method Not Allowed" (405) для API
        $this->renderable(function (MethodNotAllowedHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'error' => 'Method Not Allowed',
                    'message' => 'Use the correct HTTP method'
                ], 405);
            }
        });

        // Обрабатываем ошибку "Not Found" (404) для API
        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'error' => 'Not Found',
                    'message' => 'The requested resource was not found'
                ], 404);
            }
        });

        // Обрабатываем ошибку "Validation Error" (422) для API
        $this->renderable(function (ValidationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'error' => 'Validation Error',
                    'message' => $e->errors()
                ], 422);
            }
        });

        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Перехватываем ошибки авторизации.
     */
    public function unauthenticated($request, AuthenticationException $exception)
    {
        // Если запрос API (в заголовках есть 'application/json' или URL начинается с /api)
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Для обычных веб-запросов — редиректим на главную
        return redirect('/');
    }
}
