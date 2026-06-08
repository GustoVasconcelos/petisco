<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\Tutor;
use App\Models\Servico;
use App\Models\Plano;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'totalTutores'  => Tutor::count(),
            'totalAnimais'  => Animal::count(),
            'totalServicos' => Servico::count(),
            'planoAtivos'   => Plano::where('ativo', true)->count(),
            'totalFuncionarios' => User::where('status', 'Ativo')->count(),
        ];

        // Últimos 5 tutores cadastrados
        $ultimosTutores = Tutor::orderByDesc('created_at')->limit(5)->get();

        // Últimos 5 animais cadastrados com tutor
        $ultimosAnimais = Animal::with('tutor')->orderByDesc('created_at')->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'ultimosTutores', 'ultimosAnimais'));
    }

    public function historico()
    {
        return view('admin.historico.index');
    }
}