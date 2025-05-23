<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user',
        'currency',
        'bet',
        'result',
        'payout',
    ];

    public $timestamps = false; // Убираем стандартные created_at, updated_at
}
