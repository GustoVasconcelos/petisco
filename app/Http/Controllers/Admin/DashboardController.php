<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function animais() {
        return view('admin.animais.index');
    }

    public function talentos() {
        return view('admin.talentos.index');
    }

    public function planos() {
        return view('admin.planos.index');
    }

    public function servicos() {
        return view('admin.servicos.index');
    }
    public function historico() {
        return view('admin.historico.index');
    }
}