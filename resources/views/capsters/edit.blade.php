@extends('layouts.app')

@section('title', 'Edit Capster')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-8 text-center">Edit Capster</h1>

    <div class="bg-white border border-gray-200 rounded-2xl shadow-xl p-8">
        <form action="{{ route('capsters.update', $capster) }}" method="POST" enctype="multipart/form-data" novalidate class="space-y-6">
            @csrf
            @method('PUT')

            @include('capsters._form')

            <div class="flex justify-end gap-4 pt-6 border-t border-gray-100">
                <a href="{{ route('capsters.index') }}"
                   class="px-5 py-2 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-100 transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:ring-2 focus:ring-green-400 transition">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
