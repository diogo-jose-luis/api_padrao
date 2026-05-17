<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'genero',
        'fotografia',
        'cargo_id',
        'departamento_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'genero' => 'integer',
        ];
    }

    /** Cargo do utilizador. */
    public function cargo(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'cargo_id');
    }

    /** Departamento do utilizador. */
    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'departamento_id');
    }
}
