<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Minhas Chamadas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (!Auth::user()->hasRole('admin'))
                    <a href="{{ route('chamadas.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded mb-4 inline-block">
                        {{ __('Nova Chamada') }}
                    </a>
                    @endif

                    {{-- Filtros --}}
                    @if(Auth::user()->hasRole('admin'))
                    <div class="mb-4 flex justify-between items-center">
                        <form method="GET" action="{{ route('chamadas.index') }}" class="flex items-center space-x-2">
                            <select name="status" class="border-gray-300 rounded shadow-sm">
                                <option value="pendente" {{ request('status') === 'pendente' ? 'selected' : '' }}>
                                    {{ __('Pendentes') }}
                                </option>
                                <option value="todas" {{ request('status') === 'todas' ? 'selected' : '' }}>
                                    {{ __('Todas') }}
                                </option>
                            </select>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">
                                {{ __('Filtrar') }}
                            </button>
                        </form>
                    </div>
                    @endif

                    @if($chamadas->isEmpty())
                    <p class="text-center text-gray-500">{{ __('Nenhuma chamada encontrada.') }}</p>
                    @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($chamadas as $chamada)
                        <div class="bg-white dark:bg-gray-700 shadow-lg rounded-lg border border-gray-300 overflow-hidden">
                            <div class="px-4 py-3">
                                <div class="font-semibold text-lg text-gray-900 dark:text-gray-100">{{ $chamada->titulo }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-300">{{ ucfirst($chamada->status) }}</div>
                            </div>
                            <div class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">
                                <p><strong>{{ __('Setor:') }}</strong> {{ $chamada->setor->nome }}</p>
                                <p><strong>{{ __('Prioridade:') }}</strong>
                                    <span class="px-2 py-1 rounded-full 
                                                @if($chamada->prioridade === 'alta') bg-red-500 text-white
                                                @elseif($chamada->prioridade === 'media') bg-yellow-500 text-white
                                                @else bg-green-500 text-white @endif">
                                        {{ ucfirst($chamada->prioridade) }}
                                    </span>
                                </p>
                                @if($chamada->arquivo)
                                <p>
                                    <strong>{{ __('Anexo:') }}</strong>
                                    <a href="{{ asset('storage/' . $chamada->arquivo) }}" target="_blank" class="text-blue-500 hover:underline">
                                        {{ __('Ver Arquivo') }}
                                    </a>
                                </p>
                                @endif
                            </div>
                            <div class="px-4 py-2 flex flex-wrap gap-2">
                                <a href="{{ route('chamadas.show', $chamada->id) }}"
                                    class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">
                                    {{ __('Ver Detalhes') }}
                                </a>

                                <!-- Editar chamada apenas para o usuário que criou -->
                                @if(Auth::id() === $chamada->user_id)
                                <a href="{{ route('chamadas.edit', $chamada->id) }}"
                                    class="bg-yellow-500 hover:bg-yellow-700 text-white px-4 py-2 rounded">
                                    {{ __('Editar') }}
                                </a>

                                <!-- Excluir chamada apenas para o usuário que criou -->
                                <form action="{{ route('chamadas.destroy', $chamada->id) }}" method="POST" onsubmit="return confirm('Tem certeza de que deseja excluir esta chamada?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded">
                                        {{ __('Excluir') }}
                                    </button>
                                </form>
                                @endif

                                <!-- Concluir chamada para admin -->
                                @if(Auth::user()->hasRole('admin') && $chamada->status !== 'concluida')
                                <form action="{{ route('chamadas.concluir', $chamada->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded">
                                        {{ __('Concluir') }}
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>