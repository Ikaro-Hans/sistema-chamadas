<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gerenciar Usuários') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a href="{{ route('admin.usuarios.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        {{ __('Adicionar Novo Usuário') }}
                    </a>

                    <table class="table-auto w-full mt-4">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">{{ __('Nome') }}</th>
                                <th class="px-4 py-2">{{ __('Email') }}</th>
                                <th class="px-4 py-2">{{ __('Ações') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usuarios as $usuario)
                            <tr>
                                <td class="border px-4 py-2">{{ $usuario->name }}</td>
                                <td class="border px-4 py-2">{{ $usuario->email }}</td>
                                <td class="border px-4 py-2">
                                    <form action="{{ route('admin.usuarios.updateRole', $usuario->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role" onchange="this.form.submit()">
                                            <option value="padrao" {{ $usuario->hasRole('padrao') ? 'selected' : '' }}>Usuário</option>
                                            <option value="admin" {{ $usuario->hasRole('admin') ? 'selected' : '' }}>Administrador</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>