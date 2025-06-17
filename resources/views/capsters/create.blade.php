@extends('layouts.app')

@section('title', 'Tambah Capster')

@section('content')
<div class="max-w-3xl mx-auto py-6">
    <h1 class="text-3xl font-extrabold mb-6 text-gray-800">Tambah Capster Baru</h1>

    <div class="bg-white p-6 rounded-2xl shadow-lg">
        <form action="{{ route('capsters.store') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf

            @include('capsters._form')

            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('capsters.index') }}"
                   class="px-5 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-400 transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection