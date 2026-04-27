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

    public function talentos() {
        return view('admin.talentos.index');
    }

    public function tutores() {
        return view('admin.tutores.index');
    }
}