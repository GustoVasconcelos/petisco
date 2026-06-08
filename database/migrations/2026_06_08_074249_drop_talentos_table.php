<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Remove a tabela 'talentos', que era código morto.
     * O TalentoController usa a tabela 'users' — esta tabela nunca foi utilizada.
     */
    public function up(): void
    {
        Schema::dropIfExists('talentos');
    }

    /**
     * Não recria a tabela no rollback, pois ela não deve existir.
     */
    public function down(): void
    {
        // Intencionalmente vazio — a tabela não deve ser recriada.
    }
};
