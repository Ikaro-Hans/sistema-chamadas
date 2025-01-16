<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Chamada;
use App\Models\Setor;


class ChamadaController extends Controller
{
    public function index(Request $request)
    {

    $status = $request->get('status', 'pendente');
    $query = Chamada::query();

    if ($status !== 'todas') {
        $query->where('status', '!=', 'concluida');
    }

    $chamadas = $query->orderBy('created_at', 'desc')->get();

    return view('chamadas.index', compact('chamadas'));

        if(Auth::user()->hasRole('admin')) {
            $chamadas = Chamada::all();

        } else {
            $chamadas = Auth::user()->chamadas()->get();
        }

        return view('chamadas.index', compact('chamadas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'setor_id' => 'required|exists:setores,id',
            'prioridade' => 'required|string|in:baixa,media,alta',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pendente'; // Adicione o status diretamente

        Chamada::create($validated);

        return redirect()->route('chamadas.index')->with('success', 'Chamada criada com sucesso!');
    }

    // ChamadaController.php

    public function show($id)
    {
        // Encontre a chamada pelo ID fornecido
        $chamada = Chamada::findOrFail($id);

        // Retorne a view com os detalhes da chamada
        return view('chamadas.show', compact('chamada'));
    }



    public function create()
    {
        // Obtenha os setores disponíveis para o formulário
        $setores = Setor::all();

        // Retorne a view de criação com os setores
        return view('chamadas.create', compact('setores'));
    }

    public function concluir(Request $request, $id)
{
    $chamada = Chamada::findOrFail($id);

    // Atualiza o status para 'concluida'
    $chamada->update(['status' => 'concluida']);

    return redirect()->back()->with('success', 'Chamada marcada como concluída com sucesso!');
}

}
