<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plano_regras', function (Blueprint $table) {
            $table->id();
            // Chave estrangeira que vincula a regra ao plano correspondente
            $table->foreignId('plano_id')->constrained()->onDelete('cascade');
            
            // ID do serviço/produto (que vem do select da sua tela)
            $table->unsignedBigInteger('servico_id'); 
            
            $table->string('modalidade'); // 'incluso' ou 'desconto'
            $table->integer('desconto_pct')->nullable(); // Valor do desconto caso modalidade seja 'desconto'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plano_regras');
    }
};
