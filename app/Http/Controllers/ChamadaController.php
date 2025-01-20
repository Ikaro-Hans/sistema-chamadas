<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Chamada;
use App\Models\Setor;

class ChamadaController extends Controller
{
    // Exibe a lista de chamadas
    public function index(Request $request)
    {
        $status = $request->get('status', 'pendente'); // Filtro de status
        $query = Chamada::query();

        if (Auth::user()->hasRole('admin')) {
            if ($status !== 'todas') {
                $query->where('status', '!=', 'concluida'); // Filtra não concluídas
            }
        } else {
            $query->where('user_id', Auth::id()); // Apenas chamadas do usuário
        }

        $chamadas = $query->orderBy('created_at', 'desc')->get();

        return view('chamadas.index', compact('chamadas'));
    }

    // Exibe o formulário de criação
    public function create()
    {
        $setores = Setor::all(); // Obtém os setores para o formulário
        return view('chamadas.create', compact('setores'));
    }

    // Salva uma nova chamada
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'setor_id' => 'required|exists:setores,id',
            'prioridade' => 'required|string|in:baixa,media,alta',
            'arquivo' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $arquivoPath = null;
        if ($request->hasFile('arquivo')) {
            $arquivoPath = $request->file('arquivo')->store('chamadas', 'public');
        }

        Chamada::create([
            'titulo' => $validated['titulo'],
            'descricao' => $validated['descricao'],
            'setor_id' => $validated['setor_id'],
            'prioridade' => $validated['prioridade'],
            'arquivo' => $arquivoPath,
            'status' => 'pendente',
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('chamadas.index')->with('success', 'Chamada criada com sucesso!');
    }

    // Exibe os detalhes de uma chamada
    public function show($id)
    {
        $chamada = Chamada::findOrFail($id); // Encontra a chamada ou retorna 404

        return view('chamadas.show', compact('chamada'));
    }

    // Marca uma chamada como concluída
    public function concluir(Request $request, $id)
    {
        $chamada = Chamada::findOrFail($id);

        // Permite apenas para admin
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->back()->withErrors('Ação não autorizada.');
        }

        $chamada->update(['status' => 'concluida']);

        return redirect()->back()->with('success', 'Chamada marcada como concluída com sucesso!');
    }

    // Exibe o formulário de edição de uma chamada
    public function edit($id)
    {
        // Obtém a chamada ou retorna erro 404
        $chamada = Chamada::findOrFail($id);

        // Verifica se o usuário tem permissão para editar a chamada
        if (Auth::id() !== $chamada->user_id) {
            abort(403, 'Você não tem permissão para editar esta chamada.');
        }

        // Obtém os setores para exibir no formulário
        $setores = Setor::all();

        return view('chamadas.edit', compact('chamada', 'setores'));
    }

    public function update(Request $request, $id)
    {
        $chamada = Chamada::findOrFail($id);

        // Verifica se o usuário tem permissão para atualizar
        if (Auth::id() !== $chamada->user_id) {
            abort(403, 'Você não tem permissão para editar esta chamada.');
        }

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'setor_id' => 'required|exists:setores,id',
            'prioridade' => 'required|string|in:baixa,media,alta',
            'arquivo' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        if ($request->hasFile('arquivo')) {
            $validated['arquivo'] = $request->file('arquivo')->store('chamadas', 'public');
        }

        $chamada->update($validated);

        return redirect()->route('chamadas.index')->with('success', 'Chamada atualizada com sucesso!');
    }
}
