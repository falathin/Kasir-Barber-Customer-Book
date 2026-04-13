@extends('layouts.app')

@section('title', 'Export Data Penjualan')

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
                    Export Data Penjualan
                </h2>
                <br>

                <form action="{{ route('sales.export.download') }}" method="GET" class="space-y-5">

                    {{-- Dari tanggal --}}
                    <label class="block">
                        <span class="inline-flex items-center gap-2 text-gray-700">
                            <span class="text-indigo-600 font-mono">»</span>
                            <span class="font-medium">Dari Tanggal</span>
                        </span>

                        <input type="date" name="from"
                            value="{{ old('from', date('Y-m-d')) }}"
                            class="w-full mt-2 px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-300 transition"
                            required>

                        @error('from')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </label>

                    {{-- Sampai tanggal --}}
                    <label class="block">
                        <span class="inline-flex items-center gap-2 text-gray-700">
                            <span class="text-indigo-600 font-mono">»</span>
                            <span class="font-medium">Sampai Tanggal</span>
                        </span>

                        <input type="date" name="to"
                            value="{{ old('to', date('Y-m-d')) }}"
                            class="w-full mt-2 px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-300 transition"
                            required>

                        @error('to')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </label>

                    {{-- Button --}}
                    <div>
                        <button type="submit"
                            class="w-full py-3 rounded-xl bg-gradient-to-r from-green-600 to-emerald-500 text-white font-semibold shadow-md hover:from-green-700 hover:to-emerald-600 transition">
                            Download Excel »
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection