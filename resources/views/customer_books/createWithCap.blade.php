@extends('layouts.app')

@section('title', 'Proses Capster')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
  <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
    <div class="p-6">
      <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">
        Proses Capster untuk #{{ $book->id }}
      </h2>

      <form action="{{ route('customer-books.storeWithCap', $book) }}" method="POST" class="space-y-5">
        @csrf

        {{-- Capster --}}
        <label class="block">
          <span class="text-gray-700">✂️ Pilih Capster</span>
          <select name="cap"
              class="w-full mt-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
            <option value="">— None —</option>
            @foreach($capsters as $capster)
              <option value="{{ $capster->inisial }}"
                  {{ old('cap', $book->cap) === $capster->inisial ? 'selected' : '' }}>
                {{ $capster->inisial }} – {{ $capster->nama }}
              </option>
            @endforeach
          </select>
          @error('cap')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </label>

        <button type="submit"
            class="w-full py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
          Simpan Proses
        </button>
      </form>
    </div>
  </div>
</div>
@endsection