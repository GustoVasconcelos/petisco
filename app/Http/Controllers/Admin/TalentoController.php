<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class TalentoController extends Controller
{
    /**
     * Lista todos os funcionários (usuários do sistema).
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query  = User::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('cargo', 'like', "%{$search}%")
                  ->orWhere('cpf', 'like', "%{$search}%");
        }

        $talentos = $query->orderBy('name')->get();

        return view('admin.talentos.index', compact('talentos', 'search'));
    }

    /**
     * Cadastra um novo funcionário como usuário do sistema.
     * Atribui automaticamente o role Spatie com base no cargo.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|max:255|unique:users',
            'cpf'                   => 'required|string|max:20|unique:users',
            'celular'               => 'required|string|max:20',
            'cargo'                 => 'required|string',
            'crmv'                  => 'required_if:cargo,Veterinário|nullable|string|max:50|unique:users',
            'turno'                 => 'required|string',
            'password'              => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'cpf'      => $validated['cpf'],
            'celular'  => $validated['celular'],
            'cargo'    => $validated['cargo'],
            'crmv'     => $validated['crmv'] ?? null,
            'turno'    => $validated['turno'],
            'status'   => 'Ativo',
        ]);

        // Atribui o role Spatie com base no cargo selecionado
        if ($user->cargo) {
            $user->assignRole($user->cargo);
        }

        return redirect('/admin/talentos')
            ->with('success', 'Funcionário cadastrado com sucesso! Ele já pode fazer login no sistema.');
    }

    /**
     * Atualiza os dados de um funcionário.
     * Reatribui o role se o cargo mudou.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255|unique:users,email,' . $user->id,
            'celular' => 'required|string|max:20',
            'cargo'   => 'required|string',
            'crmv'    => 'required_if:cargo,Veterinário|nullable|string|max:50|unique:users,crmv,' . $user->id,
            'turno'   => 'required|string',
            'status'  => 'required|in:Ativo,Inativo',
        ]);

        $cargoAnterior = $user->cargo;

        $user->update([
            'name'    => $validated['name'],
            'email'   => $validated['email'],
            'celular' => $validated['celular'],
            'cargo'   => $validated['cargo'],
            'crmv'    => $validated['crmv'] ?? null,
            'turno'   => $validated['turno'],
            'status'  => $validated['status'],
        ]);

        // Reatribui o role se o cargo mudou
        if ($cargoAnterior !== $validated['cargo']) {
            $user->syncRoles([$validated['cargo']]);
        }

        return redirect('/admin/talentos')
            ->with('success', 'Funcionário atualizado com sucesso!');
    }

    /**
     * Remove um funcionário do sistema.
     * Protege contra auto-exclusão.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Impede que o usuário logado se exclua
        if (Auth::id() === $user->id) {
            return redirect('/admin/talentos')
                ->with('error', 'Você não pode excluir seu próprio usuário.');
        }

        $user->delete();

        return redirect('/admin/talentos')
            ->with('success', 'Funcionário removido do sistema com sucesso!');
    }
}