<?php

use App\Http\Controllers\Api\PageApiController;
use App\Http\Controllers\Api\ApiAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// API страницы
Route::get('/home', [PageApiController::class, 'home']);
Route::get('/about', [PageApiController::class, 'about']);
Route::get('/test', [PageApiController::class, 'test']);

// Аутентификация API через Laravel Sanctum
Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/login', [ApiAuthController::class, 'login']);
Route::post('/logout', [ApiAuthController::class, 'logout'])->middleware('auth:sanctum');

// информация пользователя /user
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json($request->user());
});
