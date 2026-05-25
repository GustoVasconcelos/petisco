<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TalentoController;
use App\Http\Controllers\Admin\PlanoController;

// Rotas do Site Público
Route::get('/', [SiteController::class, 'index']);

// Rotas da Área Administrativa
Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'index']);
    
    // Rota do painel
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Rota da CRUD dos Animais
    Route::get('/animais', [DashboardController::class, 'animais']);

     // CRUD Talentos
     Route::get('/talentos', [TalentoController::class, 'index']);
     Route::post('/talentos/store', [TalentoController::class, 'store']);
     Route::put('/talentos/update/{id}', [TalentoController::class, 'update']);
     Route::delete('/talentos/delete/{id}', [TalentoController::class, 'destroy']);

    // Rota dos Tutores
    Route::resource('tutores', \App\Http\Controllers\Admin\TutorController::class);

    // Rota dos Planos de Saúde
    Route::get('/planos', [PlanoController::class, 'index']);

    // Rota dos Serviços
    Route::get('/servicos', [DashboardController::class, 'servicos']);
    // Rota do Histórico
    Route::get('/historico', [DashboardController::class, 'historico']);
});