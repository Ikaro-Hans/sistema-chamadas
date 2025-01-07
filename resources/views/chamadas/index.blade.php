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
                    <a href="{{ route('chamadas.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded mb-4 inline-block">
                        {{ __('Nova Chamada') }}
                    </a>

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
                                    </div>
                                    <div class="px-4 py-2 flex justify-end">
                                        <a href="{{ route('chamadas.show', $chamada->id) }}" 
                                           class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">
                                            {{ __('Ver Detalhes') }}
                                        </a>
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
