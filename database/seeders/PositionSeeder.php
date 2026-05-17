<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    public function run(): void
    {
        $cargos = [
            ['nome' => 'Desenvolvedor', 'descricao' => 'Desenvolvimento de software'],
            ['nome' => 'Gestor', 'descricao' => 'Gestão de equipa e projetos'],
            ['nome' => 'Analista', 'descricao' => 'Análise de requisitos e processos'],
        ];

        foreach ($cargos as $cargo) {
            Position::firstOrCreate(
                ['nome' => $cargo['nome']],
                ['descricao' => $cargo['descricao'], 'estado' => true]
            );
        }
    }
}
