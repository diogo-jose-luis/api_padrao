<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departamentos = [
            ['nome' => 'TI', 'descricao' => 'Tecnologias de Informação'],
            ['nome' => 'RH', 'descricao' => 'Recursos Humanos'],
            ['nome' => 'Financeiro', 'descricao' => 'Gestão financeira'],
        ];

        foreach ($departamentos as $departamento) {
            Department::firstOrCreate(
                ['nome' => $departamento['nome']],
                ['descricao' => $departamento['descricao'], 'estado' => true]
            );
        }
    }
}
