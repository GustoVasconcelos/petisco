<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TalentoController;
use App\Http\Controllers\Admin\PlanoController;
use App\Http\Controllers\Admin\ServicoController;
use App\Http\Controllers\Admin\AnimalController;
use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\AtendimentoController;

// Rotas do Site Público
Route::get('/', [SiteController::class, 'index']);

// Rotas da Área Administrativa
Route::prefix('admin')->group(function () {

    // --- Autenticação (sem middleware de auth) ---
    Route::get('/login', [AuthController::class, 'index'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

    // --- Área protegida: requer login ---
    Route::middleware('auth')->group(function () {

        // Painel principal
        Route::get('/dashboard', [DashboardController::class, 'index']);

        // Agenda
        Route::get('/agenda', [SiteController::class, 'agenda']);

        // Histórico
        Route::get('/historico', [DashboardController::class, 'historico']);

        // CRUD Animais
        Route::get('/animais', [AnimalController::class, 'index']);
        Route::post('/animais/store', [AnimalController::class, 'store']);
        Route::put('/animais/update/{id}', [AnimalController::class, 'update']);
        Route::delete('/animais/delete/{id}', [AnimalController::class, 'destroy']);

        // CRUD Talentos (Funcionários)
        Route::get('/talentos', [TalentoController::class, 'index']);
        Route::post('/talentos/store', [TalentoController::class, 'store']);
        Route::put('/talentos/update/{id}', [TalentoController::class, 'update']);
        Route::delete('/talentos/delete/{id}', [TalentoController::class, 'destroy']);

        // CRUD Tutores
        Route::resource('tutores', \App\Http\Controllers\Admin\TutorController::class);

        // CRUD Planos
        Route::get('/planos', [PlanoController::class, 'index'])->name('planos.index');
        Route::post('/planos', [PlanoController::class, 'store'])->name('planos.store');
        Route::patch('/planos/{id}/status', [PlanoController::class, 'toggleStatus'])->name('planos.status');
        Route::delete('/planos/{id}', [PlanoController::class, 'destroy'])->name('planos.destroy');
        Route::get('/planos/{id}/edit', [PlanoController::class, 'edit'])->name('planos.edit');
        Route::put('/planos/{id}', [PlanoController::class, 'update'])->name('planos.update');

        // CRUD Serviços
        Route::get('/servicos', [ServicoController::class, 'index']);
        Route::post('/servicos/store', [ServicoController::class, 'store']);
        Route::put('/servicos/update/{id}', [ServicoController::class, 'update']);
        Route::delete('/servicos/delete/{id}', [ServicoController::class, 'destroy']);

        // Agendamento (Atendente, Gerente e TI)
        Route::middleware('role:Atendente|Gerente|TI / Desenvolvedor')->group(function () {
            Route::get('/agendar-servico', [AgendamentoController::class, 'create']);
            Route::post('/agendar-servico', [AgendamentoController::class, 'store']);
        });

        // Prontuário médico (Veterinário e Auxiliar Veterinário)
        Route::middleware('role:Veterinário|Auxiliar Veterinário')->group(function () {
            Route::get('/prontuario/{id}', [AtendimentoController::class, 'create']);
            Route::post('/prontuario/salvar', [AtendimentoController::class, 'store']);
        });

    }); // fim: middleware auth

});