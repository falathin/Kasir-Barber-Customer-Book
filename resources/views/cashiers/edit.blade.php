
<!-- resources/views/kasirs/edit.blade.php -->
@extends('layouts.app')

@section('title', 'Edit Cashier')

@section('content')
<div class="max-w-2xl mx-auto mt-10 p-8 bg-white rounded-2xl shadow-lg animate__animated animate__fadeInUp">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">✏️ Edit Cashier</h2>
    <form method="POST" action="{{ route('kasirs.update', $kasir) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
            <input type="text" id="name" name="name" value="{{ $kasir->name }}" required
                class="mt-1 w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-300 transition" />
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
            <input type="email" id="email" name="email" value="{{ $kasir->email }}" required
                class="mt-1 w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-300 transition" />
        </div>

        <div class="flex justify-center space-x-4">
            <button type="submit"
                class="px-6 py-2 bg-yellow-400 text-white font-semibold rounded-2xl shadow hover:bg-yellow-500 transition">Update</button>
            <a href="{{ route('kasirs.index') }}"
                class="px-6 py-2 bg-gray-200 text-gray-700 font-semibold rounded-2xl shadow hover:bg-gray-300 transition">Cancel</a>
        </div>
    </form>
</div>
