<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;

// Rotas do Site Público
Route::get('/', [SiteController::class, 'index']);

// Rotas da Área Administrativa
Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'index']);
    
    // Rota do painel
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Rota dos Talentos (Funcionarios)
    Route::get('/talentos', [DashboardController::class, 'talentos']);

    // Rota dos Tutores
    Route::get('/tutores', [DashboardController::class, 'tutores']);
});