@extends('layouts.app')

@section('title', 'Customer Books')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center py-4 gap-2">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">
                📚 Customer Books
            </h1>
            <a href="{{ route('customer-books.create') }}"
                class="w-full sm:w-auto text-center inline-flex items-center justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition">
           <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                 Create
            </a>
        </div>

        {{-- Search & Filter --}}
        <form method="GET" class="mb-4 flex flex-col sm:flex-row flex-wrap gap-2 sm:gap-4">
            <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}"
                class="w-full sm:w-1/3 px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring focus:border-indigo-500">

            <select name="barber"
                class="w-full sm:w-auto px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring focus:border-indigo-500">
                <option value="">-- All Barbers --</option>
                @foreach ($barbers as $name)
                    <option value="{{ $name }}" @if (request('barber') == $name) selected @endif>
                        {{ $name }}</option>
                @endforeach
            </select>

            <button type="submit"
                class="w-full sm:w-auto px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                🔍 Filter
            </button>
        </form>

        {{-- Table Wrapper --}}
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 text-sm sm:text-base">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#
                        </th>
                        <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            👤 Customer</th>
                        <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            🧢 Cap</th>
                        <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ✂️ Haircut</th>
                        <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            💈 Barber</th>
                        <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            💰 Price</th>
                        <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        ⚙️ Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($books as $book)
                        <tr class="hover:bg-gray-50">
                            <td class="px-2 sm:px-4 py-2 text-gray-700">
                                {{ $loop->iteration + ($books->currentPage() - 1) * $books->perPage() }}</td>
                            <td class="px-2 sm:px-4 py-2 text-gray-700">{{ $book->customer }}</td>
                            <td class="px-2 sm:px-4 py-2 text-gray-700">{{ $book->cap }}</td>
                            <td class="px-2 sm:px-4 py-2 text-gray-700">{{ $book->haircut_type }}</td>
                            <td class="px-2 sm:px-4 py-2 text-gray-700">{{ $book->barber_name }}</td>
                            <td class="px-2 sm:px-4 py-2 text-gray-700">Rp {{ number_format($book->price, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-sm space-x-2 flex items-center">
                                {{-- Show --}}
                                <a href="{{ route('customer-books.show', $book) }}"
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
                                <a href="{{ route('customer-books.edit', $book) }}"
                                    class="inline-flex items-center px-2 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg>

                                    Edit
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('customer-books.destroy', $book) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Are you sure?');">
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
                            <td colspan="7" class="text-center py-6 text-gray-500">No records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $books->links() }}
        </div>
    </div>
@endsection
