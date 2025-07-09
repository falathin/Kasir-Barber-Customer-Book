@extends('layouts.app')

@section('title', 'Detail Capster')

@section('content')
    @php
        // Format nomor HP
        $hp = preg_replace('/\D/', '', $capster->no_hp);
        $formatted = strlen($hp) === 12
            ? substr($hp, 0, 4) . '-' . substr($hp, 4, 4) . '-' . substr($hp, 8)
            : $capster->no_hp;

        // Format nomor HP keluarga
        $hpFam = preg_replace('/\D/', '', $capster->no_hp_keluarga ?? '');
        $formattedFam = $capster->no_hp_keluarga
            ? (strlen($hpFam) === 12
                ? substr($hpFam, 0, 4) . '-' . substr($hpFam, 4, 4) . '-' . substr($hpFam, 8)
                : $capster->no_hp_keluarga)
            : '-';
    @endphp

    <div class="flex justify-center py-12 bg-gray-100">
        <div class="max-w-sm w-full">

            {{-- Card Container --}}
            <div class="bg-white shadow-2xl rounded-2xl overflow-hidden border-t-4 border-indigo-600">
                {{-- Header --}}
                <div class="bg-indigo-600 text-white px-6 py-4 flex items-center">
                    <img src="{{ asset('images/bb-logo.png') }}"
                         alt="Logo BB"
                         class="h-10 w-10 object-contain mr-3">
                    <div>
                        <h1 class="text-2xl font-extrabold">Capster ID Card</h1>
                        <p class="text-sm opacity-75">Barbershop</p>
                    </div>
                </div>

                {{-- Profile & Info --}}
                <div class="px-6 py-8">
                    <div class="flex justify-center -mt-20">
                        <img id="capsterPhoto"
                             src="{{ $capster->foto_url }}"
                             alt="Foto Capster"
                             class="h-32 w-32 object-cover rounded-full border-4 border-white shadow-lg cursor-pointer hover:opacity-90 transition">
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-y-4 gap-x-6 text-gray-700">
                        <div>
                            <span class="block text-xs uppercase opacity-70">Nama</span>
                            <span class="block font-semibold">{{ $capster->nama }}</span>
                        </div>
                        <div>
                            <span class="block text-xs uppercase opacity-70">Inisial</span>
                            <span class="block font-semibold">{{ $capster->inisial }}</span>
                        </div>
                        <div>
                            <span class="block text-xs uppercase opacity-70">Jenis Kelamin</span>
                            <span class="block font-semibold">
                                {{ $capster->jenis_kelamin === 'L' ? 'Laki‑laki' : 'Perempuan' }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-xs uppercase opacity-70">TTL</span>
                            <span class="block font-semibold">{{ $capster->tgl_lahir->format('d M Y') }}</span>
                        </div>

                        {{-- Asal / Alamat --}}
                        <div class="col-span-2">
                            <label class="block text-xs uppercase opacity-70 mb-1">Asal / Alamat</label>
                            <textarea
                                readonly
                                rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-sm resize-none"
                            >{{ $capster->asal }}</textarea>
                        </div>

                        <div>
                            <span class="block text-xs uppercase opacity-70">No. HP</span>
                            <span class="block font-semibold">{{ $formatted }}</span>
                        </div>
                        <div>
                            <span class="block text-xs uppercase opacity-70">HP Keluarga</span>
                            <span class="block font-semibold">{{ $formattedFam }}</span>
                        </div>
                    </div>

                    {{-- Status Badge --}}
                    <div class="mt-6 text-center">
                        <span class="inline-block px-4 py-1 text-sm font-semibold rounded-full
                            {{ strtolower($capster->status) === 'aktif'
                                ? 'bg-green-100 text-green-800'
                                : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($capster->status) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="mt-8 flex space-x-4">
                <a href="{{ route('capsters.index') }}"
                   class="flex-1 inline-block text-center py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition font-medium">
                    ← Kembali
                </a>
                <a href="{{ route('capsters.edit', $capster) }}"
                   class="flex-1 inline-block text-center py-2 bg-indigo-600 rounded-lg hover:bg-indigo-700 transition text-white font-medium">
                    Edit
                </a>
            </div>
        </div>
    </div>

    {{-- Modal Foto --}}
    <div id="modalBackdrop"
         class="hidden fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full mx-4">
            <div class="flex justify-end p-3">
                <button id="closeModalBtn"
                        class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            </div>
            <div class="p-4">
                <img src="{{ $capster->foto_url }}"
                     alt="Foto Capster Detail"
                     class="w-full h-auto object-contain rounded-lg">
            </div>
        </div>
    </div>

    {{-- Modal Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('modalBackdrop');
            const img   = document.getElementById('capsterPhoto');
            const close = document.getElementById('closeModalBtn');

            img.addEventListener('click', () => modal.classList.remove('hidden'));
            close.addEventListener('click', () => modal.classList.add('hidden'));
            modal.addEventListener('click', e => {
                if (e.target === modal) modal.classList.add('hidden');
            });
        });
    </script>
@endsection