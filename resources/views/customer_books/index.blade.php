{{-- resources/views/customer_books/index.blade.php --}}
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
                class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Create
            </a>
        </div>

        {{-- Search & Filter --}}
        <form method="GET" class="mb-4 flex flex-col sm:flex-row flex-wrap gap-2 sm:gap-4">
            {{-- Search tetap tersedia untuk semua --}}
            <input type="text" name="search" placeholder="Search..." value="{{ $search }}"
                class="w-full sm:w-1/3 px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring focus:border-indigo-500">

            @if (auth()->user()->level === 'admin')
                {{-- Admin boleh memilih barber --}}
                <select name="barber"
                    class="w-full sm:w-auto px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring focus:border-indigo-500">
                    <option value="">-- All Barbers --</option>
                    @foreach ($barbers as $name)
                        <option value="{{ $name }}" {{ $barber === $name ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            @else
                {{-- Kasir otomatis hanya melihat data miliknya --}}
                <div class="w-full sm:w-auto px-4 py-2 bg-gray-100 rounded-lg">
                    <span class="text-gray-700">Barber: {{ auth()->user()->name }}</span>
                </div>
                <input type="hidden" name="barber" value="{{ auth()->user()->name }}">
            @endif

            <button type="submit"
                class="w-full sm:w-auto px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                🔍 Filter
            </button>
        </form>

        {{-- Table --}}
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">👤 Customer</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">🧢 Inisial</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">✂️ Haircut</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">🎨 Coloring</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">🧴 Produk</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">💈 Barber</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">💰 Price</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">⚙️ Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-sm">
                    @forelse($books as $book)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">
                                {{ $loop->iteration + ($books->currentPage() - 1) * $books->perPage() }}
                            </td>
                            <td class="px-4 py-2">{{ $book->customer }}</td>
                            <td class="px-4 py-2">{{ $book->cap }}</td>
                            <td class="px-4 py-2">{{ $book->haircut_type }}</td>
                            <td class="px-4 py-2">{{ $book->colouring_other ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $book->sell_use_product ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $book->barber_name }}</td>
                            <td class="px-4 py-2">Rp {{ number_format($book->price, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 flex space-x-2">
                                <a href="{{ route('customer-books.show', $book) }}"
                                    class="px-2 py-1 bg-green-500 hover:bg-green-600 text-white rounded text-xs">Show</a>
                                <a href="{{ route('customer-books.edit', $book) }}"
                                    class="px-2 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded text-xs">Edit</a>
                                <form action="{{ route('customer-books.destroy', $book) }}" method="POST"
                                    onsubmit="return confirm('Are you sure?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="px-2 py-1 bg-red-500 hover:bg-red-600 text-white rounded text-xs">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-6 text-center text-gray-500">No records found.</td>
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
