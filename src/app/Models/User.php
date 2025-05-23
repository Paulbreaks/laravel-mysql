<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Поля, доступные для массового заполнения
     */
    protected $fillable = [
        'email',
        'password',
        'currency',
        'cash',
        'bonus',
        'total_cash_in',
        'total_cash_out',
        'total_bonus',
    ];

    /**
     * Поля, скрытые при сериализации (например, JSON)
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Преобразование типов полей
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
