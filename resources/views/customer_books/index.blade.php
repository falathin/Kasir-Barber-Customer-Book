<!-- resources/views/customer_books/index.blade.php -->
@extends('layouts.app')

@section('title', 'Customer Books')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
  <!-- Header -->
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <h1 class="text-3xl font-extrabold text-gray-800">📚 Customer Books</h1>

    @if(auth()->user()->level === 'admin')
      @if($showAll)
        <a href="{{ route('customer-books.index') }}"
           class="px-5 py-2 bg-gray-300 text-gray-800 rounded-full shadow hover:bg-gray-400 transition">
          🔙 Hari Ini
        </a>
      @else
        <a href="{{ route('customer-books.index', array_merge(request()->query(), ['show' => 'all'])) }}"
           class="px-5 py-2 bg-indigo-600 text-white rounded-full shadow hover:bg-indigo-700 transition">
          📅 Lihat Semua
        </a>
      @endif
    @endif
  </div>

  <!-- Filters & Actions -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <form method="GET" class="flex flex-wrap gap-3 flex-1">
      <input type="text" name="search" placeholder="Search..."
             value="{{ $search }}"
             class="flex-1 min-w-[150px] px-4 py-2 border border-gray-300 rounded-full shadow-sm
                    focus:outline-none focus:ring-2 focus:ring-indigo-500">

      @if(auth()->user()->level === 'admin')
        <select name="barber"
                class="px-4 py-2 border border-gray-300 rounded-full shadow-sm
                       focus:outline-none focus:ring-2 focus:ring-indigo-500">
          <option value="">-- All Barbers --</option>
          @foreach($barbers as $name)
            <option value="{{ $name }}" {{ $barber === $name ? 'selected' : '' }}>
              {{ $name }}
            </option>
          @endforeach
        </select>
      @else
        <div class="px-4 py-2 bg-gray-100 rounded-full text-sm">
          Barber: <strong>{{ auth()->user()->name }}</strong>
        </div>
        <input type="hidden" name="barber" value="{{ auth()->user()->name }}">
      @endif

      <select name="status"
              class="px-4 py-2 border border-gray-300 rounded-full shadow-sm
                     focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <option value="">-- All Status --</option>
        <option value="antre"  {{ request('status')==='antre'  ? 'selected':'' }}>Antre</option>
        <option value="proses" {{ request('status')==='proses' ? 'selected':'' }}>Proses</option>
        <option value="done"  {{ request('status')==='done'  ? 'selected':'' }}>Done</option>
      </select>

      <button type="submit"
              class="px-6 py-2 bg-indigo-600 text-white rounded-full shadow hover:bg-indigo-700 transition">
        🔍 Filter
      </button>
    </form>

    <a href="{{ route('customer-books.create') }}"
       class="inline-flex items-center px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-full shadow transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
           viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 4v16m8-8H4"/>
      </svg>
      Create
    </a>
  </div>

  @if($showAll)
    <p class="text-sm text-gray-500 mb-4">Menampilkan <strong>semua</strong> data customer book.</p>
  @else
    <p class="text-sm text-gray-500 mb-4">
      Menampilkan data untuk <strong>hari ini</strong> ({{ \Carbon\Carbon::today()->format('d M Y') }})
    </p>
  @endif

  <!-- Table -->
  <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          @foreach(['#','Customer','Inisial','Antrian','Haircut','Coloring','Produk','Barber','Price','Status','Aksi'] as $col)
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
              {{ $col }}
            </th>
          @endforeach
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-100 text-sm">
        @forelse($books as $book)
          @php
            $isDone   = $book->price && $book->colouring_other && $book->qr;
            $isProses = !$isDone && $book->cap;
            $isAntre  = !$isDone && !$isProses && $book->customer && $book->barber_name && $book->antrian;
          @endphp
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-2">
              {{ ($books->total() - (($books->currentPage()-1)*$books->perPage())) - $loop->index }}
            </td>
            <td class="px-4 py-2">{{ $book->customer ?? '-' }}</td>
            <td class="px-4 py-2">{{ $book->cap      ?? '-' }}</td>
            <td class="px-4 py-2">{{ $book->antrian  ?? '-' }}</td>
            <td class="px-4 py-2">{{ $book->haircut_type    ?? '-' }}</td>
            <td class="px-4 py-2">{{ $book->colouring_other ?? '-' }}</td>
            <td class="px-4 py-2">{{ $book->sell_use_product ?? '-' }}</td>
            <td class="px-4 py-2">{{ $book->barber_name      ?? '-' }}</td>
            <td class="px-4 py-2 rupiah" data-price="{{ $book->price }}"></td>
            <td class="px-4 py-2">
              @if($isDone)
                <span class="px-3 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">Done</span>
              @elseif($isProses)
                <span class="px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full">Proses</span>
              @elseif($isAntre)
                <span class="px-3 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded-full">Antre</span>
              @else
                <span class="text-gray-400">-</span>
              @endif
            </td>
            <td class="px-4 py-2 whitespace-nowrap">
              <div class="flex items-center space-x-2">
                <!-- Show -->
                <a href="{{ route('customer-books.show', $book) }}"
                   class="p-2 bg-green-500 hover:bg-green-600 text-white rounded-full transition"
                   title="Show">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                       viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268
                             2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z" />
                  </svg>
                </a>
                <!-- Proses -->
                @if(auth()->user()->level==='admin' || $isAntre)
                  <a href="{{ route('customer-books.createWithCap', $book) }}"
                     class="p-2 bg-blue-500 hover:bg-blue-600 text-white rounded-full transition"
                     title="Proses">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                         viewBox="0 0 24 24">
                      <path d="M12 22a10 10 0 100-20 10 10 0 000 20zm-1-6l6-4-6-4v8z" />
                    </svg>
                  </a>
                @endif
                <!-- Edit -->
                @if(auth()->user()->level==='admin' || $isProses)
                  <a href="{{ route('customer-books.edit', $book) }}"
                     class="p-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-full transition"
                     title="Edit">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002
                               2h11a2 2 0 002-2v-5m-1.414-9.414a2.121
                               2.121 0 113 3L12 15l-4 1 1-4
                               9.586-9.586z" />
                    </svg>
                  </a>
                @endif
                <!-- Delete -->
                @if(auth()->user()->level==='admin' || $isAntre)
                  <form action="{{ route('customer-books.destroy', $book) }}" method="POST"
                        onsubmit="return confirm('Are you sure?');">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="p-2 bg-red-500 hover:bg-red-600 text-white rounded-full transition"
                            title="Delete">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                           viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 7l-.867 12.142A2 2 0 0116.138
                                 21H7.862a2 2 0 01-1.995-1.858L5
                                 7m5 4v6m4-6v6m1-10V4a1 1 0
                                 00-1-1h-4a1 1 0 00-1 1v3M4
                                 7h16" />
                      </svg>
                    </button>
                  </form>
                @endif
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="11" class="py-6 text-center text-gray-500">
              Tidak ada data ditemukan.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <div class="mt-6 flex justify-center">
    {{ $books->appends(request()->query())->links() }}
  </div>
</div>

{{-- JS Formatter --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.rupiah').forEach(el => {
    const raw = parseFloat(el.dataset.price) || 0;
    el.textContent = new Intl.NumberFormat('id-ID', {
      style: 'currency', currency: 'IDR', minimumFractionDigits: 0
    }).format(raw).replace('Rp', 'Rp ');
  });
});
</script>
@endsection