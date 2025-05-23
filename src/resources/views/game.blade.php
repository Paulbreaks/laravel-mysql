@extends('layouts.main')

@section('content')
    <div class="container">
        <h1 class="text-center">Игра</h1>

        <!-- ✅ Отображение баланса -->
        <div class="text-center mb-4">
            <h3>Баланс: <span id="balance">{{ number_format(auth()->user()->cash, 2) }}</span>
                <span id="currency">{{ auth()->user()->currency }}</span>
            </h3>
        </div>

        <!-- ✅ Форма для ввода ставки -->
        <form id="game-form" class="text-center">
            @csrf
            <div class="d-inline-flex align-items-center">
                <label for="bet" class="me-2 fw-bold">Ставка:</label>
                <input type="text" id="bet" name="bet" class="form-control text-center fw-bold" value="10"
                    required style="width: 120px;">
            </div>
            <button type="submit" class="btn btn-primary ms-2">Играть</button>
            <!-- ✅ Ошибка, если недостаточно средств -->
            <div id="bet-error" class="text-danger mt-2" style="display: none;">Недостаточно средств!</div>
        </form>

        <!-- ✅ Слот-машина -->
        <div id="slot-machine" class="text-center mt-4">
            <h1 id="slot-result" style="font-size: 50px;">— — —</h1>
        </div>

        <!-- ✅ Результаты игры (показываются после анимации) -->
        <div id="game-results" class="mt-4 text-center" style="display: none;">
            <h3 id="game-payout">Выигрыш: <span>0.00</span> {{ auth()->user()->currency }}</h3>
        </div>

        <!-- ✅ Подключаем JavaScript анимации игры -->
        <script>
            window.Laravel = {
                gamePlayUrl: "{{ route('game.play') }}",
                csrfToken: "{{ csrf_token() }}",
                balance: "{{ number_format(auth()->user()->cash, 2, '.', '') }}",
                currency: "{{ auth()->user()->currency }}" // ✅ Теперь передаём валюту
            };
        </script>
        <script src="{{ asset('js/game.js') }}"></script>
    @endsection
