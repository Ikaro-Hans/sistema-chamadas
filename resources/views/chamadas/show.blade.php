<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalhes da Chamada') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-semibold">{{ $chamada->titulo }}</h3>
                    <p class="mt-4"><strong>{{ __('Descrição:') }}</strong> {{ $chamada->descricao }}</p>
                    <p><strong>{{ __('Setor:') }}</strong> {{ $chamada->setor->nome }}</p>
                    <p><strong>{{ __('Prioridade:') }}</strong>
                        <span class="px-2 py-1 rounded-full 
                            @if($chamada->prioridade === 'alta') bg-red-500 text-white
                            @elseif($chamada->prioridade === 'media') bg-yellow-500 text-white
                            @else bg-green-500 text-white @endif">
                            {{ ucfirst($chamada->prioridade) }}
                        </span>
                    </p>
                    <p><strong>{{ __('Status:') }}</strong> {{ ucfirst($chamada->status) }}</p>

                    <!-- Botão de Voltar -->
                    <div class="mt-4">
                        <a href="{{ route('chamadas.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">
                            {{ __('Voltar para a lista de Chamadas') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>