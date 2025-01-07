<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chamada;
use App\Models\User;

class AdminController extends Controller
{
    public function listarChamadas()
{
    $chamadas = Chamada::where('status', 'pendente')->with('setor', 'user')->get();
    return view('admin.chamadas', compact('chamadas'));
}

public function criarUsuario(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);

    return redirect()->back()->with('success', 'Usuário criado com sucesso!');
}

}
