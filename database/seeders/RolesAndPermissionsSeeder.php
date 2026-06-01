<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Limpa o cache de permissões do Spatie
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Cria os grupos (Roles) solicitados no escopo do projeto
        Role::create(['name' => 'Atendente']);
        Role::create(['name' => 'Auxiliar Veterinário']);
        Role::create(['name' => 'Esteticista / Tosador']);
        Role::create(['name' => 'Gerente']);
        Role::create(['name' => 'Veterinário']);
        Role::create(['name' => 'TI / Desenvolvedor']);
    }
}