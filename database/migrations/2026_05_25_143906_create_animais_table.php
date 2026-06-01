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
        Schema::create('animais', function (Blueprint $table) {
            $table->id();

            $table->string('nome');
            $table->string('tutor');
            $table->string('tipo');
            $table->string('raca');

            $table->decimal('peso', 5, 2)->nullable();

            $table->date('nascimento')->nullable();

            $table->string('genero')->nullable();

            $table->string('porte')->nullable();

            $table->text('observacoes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animais');
    }
};