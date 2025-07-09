@extends('layouts.app')

@section('title', 'Detail Capster')

@section('content')
    @php
        // Format nomor HP
        $hp = preg_replace('/\D/', '', $capster->no_hp);
        $formatted = strlen($hp) === 12
            ? substr($hp, 0, 4) . '-' . substr($hp, 4, 4) . '-' . substr($hp, 8)
            : $capster->no_hp;
    @endphp

    <div class="flex justify-center py-12 bg-gray-100">
        <div class="w-full max-w-md">

            {{-- Kartu Capster --}}
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-2 border-blue-600">
                {{-- Header --}}
                <div class="flex items-center bg-blue-600 p-4">
                    <img src="{{ asset('images/bb-logo.png') }}" alt="Logo BB" class="h-12 w-12 object-contain mr-3">
                    <div>
                        <h2 class="text-xl font-bold text-white tracking-wide">BARBERSHOP</h2>
                        <p class="text-sm text-blue-200">Kartu Identitas Capster</p>
                    </div>
                </div>

                {{-- Body --}}
                <div class="p-6 flex flex-col sm:flex-row sm:space-x-6 bg-gradient-to-br from-white via-blue-50 to-white">
                    {{-- Foto --}}
                    <img id="capsterPhoto"
                         src="{{ $capster->foto_url }}"
                         alt="Foto Capster"
                         class="mx-auto sm:mx-0 h-32 w-32 object-cover rounded-xl shadow-lg cursor-pointer hover:opacity-90 transition">

                    {{-- Info --}}
                    <div class="mt-4 sm:mt-0 space-y-2 flex-1 text-gray-800">
                        @foreach ([
                            'Nama' => $capster->nama,
                            'Inisial' => $capster->inisial,
                            'Jenis Kelamin' => $capster->jenis_kelamin == 'L' ? 'Laki‑laki' : 'Perempuan',
                            'No. HP' => $formatted,
                            'TTL' => $capster->tgl_lahir->format('d-m-Y'),
                            'Asal' => $capster->asal,
                        ] as $label => $value)
                            <div class="flex justify-between">
                                <span class="text-xs font-medium text-gray-500 uppercase">{{ $label }}</span>
                                <span class="text-sm font-semibold">{{ $value }}</span>
                            </div>
                        @endforeach

                        {{-- Status dengan warna dinamis --}}
                        <div class="flex justify-between">
                            <span class="text-xs font-medium text-gray-500 uppercase">Status</span>
                            <span class="text-sm font-semibold 
                                {{ strtolower($capster->status) === 'aktif' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $capster->status }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Aksi --}}
            <div class="mt-6 flex justify-between space-x-2">
                <a href="{{ route('capsters.index') }}"
                   class="flex-1 text-center py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition text-gray-700">
                    ← Kembali
                </a>
                <a href="{{ route('capsters.edit', $capster) }}"
                   class="flex-1 text-center py-2 bg-green-600 rounded-lg hover:bg-green-700 transition text-white">
                    Edit
                </a>
            </div>
        </div>
    </div>

    {{-- Modal Foto --}}
    <div id="modalBackdrop" class="hidden fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl overflow-hidden shadow-2xl max-w-lg w-full mx-4">
            <div class="flex justify-end p-2">
                <button id="closeModalBtn" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            </div>
            <div class="p-4">
                <img src="{{ $capster->foto_url }}" alt="Foto Capster Detail"
                     class="w-full h-auto object-contain rounded-lg">
            </div>
        </div>
    </div>

    {{-- Modal Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('modalBackdrop');
            const img = document.getElementById('capsterPhoto');
            const close = document.getElementById('closeModalBtn');

            img.addEventListener('click', () => modal.classList.remove('hidden'));
            close.addEventListener('click', () => modal.classList.add('hidden'));

            modal.addEventListener('click', e => {
                if (e.target === modal) modal.classList.add('hidden');
            });
        });
    </script>
@endsection