@extends('layouts.app')

@section('title', 'Capsters')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
  {{-- Header --}}
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-4 sm:mb-0">✂️ Capsters</h1>
    <a href="{{ route('capsters.create') }}"
       class="inline-flex items-center px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-full shadow-lg transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
           viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
      </svg>
      Create Capster
    </a>
  </div>

  {{-- Search & Filters --}}
  <form method="GET" action="{{ route('capsters.index') }}"
        class="flex flex-col sm:flex-row items-center gap-4 mb-8">
    <input type="text" name="search" placeholder="Search Capsters..."
           value="{{ request('search') }}"
           class="flex-1 px-4 py-2 border border-gray-300 rounded-full shadow-sm
                  focus:outline-none focus:ring-2 focus:ring-indigo-500">
    <button type="submit"
            class="px-6 py-2 bg-indigo-600 text-white rounded-full shadow hover:bg-indigo-700 transition">
      🔍 Search
    </button>
    @if(request('search'))
      <a href="{{ route('capsters.index') }}"
         class="px-6 py-2 bg-gray-200 text-gray-700 rounded-full shadow hover:bg-gray-300 transition">
        Clear
      </a>
    @endif
  </form>

  <!-- DESKTOP TABLE VIEW -->
  <div class="hidden md:block overflow-x-auto bg-white shadow-lg rounded-xl">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          @foreach(['#','Foto','Nama','Inisial','Gender','No. HP','Asal','Status','Aksi'] as $col)
            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
              {{ $col }}
            </th>
          @endforeach
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-100">
        @forelse($capsters as $capster)
          <tr class="hover:bg-gray-50 transition-colors">
            <td class="px-4 py-3 text-gray-700">{{ $loop->iteration + ($capsters->currentPage()-1)*$capsters->perPage() }}</td>
            <td class="px-4 py-3">
              <img src="{{ $capster->foto_url }}" alt="" class="w-10 h-10 rounded-full object-cover border-2 border-indigo-100">
            </td>
            <td class="px-4 py-3 font-medium text-gray-800">{{ $capster->nama }}</td>
            <td class="px-4 py-3 text-gray-700">{{ $capster->inisial }}</td>
            <td class="px-4 py-3 text-gray-700">{{ $capster->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            <td class="px-4 py-3 text-gray-700">{{ $capster->no_hp }}</td>
            <td class="px-4 py-3 text-gray-700">{{ $capster->asal }}</td>
            <td class="px-4 py-3">
              @if(strtolower($capster->status)==='aktif')
                <span class="px-3 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">Aktif</span>
              @else
                <span class="px-3 py-1 text-xs font-semibold bg-red-100 text-red-700 rounded-full">Sudah Keluar</span>
              @endif
            </td>
            <td class="px-4 py-3">
              <div class="flex items-center space-x-2">
                <!-- Eye icon -->
                <a href="{{ route('capsters.show', $capster) }}"
                  class="p-2 bg-blue-500 hover:bg-blue-600 text-white rounded-full transition" title="Lihat">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                      viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268
                            2.943 9.542 7c-1.274 4.057-5.065 7-9.542
                            7s-8.268-2.943-9.542-7z" />
                  </svg>
                </a>

                <!-- Pencil icon -->
                <a href="{{ route('capsters.edit', $capster) }}"
                  class="p-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-full transition" title="Edit">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                      viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0
                            002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121
                            2.121 0 113 3L12 15l-4 1 1-4
                            9.5-9.5z" />
                  </svg>
                </a>

                <!-- Trash icon -->
                <form action="{{ route('capsters.destroy', $capster) }}" method="POST"
                      onsubmit="return confirm('Yakin ingin dihapus?')">
                  @csrf @method('DELETE')
                  <button type="submit"
                          class="p-2 bg-red-500 hover:bg-red-600 text-white rounded-full transition" title="Hapus">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="9" class="py-6 text-center text-gray-500">No capsters found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="md:hidden space-y-4">
    @forelse($capsters as $capster)
      <div class="bg-gradient-to-tr from-pink-50 via-white to-blue-50 rounded-2xl shadow-lg p-4 border border-pink-100 hover:shadow-xl transition">
        <div class="flex justify-between items-center">
          <div class="flex items-center space-x-3">
            <img src="{{ $capster->foto_url }}" alt="" class="w-12 h-12 rounded-full border-2 border-pink-200 shadow">
            <div>
              <h3 class="text-base font-semibold text-pink-700">{{ $capster->nama }}</h3>
              <p class="text-sm text-gray-500">{{ $capster->inisial ?? '-' }}</p>
            </div>
          </div>
          @if(strtolower($capster->status)==='aktif')
            <span class="px-3 py-1 text-xs font-semibold bg-green-500 text-white rounded-full">Aktif</span>
          @else
            <span class="px-3 py-1 text-xs font-semibold bg-red-500 text-white rounded-full">Keluar</span>
          @endif
        </div>

        <div class="mt-3 text-sm text-gray-700 space-y-1">
          <p><b class="text-purple-600">Gender:</b> {{ $capster->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
          <p><b class="text-blue-600">No. HP:</b> {{ $capster->no_hp ?? '-' }}</p>
          <p><b class="text-pink-600">Asal:</b> {{ $capster->asal ?? '-' }}</p>
        </div>

        <div class="flex items-center space-x-2 mt-4">
          <a href="{{ route('capsters.show', $capster) }}"
            class="p-2 bg-blue-500 hover:bg-blue-600 text-white rounded-full transition" title="Detail">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268
                      2.943 9.542 7c-1.274 4.057-5.065 7-9.542
                      7s-8.268-2.943-9.542-7z" />
            </svg>
          </a>

          <a href="{{ route('capsters.edit', $capster) }}"
            class="p-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-full transition" title="Edit">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0
                      002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121
                      2.121 0 113 3L12 15l-4 1 1-4
                      9.5-9.5z" />
            </svg>
          </a>

          <form action="{{ route('capsters.destroy', $capster) }}" method="POST"
                onsubmit="return confirm('Yakin ingin dihapus?');">
            @csrf @method('DELETE')
            <button type="submit"
                    class="p-2 bg-red-500 hover:bg-red-600 text-white rounded-full transition" title="Hapus">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </form>
        </div>
      </div>
    @empty
      <div class="text-center text-gray-500 py-6">No capsters found.</div>
    @endforelse
  </div>

  {{-- Pagination --}}
  <div class="mt-6 flex justify-center">
    {{ $capsters->appends(request()->query())->links() }}
  </div>
</div>
@endsection