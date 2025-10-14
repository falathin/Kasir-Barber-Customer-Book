@extends('layouts.app')

@section('title', 'Execute Customer Book')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Execute Customer Book</h2>
                <form action="{{ route('customer-books.update', $customerBook->id) }}" method="POST" class="space-y-5"
                    id="customer-book-form">
                    @csrf
                    @method('PUT')

                    {{-- Customer --}}
                    <label class="block">
                        <span class="text-gray-700">👤 Customer</span>
                        <input type="text" name="customer" value="{{ old('customer', $customerBook->customer) }}"
                            placeholder="e.g. Jane Doe"
                            class="w-full mt-1 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required>
                        @error('customer')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </label>

                    {{-- Capster --}}
                    <label class="block mb-4">
                        <span class="text-gray-700">✂️ Capster</span>
                        <select name="cap" id="capSelect" required
                            class="w-full mt-1 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Pilih Capster</option>
                            @foreach ($capsters as $capster)
                                <option value="{{ $capster->inisial }}"
                                    {{ (old('cap') ?? $customerBook->cap) == $capster->inisial ? 'selected' : '' }}>
                                    {{ $capster->inisial }} - {{ $capster->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('cap')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </label>

                    {{-- Asisten --}}
                    <label class="block mb-4">
                        <span class="text-gray-700">🧍 Asisten (Opsional)</span>
                        <select name="asisten" id="asistenSelect"
                            class="w-full mt-1 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Pilih Asisten</option>
                            @foreach ($capsters as $capstery)
                                <option value="{{ $capstery->inisial }}"
                                    {{ (old('asisten') ?? $customerBook->asisten) == $capstery->inisial ? 'selected' : '' }}>
                                    {{ $capstery->inisial }} - {{ $capstery->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('asisten')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </label>
                    
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const capSelect = document.getElementById('capSelect');
                            const asistenSelect = document.getElementById('asistenSelect');

                            function disableSameOption() {
                                const selectedCap = capSelect.value;
                                const selectedAsisten = asistenSelect.value;

                                // Reset semua opsi asisten agar aktif dulu
                                Array.from(asistenSelect.options).forEach(option => {
                                    option.disabled = false;
                                });

                                // Reset semua opsi capster juga
                                Array.from(capSelect.options).forEach(option => {
                                    option.disabled = false;
                                });

                                // Disable opsi yang sama di masing-masing select
                                if (selectedCap) {
                                    const sameAsistenOption = asistenSelect.querySelector(`option[value="${selectedCap}"]`);
                                    if (sameAsistenOption) sameAsistenOption.disabled = true;
                                }

                                if (selectedAsisten) {
                                    const sameCapOption = capSelect.querySelector(`option[value="${selectedAsisten}"]`);
                                    if (sameCapOption) sameCapOption.disabled = true;
                                }
                            }

                            capSelect.addEventListener('change', disableSameOption);
                            asistenSelect.addEventListener('change', disableSameOption);

                            // Jalankan saat awal jika data lama terisi
                            disableSameOption();
                        });
                    </script>

                    {{-- Haircut Type --}}
                    <label class="block">
                        <span class="text-gray-700">💇‍♀️ Haircut Type</span>
                        <select name="haircut_type"
                            class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required>
                            <option value="" disabled
                                {{ old('haircut_type', $customerBook->haircut_type) ? '' : 'selected' }}>-- Select Type --
                            </option>
                            <option value="Gentle"
                                {{ old('haircut_type', $customerBook->haircut_type) == 'Gentle' ? 'selected' : '' }}>Gentle
                            </option>
                            <option value="Ladies"
                                {{ old('haircut_type', $customerBook->haircut_type) == 'Ladies' ? 'selected' : '' }}>Ladies
                            </option>
                        </select>
                        @error('haircut_type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </label>

                    {{-- Barber Services picker --}}
                    <div id="action-picker" class="mb-4">
                        <label for="action-select" class="block text-gray-700 mb-1">💈 Barber Services</label>
                        <div class="flex items-center space-x-2">
                            <select id="action-select"
                                class="flex-1 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="" disabled selected>Select an action…</option>
                                <option value="Haircut Reguler">Haircut Reguler</option>
                                <option value="Ladies Only Haircut">Ladies Only Haircut</option>
                                <option value="Baby Haircut">Baby Haircut</option>
                                <option value="Poni">Poni</option>
                                <option value="Fading Haircut">Fading Haircut</option>
                                <option value="Shaving">Shaving</option>
                                <option value="Hair Tatto">Hair Tatto</option>
                                <option value="Hair Styling">Hair Styling</option>
                                <option value="Hair Treatment">Hair Treatment</option>
                                <option value="Hair Bleaching">Hair Bleaching</option>
                                <option value="Hair Coloring">Hair Coloring</option>
                                <option value="Hair Toning">Hair Toning</option>
                                <option value="Highlight">Highlight</option>
                                <option value="Hair Smoothing">Hair Smoothing</option>
                                <option value="Perming">Perming</option>
                                <option value="Downperm">Downperm</option>
                                <option value="Hair Extension">Hair Extension</option>
                                <option value="Hair Extension services">Hair Extension services</option>
                                <option value="Facial">Facial</option>
                                <option value="Eyelash">Eyelash</option>
                                <option value="Eyelash Retouch">Eyelash Retouch</option>
                            </select>
                            <button type="button" id="add-action-btn"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                                Add
                            </button>
                        </div>
                        <div id="selected-actions" class="mt-3 flex flex-wrap gap-2"></div>
                    </div>

                    {{-- Hidden field untuk menyimpan barber services ke colouring_other --}}
                    <input type="hidden" name="colouring_other" id="colouring_other_hidden"
                        value="{{ old('colouring_other', $customerBook->colouring_other) }}">

                    {{-- Sell/Use Product --}}
                    <label class="block">
                        <span class="text-gray-700">🧴 Sell/Use Product</span>
                        <textarea name="sell_use_product" placeholder="e.g. Shampoo X, Conditioner Y"
                            class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            rows="3">{{ old('sell_use_product', $customerBook->sell_use_product) }}</textarea>
                    </label>

                    {{-- Rincian --}}
                    <label class="block">
                        <span class="text-gray-700">📝 Rincian</span>
                        <textarea name="rincian"
                            class="w-full mt-1 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" rows="4"
                            placeholder="Keterangan tambahan, catatan, atau permintaan khusus...">{{ old('rincian', $customerBook->rincian) }}</textarea>
                        @error('rincian')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </label>

                    {{-- Price (display disabled + hidden actual price for submission) --}}
                    <label class="block">
                        <span class="text-gray-700">💰 Price</span>
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">Rp</div>
                            <!-- Visible disabled input (no name) supaya user tidak bisa ubah -->
                            <input type="text" id="price_display" inputmode="numeric"
                                value="{{ old('price', $customerBook->price) ? number_format($customerBook->price,0,',','.') : '0' }}" placeholder="e.g. 150000"
                                class="w-full pl-12 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                disabled>
                            <!-- Hidden input dengan name="price" yang dikirim ke server -->
                            <input type="hidden" name="price" id="price_hidden" value="{{ old('price', $customerBook->price) }}">
                        </div>
                        @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </label>

                    {{-- Payment Method --}}
                    <label class="block">
                        <span class="text-gray-700">💳 Payment Method</span>
                        <select name="qr"
                            class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="cash" {{ old('qr', $customerBook->qr) == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="qr_transfer" {{ old('qr', $customerBook->qr) == 'qr_transfer' ? 'selected' : '' }}>QR Transfer</option>
                            <option value="no revenue" {{ old('qr', $customerBook->qr) == 'no revenue' ? 'selected' : '' }}>No Revenue</option>
                        </select>
                    </label>

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
                                        {{ old('barber_name', $customerBook->barber_name) === $capster->name ? 'selected' : '' }}>
                                        {{ $capster->name }}
                                    </option>
                                @endforeach
                            </select>
                        @else
                            {{-- Kasir hanya bisa lihat nama mereka --}}
                            <input type="text" name="barber_name" value="{{ auth()->user()->name }}"
                                class="w-full mt-1 px-3 py-2 border rounded-lg bg-gray-100 cursor-not-allowed" disabled />
                            {{-- Nilai tetap dikirim lewat input hidden --}}
                            <input type="hidden" name="barber_name" value="{{ auth()->user()->name }}">
                        @endif

                        @error('barber_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </label>

                    @php $isAdmin = auth()->user()->level === 'admin'; @endphp

                <button type="button" id="updateBtn"
                    data-level="{{ auth()->user()->level }}"
                    class="w-full py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    Done
                </button>

                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const updateBtn = document.getElementById('updateBtn');
                        if (!updateBtn) return;

                        updateBtn.addEventListener('click', function (e) {
                            const level = this.dataset.level;
                            const form = this.closest('form');
                            const priceInput = form.querySelector('#price');

                            function stripFormatting() {
                                if (priceInput) {
                                    // Hapus semua titik
                                    priceInput.value = priceInput.value.replace(/\./g, '');
                                }
                            }

                            if (level === 'kasir') {
                                // Kasir: konfirmasi sebelum submit
                                e.preventDefault();
                                Swal.fire({
                                    title: 'Konfirmasi',
                                    text: 'Anda yakin semua rincian sudah benar? Pastikan semua sudah sesuai dan di-isi dengan benar.',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Ya, lanjutkan',
                                    cancelButtonText: 'Batal'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        stripFormatting();
                                        form.submit();
                                    }
                                });
                            } else {
                                // Admin: langsung submit tanpa konfirmasi
                                stripFormatting();
                                form.submit();
                            }
                        });
                    });
                    </script>

                </form>
            </div>
        </div>
    </div>

<script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elements
            const displayInput = document.getElementById('price_display'); // terlihat & disabled
            const hiddenInput = document.getElementById('price_hidden'); // dikirim ke server
            const select = document.getElementById('action-select');
            const addBtn = document.getElementById('add-action-btn');
            const listDiv = document.getElementById('selected-actions');

            // hidden untuk menyimpan daftar selected (mirip colouring_other_hidden dari kode sebelumnya)
            let coloringIn = document.getElementById('colouring_other_hidden');
            const form = displayInput.closest('form');

            if (!coloringIn) {
                coloringIn = document.createElement('input');
                coloringIn.type = 'hidden';
                coloringIn.id = 'colouring_other_hidden';
                coloringIn.name = 'colouring_other_hidden';
                if (form) form.appendChild(coloringIn);
            }

            // Pemetaan harga standar (dalam Rupiah, integer)
            const priceMap = {
                "Haircut Reguler": 50000,
                "Ladies Only Haircut": 60000,
                "Baby Haircut": 30000,
                "Poni": 15000,
                "Fading Haircut": 60000,
                "Shaving": 20000,
                "Hair Tatto": 35000,
                "Hair Styling": 40000,
                "Hair Treatment": 120000,
                "Hair Bleaching": 250000,
                "Hair Coloring": 200000,
                "Hair Toning": 150000,
                "Highlight": 180000,
                "Hair Smoothing": 200000,
                "Perming": 180000,
                "Downperm": 120000,
                "Hair Extension": 300000,
                "Hair Extension services": 350000,
                "Facial": 80000,
                "Eyelash": 150000,
                "Eyelash Retouch": 70000
            };

            // util formatting
            function formatNumber(n) {
                if (n === null || n === undefined) return '0';
                const s = String(n);
                const digits = s.replace(/\D/g, '');
                if (!digits) return '0';
                return digits.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }
            function plainNumber(n) {
                return String(n).replace(/\./g, '').replace(/\D/g, '') || '0';
            }
            // ringkasan singkat: 50000 -> 50rb, 15000 -> 15rb
            function formatShort(n) {
                n = Number(n) || 0;
                if (n >= 1000) return Math.round(n / 1000) + 'rb';
                return String(n); // kalau kecil
            }

            // selected set (menyimpan nama layanan)
            const selected = new Set();

            // Inisialisasi dari existing colouring_other_hidden (jika ada)
            if (coloringIn.value) {
                coloringIn.value.split(',').map(s => s.trim()).filter(s => s).forEach(s => selected.add(s));
            }

            function updateTotalAndInputs() {
                // hitung total dari selected
                let total = 0;
                selected.forEach(action => {
                    const p = priceMap[action] || 0;
                    total += p;
                });
                // update tampilan terformat
                displayInput.value = formatNumber(total);
                // update hidden value (numeric tanpa titik) untuk submission
                hiddenInput.value = String(total);
                // update colouring hidden
                coloringIn.value = Array.from(selected).join(', ');
            }

            function renderTags() {
                listDiv.innerHTML = '';
                selected.forEach(action => {
                    const p = priceMap[action] || 0;
                    const tag = document.createElement('span');
                    // styling masih sama, tambahkan price di dalam tag
                    tag.className = 'px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full flex items-center space-x-2';
                    tag.innerHTML = `
                        <span class="text-xs font-medium text-indigo-700">Rp ${formatNumber(p)}</span>
                        <span class="text-sm">${action}</span>
                        <span class="text-xs text-indigo-600 ml-2">(${formatShort(p)})</span>
                        <button type="button" data-action="${action}" class="remove-action text-indigo-600 hover:text-indigo-900 ml-2">&times;</button>
                    `;
                    listDiv.appendChild(tag);
                });
                // attach remove listeners
                listDiv.querySelectorAll('.remove-action').forEach(btn => {
                    btn.addEventListener('click', e => {
                        const act = e.currentTarget.dataset.action;
                        selected.delete(act);
                        renderTags();
                        updateTotalAndInputs();
                    });
                });
            }

            // render awal dari selected kalau ada pada load
            renderTags();
            updateTotalAndInputs();

            // add action
            addBtn.addEventListener('click', () => {
                const val = select.value;
                if (!val) return;
                if (selected.has(val)) return; // sudah ada
                selected.add(val);
                renderTags();
                updateTotalAndInputs();
            });

            // jika user tekan enter pada select (opsional), tambahkan juga
            select.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addBtn.click();
                }
            });

            // Pastikan saat form disubmit, hiddenInput berisi angka polos (sudah diupdate oleh updateTotalAndInputs)
            if (form) {
                form.addEventListener('submit', () => {
                    hiddenInput.value = plainNumber(hiddenInput.value);
                    // displayInput tetap disabled agar user tidak manipulasi di UI
                });
            }
        });
    </script>
@endsection
