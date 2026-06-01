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
use App\Http\Controllers\Auth\RegisterController;

// Rotas do Site Público
Route::get('/', [SiteController::class, 'index']);

// Rotas da Área Administrativa
Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('admin.login');
    
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

    // Páginas que APENAS Atendentes, Gerentes e TI podem acessar
    Route::middleware(['auth', 'role:Atendente|Gerente|TI / Desenvolvedor'])->group(function () {
        Route::get('/agendar-servico', [AgendamentoController::class, 'create']);
        Route::post('/agendar-servico', [AgendamentoController::class, 'store']);
    });

    // Páginas médicas que APENAS Veterinários e Auxiliares podem acessar
    Route::middleware(['auth', 'role:Veterinário|Auxiliar Veterinário'])->group(function () {
        Route::get('/prontuario/{id}', [AtendimentoController::class, 'create']);
        Route::post('/prontuario/salvar', [AtendimentoController::class, 'store']);
    });

    // Rotas de Registro para testes (Ajustadas sem o prefixo duplicado)
    Route::get('/registrar', [RegisterController::class, 'showRegistrationForm'])->name('admin.register');
    Route::post('/registrar', [RegisterController::class, 'register'])->name('admin.register.store');
});