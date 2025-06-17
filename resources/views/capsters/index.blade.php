@extends('layouts.app')

@section('title', 'Capsters') {{-- Changed title to Capsters --}}

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center py-4 gap-2">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">
                ✂️ Capsters {{-- Changed icon and text --}}
            </h1>
            <a href="{{ route('capsters.create') }}" {{-- Assuming a capsters.create route exists --}}
                class="w-full sm:w-auto text-center inline-flex items-center justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition">
               <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Create Capster {{-- Changed text --}}
            </a>
        </div>

        {{-- Search & Filter --}}
        <form method="GET" action="{{ route('capsters.index') }}" class="mb-4 flex flex-col sm:flex-row flex-wrap gap-2 sm:gap-4">
            <input type="text" name="search" placeholder="Search Capsters..." value="{{ request('search') }}"
                class="w-full sm:w-1/3 px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring focus:border-indigo-500">

            {{-- You can add other filters here later if needed, like gender or origin --}}
            {{-- Example:
            <select name="jenis_kelamin" class="w-full sm:w-auto px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring focus:border-indigo-500">
                <option value="">-- All Genders --</option>
                <option value="L" @if (request('jenis_kelamin') == 'L') selected @endif>Laki-laki</option>
                <option value="P" @if (request('jenis_kelamin') == 'P') selected @endif>Perempuan</option>
            </select>
            --}}

            <button type="submit"
                class="w-full sm:w-auto px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                🔍 Search
            </button>
            @if (request('search'))
                <a href="{{ route('capsters.index') }}" class="w-full sm:w-auto px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition flex items-center justify-center">
                    Clear Search
                </a>
            @endif
        </form>

        {{-- Table Wrapper --}}
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 text-sm sm:text-base">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#
                        </th>
                        <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            📸 Foto</th>
                        <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            🧑 Nama</th>
                        <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            📝 Inisial</th>
                        <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            🚻 Jenis Kelamin</th>
                        <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            📞 No. HP</th>
                        <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            📍 Asal</th>
                        <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ⚙️ Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($capsters as $capster)
                        <tr class="hover:bg-gray-50">
                            <td class="px-2 sm:px-4 py-2 text-gray-700">
                                {{ $loop->iteration + ($capsters->currentPage() - 1) * $capsters->perPage() }}</td>
                            <td class="px-2 sm:px-4 py-2">
                                <img src="{{ $capster->foto_url }}" alt="{{ $capster->nama }}"
                                     class="w-10 h-10 rounded-full object-cover">
                            </td>
                            <td class="px-2 sm:px-4 py-2 text-gray-700">{{ $capster->nama }}</td>
                            <td class="px-2 sm:px-4 py-2 text-gray-700">{{ $capster->inisial }}</td>
                            <td class="px-2 sm:px-4 py-2 text-gray-700">{{ $capster->jenis_kelamin }}</td>
                            <td class="px-2 sm:px-4 py-2 text-gray-700">{{ $capster->no_hp }}</td>
                            <td class="px-2 sm:px-4 py-2 text-gray-700">{{ $capster->asal }}</td>
                            <td class="px-4 py-3 text-sm space-x-2 flex items-center">
                                {{-- Show --}}
                                <a href="{{ route('capsters.show', $capster) }}" {{-- Assuming a capsters.show route exists --}}
                                    class="inline-flex items-center px-2 py-1 bg-green-500 hover:bg-green-600 text-white rounded transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Show
                                </a>

                                {{-- Edit --}}
                                <a href="{{ route('capsters.edit', $capster) }}" {{-- Assuming a capsters.edit route exists --}}
                                    class="inline-flex items-center px-2 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg>
                                    Edit
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('capsters.destroy', $capster) }}" method="POST" class="inline" {{-- Assuming a capsters.destroy route exists --}}
                                    onsubmit="return confirm('Are you sure you want to delete this capster?');">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center px-2 py-1 bg-red-500 hover:bg-red-600 text-white rounded transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-6 text-gray-500">No capsters found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $capsters->appends(request()->query())->links() }} {{-- Add appends() for pagination to work with search --}}
        </div>
    </div>
@endsection