@extends('layouts.app')

@section('title', 'Proses Capster')

@section('content')
  {{-- ===================== CONTAINER UTAMA (background & center) ===================== --}}
  <div class="min-h-screen py-10 px-4 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-lg mx-auto">

      {{-- ===================== CARD (stripe + card body) ===================== --}}
      <div class="rounded-2xl overflow-hidden shadow-2xl">

        {{-- Barber stripe (merah-putih-biru) --}}
        <div class="flex h-1">
          <div class="w-1/3 bg-red-600"></div>
          <div class="w-1/3 bg-white"></div>
          <div class="w-1/3 bg-blue-600"></div>
        </div>

        {{-- Card body --}}
        <div class="bg-white p-6 sm:p-8 lg:p-10">
          {{-- Judul --}}
          <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-800 mb-2 text-center">
            Proses Capster untuk #{{ $book->id }}
          </h2>

          {{-- Subjudul / info --}}
          <p class="text-sm text-gray-500 text-center mb-6">
            Pilih capster yang akan memproses antrian ini — desain konsisten dengan halaman lain.
          </p>

          {{-- ===================== FORM PILIH CAPSTER ===================== --}}
          <form action="{{ route('customer-books.storeWithCap', $book) }}" method="POST" class="space-y-5">
            @csrf

            {{-- Capster --}}
            <label class="block">
              <span class="inline-flex items-center gap-2 text-gray-700">
                <span class="text-indigo-600 font-mono">»</span>
                <span class="font-medium">Pilih Capster</span>
              </span>

              <select
                name="cap"
                class="w-full mt-2 px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-300 transition"
                aria-label="Pilih Capster"
              >
                <option value="">— None —</option>

                @foreach($capsters as $capster)
                  <option value="{{ $capster->inisial }}"
                    {{ (string) old('cap', $book->cap) === (string) $capster->inisial ? 'selected' : '' }}>
                    {{ $capster->inisial }} – {{ $capster->nama }}
                  </option>
                @endforeach
              </select>

              @error('cap')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </label>

            {{-- Button submit --}}
            <div>
              <button
                type="submit"
                class="w-full py-3 rounded-xl bg-gradient-to-r from-indigo-600 to-pink-500 text-white font-semibold shadow-md hover:from-indigo-700 hover:to-pink-600 transition"
              >
                Simpan Proses »
              </button>
            </div>
          </form>
          {{-- ===================== END FORM ===================== --}}
        </div>
        {{-- ===================== END CARD BODY ===================== --}}
      </div>
      {{-- ===================== END CARD ===================== --}}
    </div>
  </div>
  {{-- ===================== END CONTAINER ===================== --}}
@endsection
