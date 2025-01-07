@extends('layout')

@section('title', 'Nova Chamada')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Criar Nova Chamada</h1>
        <form action="{{ route('chamadas.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700">Título</label>
                <input type="text" name="titulo" class="w-full border px-4 py-2 rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Descrição</label>
                <textarea name="descricao" class="w-full border px-4 py-2 rounded" required></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Setor</label>
                <select name="setor_id" class="w-full border px-4 py-2 rounded" required>
                    @foreach($setores as $setor)
                        <option value="{{ $setor->id }}">{{ $setor->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Prioridade</label>
                <select name="prioridade" class="w-full border px-4 py-2 rounded" required>
                    <option value="baixa">Baixa</option>
                    <option value="média">Média</option>
                    <option value="alta">Alta</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Criar</button>
        </form>
    </div>
@endsection
