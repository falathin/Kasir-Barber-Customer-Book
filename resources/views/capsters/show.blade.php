@extends('layouts.app')

@section('title', 'Detail Capster')

@section('content')
<div class="max-w-md mx-auto py-8">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-6 text-center">Kartu Capster</h1>

    <div class="bg-white border border-gray-200 rounded-2xl shadow-md p-6 space-y-6">
        <div class="grid grid-cols-1 gap-4">
            <div>
                <label class="block text-xs font-medium text-gray-500 uppercase">Nama</label>
                <p class="mt-1 text-lg font-semibold text-gray-700">{{ $capster->nama }}</p>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 uppercase">Inisial</label>
                <p class="mt-1 text-lg font-semibold text-gray-700">{{ $capster->inisial }}</p>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 uppercase">Jenis Kelamin</label>
                <p class="mt-1 text-lg font-semibold text-gray-700">
                    {{ $capster->jenis_kelamin == 'L' ? 'Laki‑laki' : 'Perempuan' }}
                </p>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 uppercase">No. HP</label>
                @php
                    $hp = preg_replace('/\D/', '', $capster->no_hp);
                    if(strlen($hp) === 12) {
                        $formatted = substr($hp, 0, 4).'-'.substr($hp,4,4).'-'.substr($hp,8);
                    } else {
                        $formatted = $capster->no_hp;
                    }
                @endphp
                <p class="mt-1 text-lg font-semibold text-gray-700">{{ $formatted }}</p>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 uppercase">Tanggal Lahir</label>
                <p class="mt-1 text-lg font-semibold text-gray-700">{{ $capster->tgl_lahir->format('d-m-Y') }}</p>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 uppercase">Asal</label>
                <p class="mt-1 text-lg font-semibold text-gray-700">{{ $capster->asal }}</p>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-500 uppercase">Foto</label>
                <img src="{{ $capster->foto_url }}" alt="Foto Capster" class="mt-2 w-24 h-24 object-cover rounded-full">
            </div>
        </div>

        <div class="pt-4 border-t border-gray-100 flex justify-end space-x-4">
            <a href="{{ route('capsters.index') }}"
               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                Kembali
            </a>
            <a href="{{ route('capsters.edit', $capster) }}"
               class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                Edit
            </a>
        </div>
    </div>
</div>
@endsection