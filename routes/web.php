<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TalentoController;
use App\Http\Controllers\Admin\PlanoController;
use App\Http\Controllers\Admin\ServicoController;
use App\Http\Controllers\Admin\AnimalController;

// Rotas do Site Público
Route::get('/', [SiteController::class, 'index']);

// Rotas da Área Administrativa
Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'index']);
    
    // Rota do painel
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Rota da agenda
    Route::get('/agenda', [SiteController::class, 'agenda']);

    // Rota da CRUD dos Animais
    Route::get('/animais', [AnimalController::class, 'index']);
    Route::post('/animais/store', [AnimalController::class, 'store']);
    Route::put('/animais/update/{id}', [AnimalController::class, 'update']);
    Route::delete('/animais/delete/{id}', [AnimalController::class, 'destroy']);

     // CRUD Talentos
     Route::get('/talentos', [TalentoController::class, 'index']);
     Route::post('/talentos/store', [TalentoController::class, 'store']);
     Route::put('/talentos/update/{id}', [TalentoController::class, 'update']);
     Route::delete('/talentos/delete/{id}', [TalentoController::class, 'destroy']);

    // Rota dos Tutores
    Route::resource('tutores', \App\Http\Controllers\Admin\TutorController::class);

    // CRUD Planos
    // Rota para visualizar a listagem de planos
    Route::get('/planos', [PlanoController::class, 'index'])->name('planos.index'); 
    // Rota para salvar os dados enviados pelo modal de novo plano
    Route::post('/planos', [PlanoController::class, 'store'])->name('planos.store');
    // Rota para alternar o status (Ativar/Inativar)
    Route::patch('/planos/{id}/status', [PlanoController::class, 'toggleStatus'])->name('planos.status');
    // Rota para deletar o plano e suas regras
    Route::delete('/planos/{id}', [PlanoController::class, 'destroy'])->name('planos.destroy');
    // Rota para buscar os dados de um plano específico via AJAX/JavaScript
    Route::get('/planos/{id}/edit', [PlanoController::class, 'edit'])->name('planos.edit');
    // Rota para salvar as alterações do plano
    Route::put('/planos/{id}', [PlanoController::class, 'update'])->name('planos.update');

    // CRUD Serviços
    Route::get('/servicos', [ServicoController::class, 'index']);
    Route::post('/servicos/store', [ServicoController::class, 'store']);
    Route::put('/servicos/update/{id}', [ServicoController::class, 'update']);
    Route::delete('/servicos/delete/{id}', [ServicoController::class, 'destroy']);
    // Rota do Histórico
    Route::get('/historico', [DashboardController::class, 'historico']);
});