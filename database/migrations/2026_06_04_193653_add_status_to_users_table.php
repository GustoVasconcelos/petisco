<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Adiciona os campos de funcionário à tabela users.
     * A tabela foi criada originalmente com o schema padrão do Laravel.
     * Esta migration traz o banco em sincronia com o model User e unifica
     * o conceito de "talento" diretamente no cadastro de usuários do sistema.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('cpf')->unique()->nullable()->after('password');
            $table->string('celular')->nullable()->after('cpf');
            $table->string('cargo')->nullable()->after('celular');       // Atendente, Gerente, Veterinário, etc.
            $table->string('crmv')->unique()->nullable()->after('cargo'); // Obrigatório apenas para Veterinário
            $table->string('turno')->nullable()->after('crmv');          // Manhã, Tarde, Noite
            $table->string('status')->default('Ativo')->after('turno');  // Ativo / Inativo
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['cpf', 'celular', 'cargo', 'crmv', 'turno', 'status']);
        });
    }
};
