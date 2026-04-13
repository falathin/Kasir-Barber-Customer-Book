@extends('layouts.app')

@section('title', 'Tambah Data Customer Book')

@section('content')
    <div class="min-h-screen py-10 px-4 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-lg mx-auto">
            <div class="rounded-2xl overflow-hidden shadow-2xl">
                <div class="flex h-1">
                    <div class="w-1/3 bg-red-600"></div>
                    <div class="w-1/3 bg-white"></div>
                    <div class="w-1/3 bg-blue-600"></div>
                </div>

                <div class="bg-white p-6 sm:p-8 lg:p-10">
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-800 mb-4 text-center">
                        Tambah Data Customer Book
                    </h2>
                    <br>
                    <form action="{{ route('customer-books.store') }}" method="POST" class="space-y-5">
                        @csrf

                        <label class="block">
                            <span class="inline-flex items-center gap-2 text-gray-700">
                                <span class="text-indigo-600 font-mono">»</span>
                                <span class="font-medium">Pelanggan</span>
                            </span>
                            <input type="text" name="customer" value="{{ old('customer') }}"
                                placeholder="Contoh: Jane Doe"
                                class="w-full mt-2 px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-300 transition"
                                required>
                            @error('customer')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </label>

                        <label class="block">
                            <span class="inline-flex items-center gap-2 text-gray-700">
                                <span class="text-indigo-600 font-mono">»</span>
                                <span class="font-medium">Nomor Antrian</span>
                            </span>

                            <input type="number" name="antrian" value="{{ old('antrian', $nextAntrian) }}" min="1"
                                @if (auth()->user()->level !== 'admin') readonly @endif
                                class="w-full mt-2 px-4 py-2 border rounded-xl
                                focus:outline-none focus:ring-2 focus:ring-indigo-300 transition
                                @if (auth()->user()->level !== 'admin') bg-gray-50 cursor-not-allowed @endif"
                                required>

                            @if (auth()->user()->level === 'kasir')
                                <p class="text-xs text-gray-500 mt-1">
                                    Nomor antrian diatur otomatis oleh sistem
                                </p>
                            @elseif(auth()->user()->level !== 'admin')
                                <p class="text-xs text-gray-500 mt-1">
                                    Nomor antrian tidak dapat diubah
                                </p>
                            @endif

                            @error('antrian')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </label>

                        <label class="block">
                            <span class="inline-flex items-center gap-2 text-gray-700">
                                <span class="text-indigo-600 font-mono">»</span>
                                <span class="font-medium">Jenis Potong Rambut</span>
                            </span>
                            <select name="haircut_type"
                                class="w-full mt-2 px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-300 transition"
                                required>
                                <option value="" disabled {{ old('haircut_type') ? '' : 'selected' }}>
                                    -- Pilih Jenis --
                                </option>
                                <option value="Gentle" {{ old('haircut_type') === 'Gentle' ? 'selected' : '' }}>
                                    Gentle
                                </option>
                                <option value="Ladies" {{ old('haircut_type') === 'Ladies' ? 'selected' : '' }}>
                                    Ladies
                                </option>
                            </select>

                            @error('haircut_type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </label>

                        <label class="block">
                            <span class="inline-flex items-center gap-2 text-gray-700">
                                <span class="text-indigo-600 font-mono">»</span>
                                <span class="font-medium">Nama Barber</span>
                            </span>

                            @if (auth()->user()->level === 'admin')
                                <select name="barber_name"
                                    class="w-full mt-2 px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-300 transition"
                                    required>
                                    <option value="">-- Pilih Nama Barber --</option>

                                    @forelse ($filtering as $capster)
                                        <option value="{{ $capster->name }}"
                                            {{ old('barber_name') === $capster->name ? 'selected' : '' }}>
                                            {{ $capster->name }}
                                        </option>
                                    @empty
                                        <option value="" disabled>-- Belum ada barber/kasir terdaftar --</option>
                                    @endforelse
                                </select>
                            @else
                                <input type="text" value="{{ auth()->user()->name }}"
                                    class="w-full mt-2 px-4 py-2 border rounded-xl bg-gray-50 cursor-not-allowed" disabled>
                                <input type="hidden" name="barber_name" value="{{ auth()->user()->name }}">
                            @endif

                            @error('barber_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </label>

                        <div>
                            <label class="inline-flex items-center gap-2 text-sm font-medium text-gray-700 mb-1">
                                <span class="text-indigo-600 font-mono">»</span>
                                <span>Waktu</span>
                            </label>

                            @if (auth()->user()->level === 'admin')
                                <input type="datetime-local" name="created_time" id="created_time"
                                    value="{{ old('created_time') }}"
                                    class="w-full mt-2 px-4 py-2 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300 transition"
                                    required>
                            @else
                                <input type="datetime-local" id="created_time"
                                    class="w-full mt-2 px-4 py-2 border rounded-xl text-sm bg-gray-50 text-gray-600 cursor-not-allowed"
                                    disabled>
                            @endif
                        </div>

                        <div>
                            <button type="submit"
                                class="w-full py-3 rounded-xl bg-gradient-to-r from-indigo-600 to-pink-500 text-white font-semibold shadow-md hover:from-indigo-700 hover:to-pink-600 transition">
                                Simpan Data »
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('created_time');
            if (!input) return;

            if (!input.value) {
                const now = new Date();
                const offset = now.getTimezoneOffset();
                const local = new Date(now.getTime() - offset * 60000);
                input.value = local.toISOString().slice(0, 16);
            }
        });
    </script>
@endsection