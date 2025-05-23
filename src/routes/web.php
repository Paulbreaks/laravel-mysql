<?php

use App\Http\Controllers\PageController; // Контроллер для статических страниц
use App\Http\Controllers\AuthController; // Контроллер авторизации
use App\Http\Controllers\GameController; // Контроллер игры
use Illuminate\Support\Facades\Route;

// Главная страница
Route::get('/', [PageController::class, 'home']);

// Страница "О нас" (если вдруг понадобится)
Route::get('/about', [PageController::class, 'about']);

// Регистрация
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register']);

// Вход
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);

// Выход (только для залогиненных)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// 🎰 Игровая страница (только для авторизованных)
Route::get('/game', function () {
    return view('game');
})->middleware('auth')->name('game');

// 🎰 Обработчик ставок (POST-запрос для игры, только для авторизованных)
Route::post('/game/play', [GameController::class, 'play'])->name('game.play');
