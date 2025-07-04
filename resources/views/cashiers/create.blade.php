<!-- resources/views/kasirs/create.blade.php -->
@extends('layouts.app')

@section('title', 'Add Cashier')

@section('content')
<div class="max-w-2xl mx-auto mt-10 p-8 bg-white rounded-2xl shadow-lg animate__animated animate__fadeInUp">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">➕ Add New Cashier</h2>
    <form method="POST" action="{{ route('kasirs.store') }}" class="space-y-6">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
            <input type="text" id="name" name="name" required
                class="mt-1 w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-300 transition @error('name') border-red-500 focus:ring-red-300 @enderror" />
            @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
            <input type="email" id="email" name="email" required
                class="mt-1 w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-300 transition @error('email') border-red-500 focus:ring-red-300 @enderror" />
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" id="password" name="password" required
                class="mt-1 w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-300 transition @error('password') border-red-500 focus:ring-red-300 @enderror" />
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required
                class="mt-1 w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-300 transition @error('password_confirmation') border-red-500 focus:ring-red-300 @enderror" />
            @error('password_confirmation')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-center space-x-4">
            <button type="submit"
                class="px-6 py-2 bg-yellow-400 text-white font-semibold rounded-2xl shadow hover:bg-yellow-500 transition">Save</button>
            <a href="{{ route('kasirs.index') }}"
                class="px-6 py-2 bg-gray-200 text-gray-700 font-semibold rounded-2xl shadow hover:bg-gray-300 transition">Cancel</a>
        </div>
    </form>
</div>

@endsection