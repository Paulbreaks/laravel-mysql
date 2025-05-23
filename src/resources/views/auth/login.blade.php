@extends('layouts.main')

@section('title', 'Вход')

@section('content')
    <h1 class="mb-4 text-center">Вход</h1>

    <!-- Показываем ошибки, если есть -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="w-50 mx-auto">
        @csrf

        <!-- Поле Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <!-- Поле Пароль -->
        <div class="mb-3">
            <label for="password" class="form-label">Пароль:</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Войти</button>
    </form>

    <p class="mt-3 text-center">Нет аккаунта? <a href="{{ route('register') }}">Зарегистрироваться</a></p>
@endsection
