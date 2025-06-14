@extends('layouts.app')
@section('title', 'Show Customer Book')

@section('content')
    <div class="flex justify-center py-10">
        <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-md border border-gray-300 font-mono">
            <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6 border-b pb-2">💈 Customer Receipt</h2>

            <div class="space-y-3 text-sm text-gray-700">
                <div class="flex justify-between">
                    <span class="font-semibold">💳 Booking ID</span>
                    <span>{{ $customerBook->id }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-semibold">🧑‍🦱 Customer</span>
                    <span>{{ $customerBook->customer }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-semibold">💇‍♂️ Capster</span>
                    <span>{{ $customerBook->cap }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-semibold">✂️ Haircut Style</span>
                    <span>{{ $customerBook->haircut_type }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-semibold">🏠 Barber Shop</span>
                    <span>{{ $customerBook->barber_name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-semibold">🌈 Colouring</span>
                    <span>{{ $customerBook->colouring_other ?: '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-semibold">🧴 Hair Product</span>
                    <span>{{ $customerBook->sell_use_product ?: '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-semibold">💸 Total Price</span>
                    <span>Rp {{ number_format($customerBook->price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-semibold">💵 Payment Method</span>
                    <span>{{ $customerBook->qr === 'qr_transfer' ? 'QR Transfer' : 'Cash' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-semibold">📅 Date</span>
                    <span>{{ $customerBook->created_at->format('d M Y, H:i') }}</span>
                </div>
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('customer-books.index') }}"
                    class="inline-block px-4 py-2 bg-gray-700 hover:bg-gray-800 text-white rounded-lg transition">
                    ← Back to List
                </a>
            </div>
        </div>
    </div>
@endsection
