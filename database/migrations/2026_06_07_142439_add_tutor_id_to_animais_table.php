<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Substitui o campo 'tutor' (string livre) por 'tutor_id' (FK para a tabela tutors),
     * estabelecendo integridade referencial entre animais e seus tutores.
     */
    public function up(): void
    {
        Schema::table('animais', function (Blueprint $table) {
            // Adiciona a chave estrangeira após o campo nome
            $table->foreignId('tutor_id')->nullable()->after('nome')->constrained('tutors')->nullOnDelete();

            // Remove a coluna antiga de texto livre
            $table->dropColumn('tutor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('animais', function (Blueprint $table) {
            $table->dropForeign(['tutor_id']);
            $table->dropColumn('tutor_id');
            $table->string('tutor')->after('nome');
        });
    }
};
