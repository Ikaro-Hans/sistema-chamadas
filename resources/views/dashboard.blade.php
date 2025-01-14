<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold mb-4">{{ __('Bem-vindo ao Sistema de Chamadas') }}</h1>
                    <p class="mb-6">{{ __("Gerencie suas chamadas de forma fácil e rápida.") }}</p>
                    
                    <!-- Botões de navegação -->
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="{{ ($isAdmin = auth()->user()->hasRole('admin')) ? /*TODO: modificar rota para correta*/ route('dashboard') : route('chamadas.create') }}" 
                           class="block text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow-md">
                            {{ __(($isAdmin) ? 'Gerenciar Usuários' : 'Criar Nova Chamada') }}
                        </a>
                        
                        <a href="{{ route('chamadas.index') }}" 
                           class="block text-center bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-md">
                            {{ __(($isAdmin) ? 'Ver Chamadas' : 'Ver Minhas Chamadas') }}
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
