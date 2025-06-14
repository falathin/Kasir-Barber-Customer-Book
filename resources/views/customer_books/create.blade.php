@extends('layouts.app')

@section('title', 'Create Customer Book')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Create Customer Book</h2>
                <form action="{{ route('customer-books.store') }}" method="POST" class="space-y-5" id="customer-book-form">
                    @csrf

                    <label class="block">
                        <span class="text-gray-700">👤 Customer</span>
                        <div class="relative mt-1">
                            <input type="text" name="customer" value="{{ old('customer') }}" placeholder="e.g. Jane Doe"
                                class="w-full pl-3 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                required>
                        </div>
                        @error('customer')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="block">
                        <span class="text-gray-700">✂️ Capster</span>
                        <div class="relative mt-1">
                            <input type="text" name="cap" value="{{ old('cap') }}" placeholder="e.g. Capster A"
                                class="w-full pl-3 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                required>
                        </div>
                        @error('cap')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="block">
                        <span class="text-gray-700">💇‍♀️ Haircut Type</span>
                        <div class="relative mt-1">
                            <select name="haircut_type"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                required>
                                <option value="" disabled {{ old('haircut_type') ? '' : 'selected' }}>-- Select Type
                                    --</option>
                                <option value="Gentle" {{ old('haircut_type') == 'Gentle' ? 'selected' : '' }}>Gentle
                                </option>
                                <option value="Ladies" {{ old('haircut_type') == 'Ladies' ? 'selected' : '' }}>Ladies
                                </option>
                            </select>
                        </div>
                        @error('haircut_type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="block">
                        <span class="text-gray-700">🎨 Colouring Other</span>
                        <textarea name="colouring_other" placeholder="e.g. Pastel pink highlights"
                            class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            rows="3">{{ old('colouring_other') }}</textarea>
                    </label>

                    <label class="block">
                        <span class="text-gray-700">🧴 Sell/Use Product</span>
                        <textarea name="sell_use_product" placeholder="e.g. Shampoo X, Conditioner Y"
                            class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            rows="3">{{ old('sell_use_product') }}</textarea>
                    </label>

                    <label class="block">
                        <span class="text-gray-700">💰 Price</span>
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">Rp</div>
                            <input type="text" name="price" id="price" inputmode="numeric"
                                value="{{ old('price') }}" placeholder="e.g. 150000"
                                class="w-full pl-12 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                required>
                        </div>
                        @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="block">
                        <span class="text-gray-700">💳 Payment Method</span>
                        <div class="relative mt-1">
                            <select name="qr"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="cash" {{ old('qr') == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="qr_transfer" {{ old('qr') == 'qr_transfer' ? 'selected' : '' }}>QR Transfer
                                </option>
                            </select>
                        </div>
                    </label>

                    <label class="block">
                        <span class="text-gray-700">💈 Barber Name</span>
                        <div class="relative mt-1">
                            <input type="text" name="barber_name" value="{{ old('barber_name') }}"
                                placeholder="e.g. BBmen’s Haircut 1"
                                class="w-full pl-3 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                required>
                        </div>
                        @error('barber_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </label>

                    <button type="submit"
                        class="w-full py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Save</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const priceInput = document.getElementById('price');

            function formatNumber(n) {
                return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            function plainNumber(n) {
                return n.replace(/\./g, '');
            }

            if (priceInput) {
                if (priceInput.value) {
                    priceInput.dataset.raw = priceInput.value;
                    priceInput.value = formatNumber(priceInput.value);
                }

                priceInput.addEventListener('input', function(e) {
                    const raw = plainNumber(e.target.value.replace(/\D/g, ''));
                    e.target.dataset.raw = raw;
                    e.target.value = formatNumber(raw);
                });

                priceInput.closest('form').addEventListener('submit', function() {
                    priceInput.value = priceInput.dataset.raw || '';
                });
            }
        });
    </script>
@endsection
