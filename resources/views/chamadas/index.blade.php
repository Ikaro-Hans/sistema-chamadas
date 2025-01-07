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
                    <a href="{{ route('chamadas.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">
                        {{ __('Nova Chamada') }}
                    </a>

                    <table class="w-full mt-4 border">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700">
                                <th class="border px-4 py-2">{{ __('Título') }}</th>
                                <th class="border px-4 py-2">{{ __('Setor') }}</th>
                                <th class="border px-4 py-2">{{ __('Prioridade') }}</th>
                                <th class="border px-4 py-2">{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($chamadas as $chamada)
                                <tr>
                                    <td class="border px-4 py-2">{{ $chamada->titulo }}</td>
                                    <td class="border px-4 py-2">{{ $chamada->setor->nome }}</td>
                                    <td class="border px-4 py-2">{{ ucfirst($chamada->prioridade) }}</td>
                                    <td class="border px-4 py-2">{{ ucfirst($chamada->status) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
