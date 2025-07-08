@extends('layouts.app')

@section('title', 'Create Customer Book')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Create Customer Book</h2>
                <form action="{{ route('customer-books.store') }}" method="POST" class="space-y-5" id="customer-book-form">
                    @csrf

                    {{-- Customer --}}
                    <label class="block">
                        <span class="text-gray-700">👤 Customer</span>
                        <input type="text" name="customer" value="{{ old('customer') }}" placeholder="e.g. Jane Doe"
                            class="w-full mt-1 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required>
                        @error('customer')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </label>

                    {{-- Antrian --}}
                    <label class="block">
                        <span class="text-gray-700">🪑 Nomor Antrian</span>

                        @if (auth()->user()->level === 'admin')
                            {{-- Input manual jika admin --}}
                            <input type="text" name="antrian" id="antrian_input"
                                value="{{ old('antrian', $customerBook->antrian ?? $nextAntrian) }}"
                                class="w-full mt-1 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                        @else
                            {{-- Tampilkan sebagai disabled dan kirim lewat hidden jika bukan admin --}}
                            <input type="text" id="antrian_display" value="{{ $nextAntrian }}" disabled
                                class="w-full mt-1 px-3 py-2 border rounded-lg bg-gray-100 cursor-not-allowed" />
                            <input type="hidden" name="antrian" id="antrian_input" value="{{ $nextAntrian }}">
                        @endif

                        @error('antrian')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </label>

                    {{-- Asisten --}}
                    {{-- <label class="block mb-4">
                        <span class="text-gray-700">🧍 Asisten</span>
                        <select name="asisten" id="asistenSelect"
                            class="w-full mt-1 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Pilih Asisten (Opsional)</option>
                            @foreach ($capsters as $capster)
                                <option value="{{ $capster->inisial }}"
                                    {{ old('asisten') == $capster->inisial ? 'selected' : '' }}>
                                    {{ $capster->inisial }} - {{ $capster->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('asisten')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </label> --}}
                    
                    {{-- <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const capSelect = document.getElementById('capSelect');
                            const asistenSelect = document.getElementById('asistenSelect');

                            function syncOptions() {
                                const selectedCap = capSelect.value;
                                const selectedAsisten = asistenSelect.value;

                                Array.from(asistenSelect.options).forEach(option => {
                                    if (option.value && option.value === selectedCap) {
                                        option.disabled = true;
                                        option.hidden = true;
                                    } else {
                                        option.disabled = false;
                                        option.hidden = false;
                                    }
                                });

                                Array.from(capSelect.options).forEach(option => {
                                    if (option.value && option.value === selectedAsisten) {
                                        option.disabled = true;
                                        option.hidden = true;
                                    } else {
                                        option.disabled = false;
                                        option.hidden = false;
                                    }
                                });
                            }

                            capSelect.addEventListener('change', syncOptions);
                            asistenSelect.addEventListener('change', syncOptions);

                            // Jalankan saat halaman pertama kali load
                            syncOptions();
                        });
                    </script> --}}

                    {{-- Haircut Type --}}
                    <label class="block">
                        <span class="text-gray-700">💇‍♀️ Haircut Type</span>
                        <select name="haircut_type"
                            class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required>
                            <option value="" disabled {{ old('haircut_type') ? '' : 'selected' }}>-- Select Type --
                            </option>
                            <option value="Gentle" {{ old('haircut_type') == 'Gentle' ? 'selected' : '' }}>Gentle</option>
                            <option value="Ladies" {{ old('haircut_type') == 'Ladies' ? 'selected' : '' }}>Ladies</option>
                        </select>
                        @error('haircut_type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </label>

                    {{-- Barber Services picker --}}
                    {{-- <div id="action-picker" class="mb-4">
                        <label for="action-select" class="block text-gray-700 mb-1">💈 Barber Services</label>
                        <div class="flex items-center space-x-2">
                            <select id="action-select"
                                class="flex-1 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="" disabled selected>Select an action…</option>
                                <option value="Haircut">Haircut</option>
                                <option value="Trimming">Trimming</option>
                                <option value="Beard Shaving">Beard Shaving</option>
                                <option value="Beard Trimming">Beard Trimming</option>
                                <option value="Hair Wash">Hair Wash</option>
                                <option value="Hair Styling">Hair Styling</option>
                                <option value="Pomade Styling">Pomade Styling</option>
                                <option value="Hair Coloring">Hair Coloring</option>
                                <option value="Hair Bleaching">Hair Bleaching</option>
                                <option value="Hair Toning">Hair Toning</option>
                                <option value="Perming">Perming</option>
                                <option value="Hair Straightening">Hair Straightening</option>
                                <option value="Scalp Massage">Scalp Massage</option>
                                <option value="Facial">Facial</option>
                                <option value="Hair Spa">Hair Spa</option>
                                <option value="Creambath">Creambath</option>
                                <option value="Ear Cleaning">Ear Cleaning</option>
                                <option value="Nose Hair Trim">Nose Hair Trim</option>
                                <option value="Eyebrow Trim">Eyebrow Trim</option>
                                <option value="Hot Towel Treatment">Hot Towel Treatment</option>
                                <option value="Back Massage">Back Massage</option>
                            </select>
                            <button type="button" id="add-action-btn"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                                Add
                            </button>
                        </div>
                        <div id="selected-actions" class="mt-3 flex flex-wrap gap-2"></div>
                    </div> --}}

                    {{-- Hidden field untuk menyimpan barber services ke colouring_other --}}
                    {{-- <input type="hidden" name="colouring_other" id="colouring_other_hidden"
                        value="{{ old('colouring_other') }}"> --}}

                    {{-- Sell/Use Product --}}
                    {{-- <label class="block">
                        <span class="text-gray-700">🧴 Sell/Use Product</span>
                        <textarea name="sell_use_product" placeholder="e.g. Shampoo X, Conditioner Y"
                            class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            rows="3">{{ old('sell_use_product') }}</textarea>
                    </label> --}}

                    {{-- Rincian --}}
                    {{-- <label class="block">
                        <span class="text-gray-700">📝 Rincian</span>
                        <textarea name="rincian"
                            class="w-full mt-1 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" rows="4"
                            placeholder="Keterangan tambahan, catatan, atau permintaan khusus...">{{ old('rincian') }}</textarea>
                        @error('rincian')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </label> --}}

                    {{-- Price --}}
                    {{-- <label class="block">
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
                    </label> --}}

                    {{-- Payment Method --}}
                    {{-- <label class="block">
                        <span class="text-gray-700">💳 Payment Method</span>
                        <select name="qr"
                            class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="cash" {{ old('qr') == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="qr_transfer" {{ old('qr') == 'qr_transfer' ? 'selected' : '' }}>QR Transfer
                            </option>
                        </select>
                    </label> --}}

                    {{-- Barber Name --}}
                    <label class="block">
                        <span class="text-gray-700">💈 Barber Name</span>

                        @if (auth()->user()->level === 'admin')
                            <select name="barber_name"
                                class="w-full mt-1 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                required>
                                <option value="">-- Pilih Nama Kasir --</option>
                                @foreach ($filtering as $capster)
                                    <option value="{{ $capster->name }}"
                                        {{ old('barber_name') === $capster->name ? 'selected' : '' }}>
                                        {{ $capster->name }}
                                    </option>
                                @endforeach
                            </select>
                        @else
                            {{-- Untuk kasir, tampilkan nama mereka tapi disable --}}
                            <input type="text" name="barber_name" value="{{ auth()->user()->name }}"
                                class="w-full mt-1 px-3 py-2 border rounded-lg bg-gray-100 cursor-not-allowed" disabled />
                            {{-- Dan kirimkan tetap lewat input hidden --}}
                            <input type="hidden" name="barber_name" value="{{ auth()->user()->name }}">
                        @endif

                        @error('barber_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </label>

                    {{-- Waktu dibuat --}}
                    <div class="mb-4">
                        <label for="created_time" class="block text-sm font-medium text-gray-700 mb-1">🕒 Waktu</label>
                        <input type="datetime-local" id="created_time" name="created_time"
                            class="w-full px-3 py-2 border rounded-lg text-sm bg-gray-100 text-gray-700"
                            disabled>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const input = document.getElementById('created_time');
                            if (input) {
                                const now = new Date();
                                const offset = now.getTimezoneOffset();
                                const local = new Date(now.getTime() - offset * 60000);
                                input.value = local.toISOString().slice(0, 16); // Format: YYYY-MM-DDTHH:MM
                            }
                        });
                    </script>

                    <button type="submit"
                        class="w-full py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Save
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Price formatting
            const priceInput = document.getElementById('price');

            function formatNumber(n) {
                return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            function plainNumber(n) {
                return n.replace(/\./g, '');
            }
            if (priceInput) {
                priceInput.addEventListener('input', function(e) {
                    const raw = plainNumber(e.target.value.replace(/\D/g, ''));
                    e.target.value = formatNumber(raw);
                });
                priceInput.closest('form').addEventListener('submit', function() {
                    priceInput.value = plainNumber(priceInput.value);
                });
            }

            // Barber services picker → simpan ke hidden colouring_other
            const select = document.getElementById('action-select');
            const addBtn = document.getElementById('add-action-btn');
            const listDiv = document.getElementById('selected-actions');
            const colouringHidden = document.getElementById('colouring_other_hidden');
            const selected = new Set();

            // Render tags dan update hidden field
            function renderTags() {
                listDiv.innerHTML = '';
                selected.forEach(action => {
                    const wrap = document.createElement('span');
                    wrap.className =
                        'px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full flex items-center space-x-1';
                    wrap.innerHTML = `
                        <span>${action}</span>
                        <button type="button" data-action="${action}" class="remove-action text-indigo-600 hover:text-indigo-900">&times;</button>
                    `;
                    listDiv.appendChild(wrap);
                });
                // Update hidden input
                colouringHidden.value = Array.from(selected).join(', ');
                // Attach remove handlers
                listDiv.querySelectorAll('.remove-action').forEach(btn => {
                    btn.addEventListener('click', e => {
                        selected.delete(e.target.dataset.action);
                        renderTags();
                    });
                });
            }

            addBtn.addEventListener('click', () => {
                const val = select.value;
                if (!val || selected.has(val)) return;
                selected.add(val);
                renderTags();
            });
        });
    </script>
@endsection
