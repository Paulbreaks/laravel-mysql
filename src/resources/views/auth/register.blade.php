@extends('layouts.main')

@section('title', 'Регистрация')

@section('content')
<h1 class="mb-4 text-center">Регистрация</h1>

    <form method="POST" action="{{ route('register') }}" class="w-50 mx-auto">
        @csrf

        <!-- Поле Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
            @error('email')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <!-- Поле Пароль -->
        <div class="mb-3">
            <label for="password" class="form-label">Пароль:</label>
            <input type="password" name="password" id="password" class="form-control" required>
            @error('password')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <!-- Подтверждение пароля -->
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Подтвердите пароль:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Зарегистрироваться</button>
    </form>

    <p class="mt-3 text-center">Уже есть аккаунт? <a href="{{ route('login') }}">Войти</a></p>
@endsection
