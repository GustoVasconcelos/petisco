<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Cria todos os roles (cargos) do sistema Petisco.
     * Usa firstOrCreate para ser seguro rodar múltiplas vezes.
     */
    public function run(): void
    {
        $roles = [
            'Atendente',
            'Auxiliar Veterinário',
            'Esteticista / Tosador',
            'Gerente',
            'Veterinário',
            'TI / Desenvolvedor',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate([
                'name'       => $role,
                'guard_name' => 'web',
            ]);
        }

        $this->command->info('Roles do sistema Petisco criados com sucesso!');
    }
}
