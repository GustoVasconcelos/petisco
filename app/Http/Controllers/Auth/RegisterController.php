<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('admin.register');
    }

    public function register(Request $request)
    {
        // Validação customizada baseada nas regras da sua Task
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'cpf' => 'required|string|unique:users',
            'celular' => 'required|string',
            'cargo' => 'required|string',
            'turno' => 'required|string',
            // O CRMV só é obrigatório se o cargo selecionado for 'Veterinário'
            'crmv' => 'required_if:cargo,Veterinário|nullable|string|unique:users',
        ]);

        // Cria o usuário no banco de dados
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'cpf' => $request->cpf,
            'celular' => $request->celular,
            'cargo' => $request->cargo,
            'crmv' => $request->crmv,
            'turno' => $request->turno,
        ]);

        // Vincula o usuário ao grupo do Spatie automaticamente com base no cargo selecionado
        if ($user->cargo) {
            $user->assignRole($request->cargo);
        }

        // Altere para esta linha:
return redirect('/admin/login')->with('success', 'Funcionário cadastrado com sucesso! Faça o login.');
    }
}