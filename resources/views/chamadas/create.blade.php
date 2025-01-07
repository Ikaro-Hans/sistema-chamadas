<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Criar Nova Chamada') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('chamadas.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200">{{ __('Título') }}</label>
                            <input type="text" name="titulo" class="w-full border px-4 py-2 rounded dark:bg-gray-700 dark:text-gray-300" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200">{{ __('Descrição') }}</label>
                            <textarea name="descricao" class="w-full border px-4 py-2 rounded dark:bg-gray-700 dark:text-gray-300" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200">{{ __('Setor') }}</label>
                            <select name="setor_id" class="w-full border px-4 py-2 rounded dark:bg-gray-700 dark:text-gray-300" required>
                                @foreach($setores as $setor)
                                    <option value="{{ $setor->id }}">{{ $setor->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200">{{ __('Prioridade') }}</label>
                            <select name="prioridade" class="w-full border px-4 py-2 rounded dark:bg-gray-700 dark:text-gray-300" required>
                                <option value="baixa">{{ __('Baixa') }}</option>
                                <option value="média">{{ __('Média') }}</option>
                                <option value="alta">{{ __('Alta') }}</option>
                            </select>
                        </div>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                            {{ __('Criar') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
