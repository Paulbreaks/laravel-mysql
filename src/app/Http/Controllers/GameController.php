<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Bet;
use App\Models\User;

class GameController extends Controller
{
    private $payout_table = [
        '777' => 300,
        '999' => 150,
        '888' => 80,
        '555' => 50,
        '000' => 20,
        '77'  => 5,
        '7'   => 1
    ];

    // Генерируем случайный спин
    private function spinReels()
    {
        return rand(0, 9) . rand(0, 9) . rand(0, 9);
    }

    // Рассчитываем выигрыш
    private function calculatePayout($result, $bet)
    {
        $result_str = implode('', str_split($result));

        if (isset($this->payout_table[$result_str])) {
            return $this->payout_table[$result_str] * $bet;
        }

        $sevenCount = substr_count($result_str, '7');

        if ($sevenCount === 2) {
            return $this->payout_table['77'] * $bet;
        }

        if ($sevenCount === 1) {
            return $this->payout_table['7'] * $bet;
        }

        return 0;
    }

    // Игровой процесс
    public function play(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'bet' => 'required|numeric|min:0.1|max:' . $user->cash,
        ]);

        $bet = $request->bet;
        $result = $this->spinReels();
        $payout = $this->calculatePayout($result, $bet);
        $profit = $payout - $bet;

        // Обновляем баланс пользователя
        $user->cash += $profit;
        $user->save();

        // Записываем ставку в БД
        Bet::create([
            'user' => $user->email,
            'currency' => $user->currency,
            'bet' => $bet,
            'result' => $result,
            'payout' => $payout,
        ]);

        return response()->json([
            'result' => $result,
            'payout' => $payout,
            'profit' => $profit,
            'balance' => number_format(auth()->user()->cash, 2, '.', '') // Всегда в формате 0.00
        ]);
    }
}
