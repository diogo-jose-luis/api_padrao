<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Utilizador inicial para desenvolvimento e testes da API.
     */
    public function run(): void
    {
        $cargo = Position::where('nome', 'Desenvolvedor')->first();
        $departamento = Department::where('nome', 'TI')->first();

        User::firstOrCreate(
            ['email' => 'diogo.luis.job@hotmail.com'],
            [
                'name' => 'Diogo Luis',
                'password' => '123456789',
                'genero' => 1,
                'cargo_id' => $cargo?->id,
                'departamento_id' => $departamento?->id,
            ]
        );
    }
}
