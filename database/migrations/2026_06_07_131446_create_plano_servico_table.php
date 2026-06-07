<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabela pivot para o relacionamento muitos-para-muitos entre Planos e Serviços.
     * Um plano pode incluir vários serviços e um serviço pode estar em vários planos.
     */
    public function up(): void
    {
        Schema::create('plano_servico', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plano_id')->constrained('planos')->onDelete('cascade');
            $table->foreignId('servico_id')->constrained('servicos')->onDelete('cascade');
            $table->timestamps();

            // Garante que o mesmo serviço não seja adicionado duas vezes no mesmo plano
            $table->unique(['plano_id', 'servico_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plano_servico');
    }
};
