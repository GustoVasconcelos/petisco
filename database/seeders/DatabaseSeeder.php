<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Ordem de execução:
     *  1. AdminUserSeeder   — cria o usuário admin padrão
     *  2. PetiscoSeeder     — popula todos os módulos com dados de demonstração
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            PetiscoSeeder::class,
        ]);
    }
}
