@extends('layouts.main') <!-- Наследуем основной шаблон -->

@section('title', 'Главная') <!-- Заголовок страницы -->

@section('content') <!-- Контент -->
    <div class="text-center">
        <h1 class="mb-4">Главная страница</h1>

        @auth
            <div class="card mx-auto mb-4" style="max-width: 400px;">
                <div class="card-body">
                    <p class="fw-bold">Вы вошли как: <span class="text-primary">{{ auth()->user()->email }}</span></p>
                    <p>💰 Ваш баланс: <strong>{{ number_format(auth()->user()->cash, 2) }} {{ auth()->user()->currency }}</strong></p>
                    <p>🎁 Ваш бонус: <strong>{{ number_format(auth()->user()->bonus, 2) }} {{ auth()->user()->currency }}</strong></p>

                    <form method="POST" action="{{ route('logout') }}" class="mt-3">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100">Выйти</button>
                    </form>
                </div>
            </div>
        @else
            <p class="mb-3">Вы не вошли в систему.</p>
            <a href="{{ route('login') }}" class="btn btn-primary me-2">Войти</a>
            <a href="{{ route('register') }}" class="btn btn-outline-primary">Регистрация</a>
        @endauth
    </div>
@endsection
