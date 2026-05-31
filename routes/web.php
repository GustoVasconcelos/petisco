<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TalentoController;
use App\Http\Controllers\Admin\PlanoController;
use App\Http\Controllers\Admin\ServicoController;

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
    Route::get('/animais', [DashboardController::class, 'animais']);

     // CRUD Talentos
     Route::get('/talentos', [TalentoController::class, 'index']);
     Route::post('/talentos/store', [TalentoController::class, 'store']);
     Route::put('/talentos/update/{id}', [TalentoController::class, 'update']);
     Route::delete('/talentos/delete/{id}', [TalentoController::class, 'destroy']);

    // Rota dos Tutores
    Route::resource('tutores', \App\Http\Controllers\Admin\TutorController::class);

    // Rota para visualizar a listagem de planos
    Route::get('/planos', [PlanoController::class, 'index'])->name('planos.index');
    
    // Rota para salvar os dados enviados pelo modal de novo plano
    Route::post('/planos', [PlanoController::class, 'store'])->name('planos.store');

    // CRUD Serviços
    Route::get('/servicos', [ServicoController::class, 'index']);
    Route::post('/servicos/store', [ServicoController::class, 'store']);
    Route::put('/servicos/update/{id}', [ServicoController::class, 'update']);
    Route::delete('/servicos/delete/{id}', [ServicoController::class, 'destroy']);
    // Rota do Histórico
    Route::get('/historico', [DashboardController::class, 'historico']);
});