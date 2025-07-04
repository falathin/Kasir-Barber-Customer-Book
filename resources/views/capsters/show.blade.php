@extends('layouts.app')

@section('title', 'Detail Capster')

@section('content')
<div class="max-w-xl mx-auto py-8">
    <h1 class="text-2xl font-bold text-center text-gray-700 mb-6">Kartu Karyawan Capster</h1>

    <div class="bg-white border border-gray-300 rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-blue-600 text-white px-6 py-4 text-center">
            <h2 class="text-lg font-bold tracking-wide">BARBERSHOP</h2>
            <p class="text-sm">Kartu Identitas Capster</p>
        </div>

        <div class="p-6 flex flex-col sm:flex-row sm:items-center sm:space-x-6">
            <!-- Foto -->
            <div class="flex-shrink-0 mb-4 sm:mb-0">
                <img id="capsterPhoto"
                     src="{{ $capster->foto_url }}"
                     alt="Foto Capster"
                     class="w-32 h-32 object-cover rounded-xl shadow-md cursor-pointer hover:opacity-90 transition" />
            </div>

            <!-- Detail -->
            <div class="flex-1 space-y-3">
                <div>
                    <label class="block text-xs text-gray-500 uppercase">Nama</label>
                    <p class="text-base font-semibold text-gray-800">{{ $capster->nama }}</p>
                </div>
                <div>
                    <label class="block text-xs text-gray-500 uppercase">Inisial</label>
                    <p class="text-base font-semibold text-gray-800">{{ $capster->inisial }}</p>
                </div>
                <div>
                    <label class="block text-xs text-gray-500 uppercase">Jenis Kelamin</label>
                    <p class="text-base font-semibold text-gray-800">{{ $capster->jenis_kelamin == 'L' ? 'Laki‑laki' : 'Perempuan' }}</p>
                </div>
                <div>
                    <label class="block text-xs text-gray-500 uppercase">No. HP</label>
                    @php
                        $hp = preg_replace('/\D/', '', $capster->no_hp);
                        $formatted = strlen($hp) === 12 ? substr($hp, 0, 4).'-'.substr($hp,4,4).'-'.substr($hp,8) : $capster->no_hp;
                    @endphp
                    <p class="text-base font-semibold text-gray-800">{{ $formatted }}</p>
                </div>
                <div>
                    <label class="block text-xs text-gray-500 uppercase">Tanggal Lahir</label>
                    <p class="text-base font-semibold text-gray-800">{{ $capster->tgl_lahir->format('d-m-Y') }}</p>
                </div>
                <div>
                    <label class="block text-xs text-gray-500 uppercase">Asal</label>
                    <p class="text-base font-semibold text-gray-800">{{ $capster->asal }}</p>
                </div>
            </div>
        </div>

        <div class="flex justify-between items-center border-t border-gray-200 px-6 py-4 bg-gray-50">
            <a href="{{ route('capsters.index') }}" class="text-sm text-gray-600 hover:text-gray-800 transition">← Kembali</a>
            <a href="{{ route('capsters.edit', $capster) }}" class="text-sm px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">Edit</a>
        </div>
    </div>
</div>

<!-- Native Modal -->
<div id="modalBackdrop" class="hidden fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50">
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden max-w-xl w-full mx-4 relative">
        <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Foto Capster</h2>
            <button id="closeModalBtn" class="text-gray-500 hover:text-gray-700 text-2xl leading-none">&times;</button>
        </div>
        <div class="p-6 bg-gray-50">
            <img src="{{ $capster->foto_url }}" alt="Foto Capster Detail" class="w-full h-auto object-contain rounded-lg">
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('modalBackdrop');
        const openBtn = document.getElementById('capsterPhoto');
        const closeBtn = document.getElementById('closeModalBtn');

        openBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });

        closeBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
        });

        // Tutup modal saat klik di luar konten modal
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
            }
        });
    });
</script>
@endsection
