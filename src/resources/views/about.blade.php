@extends('layouts.main') <!-- Наследуем основной шаблон -->

@section('title', 'О нас') <!-- Устанавливаем заголовок страницы -->

@section('content') <!-- Вставляем контент -->
    <h1 class="mb-4 text-center">О нашей компании</h1>
    
    <p class="text-center">Мы учимся на Laravel-разработчиков.</p>

    @if (!empty($team) && count($team) > 0)
        <h3 class="mt-4 text-center">Наша команда:</h3>
        <ul class="list-group w-50 mx-auto">
            @foreach ($team as $member)
                <li class="list-group-item text-center">{{ $member }}</li>
            @endforeach
        </ul>
    @else
        <p class="text-center text-muted mt-3">В нашей команде никого нет.</p>
    @endif
@endsection
