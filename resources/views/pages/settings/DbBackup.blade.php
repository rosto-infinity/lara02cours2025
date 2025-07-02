@extends('layouts.crud.layout-crud')
@section('title', 'CRUD Operations')
@section('content')
    <div class="my-5">
        <div class="container mx-auto">
            @if (session()->has('success'))
                <div class="bg-green-200 text-green-800 px-4 py-2">
                    {{ session('success') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="bg-red-200 text-red-800 px-4 py-2">
                    {{ session('error') }}
                </div>
            @endif
            <div>
                <form action="{{ route('dbbackup.import') }}" method="POST" enctype="multipart/form-data"
                    class="flex items-center gap-2">
                    @csrf
                    <input type="file" name="backup_file" accept=".gz" required class="border p-2 rounded">
                    <button type="submit" class="px-5 py-2 bg-blue-500 rounded-md text-white text-lg shadow-md">
                        Importer
                    </button>
                </form>
            </div>
            <div class="flex justify-between items-center bg-gray-200 p-5 rounded-md mt-2.5">
                <div>
                    <a href="{{ route('products.index') }}"
                        class="px-5 py-2 bg-green-500 rounded-md text-white text-lg shadow-md">List products</a>
                </div>
                <div>
                    <h1 class="text-xl text-semibold">DB Backup ( {{ $backupsCount }} )</h1>
                </div>

                <form action="{{ route('dbbackup.create') }}" method="POST">
                    @csrf
                    @method('POST')

                    <button class="px-5 py-2 bg-green-500 rounded-md text-white text-lg shadow-md">
                        Créer une nouvelle sauvegarde
                    </button>
                </form>
            </div>
            <div class="flex flex-col">
                <div class=" bg-white dark:bg-gray-800 rounded-lg shadow">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Nom</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Taille</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Date</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">

                            @foreach ($backups as $backup)
                                <tr>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $backup['name'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $backup['size'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ \Carbon\Carbon::createFromTimestamp($backup['last_modified'])->toDateTimeString() }}
                                        <!-- Format date -->
                                    </td>

                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300 space-x-2">
                                        <form action="{{ route('dbbackup.download') }}" method="GET" class="inline">
                                            @csrf
                                            <input type="hidden" name="path" value="{{ $backup['path'] }}">
                                            <button type="submit"
                                                class="px-3 py-1 bg-green-500 rounded-md text-white text-sm shadow-md">
                                                Télécharger
                                            </button>
                                        </form>
                                        <form action="{{ route('dbbackup.delete') }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="path" value="{{ $backup['path'] }}">
                                            <button type="submit"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette sauvegarde?')"
                                                class="px-3 py-1 bg-red-500 rounded-md text-white text-sm shadow-md">
                                                Supprimer
                                            </button>
                                        </form>
                                        <form action="{{ route('dbbackup.restore') }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="path" value="{{ $backup['path'] }}">
                                            <button type="submit"
                                                onclick="return confirm('Êtes-vous sûr de vouloir restaurer cette sauvegarde?')"
                                                class="px-3 py-1 bg-yellow-500 rounded-md text-white text-sm shadow-md">
                                                Restaurer
                                            </button>
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

@endsection
