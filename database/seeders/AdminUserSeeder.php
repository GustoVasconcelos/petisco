<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Cria o usuário administrador padrão do sistema.
     *
     * Credenciais padrão:
     *   E-mail: admin@petisco.com
     *   Senha:  petisco@2025
     *
     * ATENÇÃO: altere a senha após o primeiro login!
     */
    public function run(): void
    {
        // Garante que o role de TI/Desenvolvedor exista
        $role = Role::firstOrCreate([
            'name'       => 'TI / Desenvolvedor',
            'guard_name' => 'web',
        ]);

        // Cria ou atualiza o usuário admin (seguro para rodar múltiplas vezes)
        $admin = User::updateOrCreate(
            ['email' => 'admin@petisco.com'],
            [
                'name'    => 'Administrador',
                'password' => Hash::make('petisco@2025'),
                'cpf'     => '000.000.000-00',
                'celular' => '(00) 00000-0000',
                'cargo'   => 'TI / Desenvolvedor',
                'turno'   => 'Integral',
                'status'  => 'Ativo',
            ]
        );

        // Atribui o role (syncRoles garante que não duplica)
        $admin->syncRoles([$role]);

        $this->command->info('✅ Usuário admin criado!');
        $this->command->line('   E-mail: admin@petisco.com');
        $this->command->line('   Senha:  petisco@2025');
        $this->command->warn('   ⚠  Altere a senha após o primeiro login!');
    }
}
