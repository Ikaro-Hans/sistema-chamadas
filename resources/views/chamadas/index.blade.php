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
                            <!-- Cabeçalho do card -->
                            <div class="flex items-center justify-between px-4 py-3 bg-blue-500 text-white rounded-t-lg">
                                <div class="font-semibold text-lg truncate">{{ $chamada->titulo }}</div>
                                <span class="text-sm bg-gray-100 text-gray-800 px-2 py-1 rounded-full">
                                    {{ ucfirst($chamada->status) }}
                                </span>
                            </div>

                            <!-- Corpo do card -->
                            <div class="px-4 py-3">
                                <p class="text-sm text-gray-700 dark:text-gray-300 mb-2">
                                    <strong>{{ __('Setor:') }}</strong> {{ $chamada->setor->nome }}
                                </p>
                                <p class="text-sm text-gray-700 dark:text-gray-300 mb-2">
                                    <strong>{{ __('Prioridade:') }}</strong>
                                    <span class="px-2 py-1 rounded-full 
                            @if($chamada->prioridade === 'alta') bg-red-500 text-white
                            @elseif($chamada->prioridade === 'media') bg-yellow-500 text-white
                            @else bg-green-500 text-white @endif">
                                        {{ ucfirst($chamada->prioridade) }}
                                    </span>
                                </p>
                                @if($chamada->arquivo)
                                <p class="text-sm text-blue-500 hover:underline">
                                    <a href="{{ asset('storage/' . $chamada->arquivo) }}" target="_blank">{{ __('Ver Anexo') }}</a>
                                </p>
                                @endif
                            </div>

                            <!-- Rodapé do card -->
                            <div class="px-4 py-2 flex flex-wrap gap-2">
                                <a href="{{ route('chamadas.show', $chamada->id) }}"
                                    class="bg-blue-500 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded w-full sm:w-auto text-center">
                                    {{ __('Ver Detalhes') }}
                                </a>

                                @if(Auth::id() === $chamada->user_id)
                                <a href="{{ route('chamadas.edit', $chamada->id) }}"
                                    class="bg-yellow-500 hover:bg-yellow-700 text-white text-sm px-4 py-2 rounded w-full sm:w-auto text-center">
                                    {{ __('Editar') }}
                                </a>
                                <form action="{{ route('chamadas.destroy', $chamada->id) }}" method="POST" onsubmit="return confirm('Tem certeza de que deseja excluir esta chamada?');" class="w-full sm:w-auto">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white text-sm px-4 py-2 rounded w-full sm:w-auto text-center">
                                        {{ __('Excluir') }}
                                    </button>
                                </form>
                                @endif

                                @if(Auth::user()->hasRole('admin') && $chamada->status !== 'concluida')
                                <form action="{{ route('chamadas.concluir', $chamada->id) }}" method="POST" class="w-full sm:w-auto">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white text-sm px-4 py-2 rounded w-full sm:w-auto text-center">
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