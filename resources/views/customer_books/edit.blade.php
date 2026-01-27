@extends('layouts.app')

@section('title', 'Execute Customer Book')

@section('content')
  {{-- ===================== CONTAINER UTAMA (background & center) ===================== --}}
  <div class="min-h-screen py-10 px-4 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-lg mx-auto">

      {{-- ===================== CARD (stripe + card body) ===================== --}}
      <div class="rounded-2xl overflow-hidden shadow-2xl">

        {{-- Barber stripe (merah-putih-biru) --}}
        <div class="flex h-1">
          <div class="w-1/3 bg-red-600"></div>
          <div class="w-1/3 bg-white"></div>
          <div class="w-1/3 bg-blue-600"></div>
        </div>

        {{-- Card body --}}
        <div class="bg-white p-6 sm:p-8 lg:p-10">
          {{-- Judul --}}
          <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-800 mb-2 text-center">
            Execute Customer Book — #{{ $customerBook->id }}
          </h2>

          <p class="text-sm text-gray-500 text-center mb-6">
            Lengkapi data pelanggan, pilih layanan, dan simpan proses. Desain konsisten dengan halaman proses capster.
          </p>

          <form action="{{ route('customer-books.update', $customerBook->id) }}" method="POST" class="space-y-5" id="customer-book-form">
            @csrf
            @method('PUT')

            {{-- Customer --}}
            <label class="block">
              <span class="inline-flex items-center gap-2 text-gray-700">
                <span class="text-indigo-600 font-mono">»</span>
                <span class="font-medium">Customer</span>
              </span>
              <input type="text" name="customer" value="{{ old('customer', $customerBook->customer) }}" placeholder="e.g. Jane Doe"
                class="w-full mt-2 px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-300 transition"
                required>
              @error('customer')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </label>

            {{-- Capster --}}
            <label class="block">
              <span class="inline-flex items-center gap-2 text-gray-700">
                <span class="text-indigo-600 font-mono">»</span>
                <span class="font-medium">Capster</span>
              </span>
              <select name="cap" id="capSelect" required
                class="w-full mt-2 px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-300 transition"
                aria-label="Pilih Capster">
                <option value="">— Pilih Capster —</option>
                @foreach ($capsters as $capster)
                  <option value="{{ $capster->inisial }}"
                    {{ (old('cap') ?? $customerBook->cap) == $capster->inisial ? 'selected' : '' }}>
                    {{ $capster->inisial }} – {{ $capster->nama }}
                  </option>
                @endforeach
              </select>
              @error('cap')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </label>

            {{-- Asisten --}}
            <label class="block">
              <span class="inline-flex items-center gap-2 text-gray-700">
                <span class="text-indigo-600 font-mono">»</span>
                <span class="font-medium">Asisten (Opsional)</span>
              </span>
              <select name="asisten" id="asistenSelect"
                class="w-full mt-2 px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-300 transition">
                <option value="">— Pilih Asisten —</option>
                @foreach ($capsters as $capstery)
                  <option value="{{ $capstery->inisial }}"
                    {{ (old('asisten') ?? $customerBook->asisten) == $capstery->inisial ? 'selected' : '' }}>
                    {{ $capstery->inisial }} – {{ $capstery->nama }}
                  </option>
                @endforeach
              </select>
              @error('asisten')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </label>

            {{-- script: disable option sama di cap & asisten --}}
            <script>
              document.addEventListener('DOMContentLoaded', function() {
                const capSelect = document.getElementById('capSelect');
                const asistenSelect = document.getElementById('asistenSelect');

                function disableSameOption() {
                  const selectedCap = capSelect.value;
                  const selectedAsisten = asistenSelect.value;

                  Array.from(asistenSelect.options).forEach(option => option.disabled = false);
                  Array.from(capSelect.options).forEach(option => option.disabled = false);

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

                // jalankan awal bila ada nilai lama
                disableSameOption();
              });
            </script>

            {{-- Haircut Type --}}
            <label class="block">
              <span class="inline-flex items-center gap-2 text-gray-700">
                <span class="text-indigo-600 font-mono">»</span>
                <span class="font-medium">Haircut Type</span>
              </span>
              <select name="haircut_type" required
                class="w-full mt-2 px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-300 transition">
                <option value="" disabled {{ old('haircut_type', $customerBook->haircut_type) ? '' : 'selected' }}>-- Select Type --</option>
                <option value="Gentle" {{ old('haircut_type', $customerBook->haircut_type) == 'Gentle' ? 'selected' : '' }}>Gentle</option>
                <option value="Ladies" {{ old('haircut_type', $customerBook->haircut_type) == 'Ladies' ? 'selected' : '' }}>Ladies</option>
              </select>
              @error('haircut_type')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </label>

            {{-- SERVICES & PAYMENT PANEL --}}
            <div class="relative overflow-hidden rounded-2xl p-[1px] bg-gradient-to-br from-indigo-200 via-sky-200 to-purple-200">
              <div class="absolute inset-0 bg-gradient-to-br from-indigo-300/30 via-sky-200/20 to-purple-300/30 blur-2xl"></div>

              <div class="relative border border-white/60 rounded-2xl p-4 md:p-6 bg-white/80 backdrop-blur-md space-y-5 shadow-lg">

                <!-- Header -->
                <div class="flex items-center justify-between">
                  <div>
                    <h3 class="text-lg font-semibold text-gray-800">Barber Services</h3>
                    <p class="text-sm text-gray-500">Select services and calculate payment</p>
                  </div>

                  <div class="w-14 h-14 rounded-xl overflow-hidden border border-white shadow">
                    <img src="https://static.vecteezy.com/system/resources/previews/044/855/219/original/barbershop-pole-pixel-art-illustration-vector.jpg"
                      class="w-full h-full object-cover" alt="barber-pole">
                  </div>
                </div>

                <!-- service selector & add -->
                <div>
                  <div class="grid grid-cols-1 md:grid-cols-[1fr_auto] gap-2">
                    <select id="action-select"
                      class="w-full px-3 py-2 border rounded-xl bg-white/90 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                      <option value="">-- Pilih layanan --</option>

                      <optgroup label="Haircut">
                        <option value="Men Haircut Reguler">Men Haircut Reguler</option>
                        <option value="Ladies Haircut Reguler">Ladies Haircut Reguler</option>
                        <option value="Baby Haircut">Baby Haircut</option>
                        <option value="Kids Haircut">Kids Haircut</option>
                        <option value="Kids Haircut Female">Kids Haircut Female</option>
                        <option value="Poni">Poni</option>
                      </optgroup>

                      <optgroup label="Keratin">
                        <option value="Keratin For Men">Keratin For Men</option>
                        <option value="Keratin S">Keratin S</option>
                        <option value="Keratin M">Keratin M</option>
                        <option value="Keratin L">Keratin L</option>
                        <option value="Keratin XL">Keratin XL</option>
                        <option value="Keratin XXL">Keratin XXL</option>
                      </optgroup>

                      <optgroup label="Treatment">
                        <option value="Men Hair Treatment">Men Hair Treatment</option>
                        <option value="Ladies Hair Treatment">Ladies Hair Treatment</option>
                        <option value="Facial">Facial</option>
                      </optgroup>

                      <optgroup label="Coloring and Styling">
                        <option value="Hair Toning For Men">Hair Toning For Men</option>
                        <option value="Highlight For Men">Highlight For Men</option>
                        <option value="Hair Styling">Hair Styling</option>
                        <option value="Hair Tatto">Hair Tatto</option>
                      </optgroup>

                      <optgroup label="Smoothing">
                        <option value="Hair Smoothing For Men">Hair Smoothing For Men</option>
                        <option value="Hair Smoothing S">Hair Smoothing S</option>
                        <option value="Hair Smoothing M">Hair Smoothing M</option>
                        <option value="Hair Smoothing L">Hair Smoothing L</option>
                        <option value="Hair Smoothing XL">Hair Smoothing XL</option>
                        <option value="Hair Smoothing XXL">Hair Smoothing XXL</option>
                        <option value="Hair Smoothing XXXL">Hair Smoothing XXXL</option>
                        <option value="Hair Smoothing Over">Hair Smoothing Over</option>
                      </optgroup>

                      <optgroup label="Others">
                        <option value="Shaving">Shaving</option>
                        <option value="Perming">Perming</option>
                        <option value="Downperm">Downperm</option>
                        <option value="Eyelash">Eyelash</option>
                        <option value="Eyelash Retouch">Eyelash Retouch</option>
                      </optgroup>
                    </select>

                    <button type="button" id="add-action-btn"
                      class="w-full md:w-auto px-5 py-2 rounded-xl bg-gradient-to-r from-indigo-600 to-pink-500 text-white font-semibold shadow-md hover:from-indigo-700 hover:to-pink-600 transition">
                      Add
                    </button>
                  </div>

                  <div id="selected-actions" class="mt-3 flex flex-wrap gap-2">
                    @if(old('services', $customerBook->services))
                      @foreach(old('services', $customerBook->services) as $service)
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-sm flex items-center gap-2 shadow-sm">
                          {{ $service }}
                          <input type="hidden" name="services[]" value="{{ $service }}">
                          <button type="button" class="remove-service text-red-500 hover:text-red-700">×</button>
                        </span>
                      @endforeach
                    @endif
                  </div>
                </div>

                <hr class="border-indigo-300/40">

                <!-- PRICE & PAYMENT -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label class="block text-gray-700 font-medium mb-1">Total Price</label>
                    <div class="relative">
                      <div class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">Rp</div>
                      <input type="text" id="price_display"
                        value="{{ old('price', $customerBook->price) ? number_format(old('price', $customerBook->price),0,',','.') : '0' }}"
                        class="w-full pl-12 pr-4 py-2 border rounded-xl bg-gray-100 font-semibold" disabled>
                      <input type="hidden" name="price" id="price_hidden" value="{{ old('price', $customerBook->price) ?? 0 }}">
                    </div>
                  </div>

                  <div>
                    <label class="block text-gray-700 font-medium mb-1">Payment Method</label>
                    <select name="qr" class="w-full px-4 py-2 border rounded-xl bg-white">
                      <option value="cash" {{ old('qr',$customerBook->qr)=='cash'?'selected':'' }}>Cash</option>
                      <option value="qr_transfer" {{ old('qr',$customerBook->qr)=='qr_transfer'?'selected':'' }}>QR Transfer</option>
                      <option value="no revenue" {{ old('qr',$customerBook->qr)=='no revenue'?'selected':'' }}>No Revenue</option>
                    </select>
                  </div>
                </div>

                @if($canInputManualPrice)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                  @foreach([
                    ['Hair Coloring','hair_coloring_price'],
                    ['Hair Extension','hair_extension_price'],
                    ['Hair Extension Services','hair_extension_services_price']
                  ] as [$label,$id])
                    <div>
                      <label class="text-sm text-gray-700 mb-1 block">{{ $label }}</label>
                      <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">Rp</div>
                        <input type="text" id="{{ $id }}_input"
                          class="w-full pl-12 pr-3 py-2 border rounded-xl bg-white"
                          value="{{ old($id,$customerBook->$id) ? number_format(old($id,$customerBook->$id),0,',','.') : '' }}">
                        <input type="hidden" name="{{ $id }}" id="{{ $id }}_hidden"
                          value="{{ old($id,$customerBook->$id) ?? '' }}">
                      </div>
                    </div>
                  @endforeach
                </div>
                @endif

              </div>
            </div>

            {{-- Hidden field untuk menyimpan barber services ke colouring_other --}}
            <input type="hidden" name="colouring_other" id="colouring_other_hidden" value="{{ old('colouring_other', $customerBook->colouring_other) }}">

            {{-- Sell/Use Product --}}
            <label class="block">
              <span class="inline-flex items-center gap-2 text-gray-700">
                <span class="text-indigo-600 font-mono">»</span>
                <span class="font-medium">Sell/Use Product</span>
              </span>
              <textarea name="sell_use_product" placeholder="e.g. Shampoo X, Conditioner Y"
                class="w-full mt-2 px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-300 transition"
                rows="3">{{ old('sell_use_product', $customerBook->sell_use_product) }}</textarea>
            </label>

            {{-- Rincian --}}
            <label class="block">
              <span class="inline-flex items-center gap-2 text-gray-700">
                <span class="text-indigo-600 font-mono">»</span>
                <span class="font-medium">Rincian</span>
              </span>
              <textarea name="rincian"
                class="w-full mt-2 px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-300 transition"
                rows="4" placeholder="Keterangan tambahan, catatan, atau permintaan khusus...">{{ old('rincian', $customerBook->rincian) }}</textarea>
              @error('rincian')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </label>

            {{-- Barber Name --}}
            <label class="block">
              <span class="inline-flex items-center gap-2 text-gray-700">
                <span class="text-indigo-600 font-mono">»</span>
                <span class="font-medium">Barber Name</span>
              </span>

              @if (auth()->user()->level === 'admin')
                <select name="barber_name" required
                  class="w-full mt-2 px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-300 transition">
                  <option value="">-- Pilih Nama Kasir --</option>
                  @foreach ($filtering as $capster)
                    <option value="{{ $capster->name }}" {{ old('barber_name', $customerBook->barber_name) === $capster->name ? 'selected' : '' }}>
                      {{ $capster->name }}
                    </option>
                  @endforeach
                </select>
              @else
                <input type="text" name="barber_name" value="{{ auth()->user()->name }}"
                  class="w-full mt-2 px-4 py-2 border rounded-xl bg-gray-100 cursor-not-allowed" disabled />
                <input type="hidden" name="barber_name" value="{{ auth()->user()->name }}">
              @endif

              @error('barber_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </label>

            {{-- Done button --}}
            <button type="button" id="updateBtn" data-level="{{ auth()->user()->level }}"
              class="w-full py-3 rounded-xl bg-gradient-to-r from-indigo-600 to-pink-500 text-white font-semibold shadow-md hover:from-indigo-700 hover:to-pink-600 transition">
              Done
            </button>

          </form>
        </div>
        {{-- ===================== END CARD BODY ===================== --}}
      </div>
      {{-- ===================== END CARD ===================== --}}
    </div>
  </div>
  {{-- ===================== END CONTAINER ===================== --}}

  {{-- SCRIPTS (SweetAlert konfirmasi, services & price calc) --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const form = document.getElementById('customer-book-form');
      if (!form) return;

      // Elements
      const select = document.getElementById('action-select');
      const addBtn = document.getElementById('add-action-btn');
      const listDiv = document.getElementById('selected-actions');
      const displayTotal = document.getElementById('price_display');
      const hiddenTotal  = document.getElementById('price_hidden');

      // Manual fields mapping
      const manualFields = [
        { inputId: 'hair_coloring_price_input', hiddenId: 'hair_coloring_price_hidden' },
        { inputId: 'hair_extension_price_input', hiddenId: 'hair_extension_price_hidden' },
        { inputId: 'hair_extension_services_price_input', hiddenId: 'hair_extension_services_price_hidden' }
      ];

      // Price map (sama seperti yang kamu punya)
      const priceMap = {
        "Men Haircut Reguler": 50000,
        "Ladies Haircut Reguler": 60000,
        "Baby Haircut": 30000,
        "Poni": 25000,
        "Keratin For Men": 350000,
        "Keratin S": 400000,
        "Keratin M": 600000,
        "Keratin L": 800000,
        "Keratin XL": 950000,
        "Keratin XXL": 1000000,
        "Kids Haircut": 40000,
        "Kids Haircut Female": 65000,
        "Shaving": 10000,
        "Hair Tatto": 35000,
        "Hair Styling": 50000,
        "Men Hair Treatment": 85000,
        "Ladies Hair Treatment": 100000,
        "Hair Toning For Men": 85000,
        "Highlight For Men": 300000,
        "Hair Smoothing For Men": 250000,
        "Hair Smoothing S": 300000,
        "Hair Smoothing M": 350000,
        "Hair Smoothing L": 400000,
        "Hair Smoothing XL": 450000,
        "Hair Smoothing XXL": 500000,
        "Hair Smoothing XXXL": 600000,
        "Hair Smoothing Over": 700000,
        "Perming": 300000,
        "Downperm": 150000,
        "Facial": 80000,
        "Eyelash": 150000,
        "Eyelash Retouch": 50000
      };

      const groups = {
        keratin: [
          "Keratin For Men","Keratin S","Keratin M","Keratin L","Keratin XL","Keratin XXL"
        ],
        smoothing: [
          "Hair Smoothing For Men","Hair Smoothing S","Hair Smoothing M","Hair Smoothing L",
          "Hair Smoothing XL","Hair Smoothing XXL","Hair Smoothing XXXL","Hair Smoothing Over"
        ]
      };

      const digitsOnly = s => String(s || '').replace(/\D/g, '');
      const formatRp = n => String(Number(n || 0)).replace(/\B(?=(\d{3})+(?!\d))/g, '.');

      // ensure hidden 'colouring_other' exists
      let serviceHidden = document.getElementById('colouring_other_hidden');
      if (!serviceHidden) {
        serviceHidden = document.createElement('input');
        serviceHidden.type = 'hidden';
        serviceHidden.name = 'colouring_other';
        serviceHidden.id = 'colouring_other_hidden';
        form.appendChild(serviceHidden);
      }

      // ensure manual hidden inputs exist and map them
      const manualHiddenMap = {};
      manualFields.forEach(f => {
        let el = document.getElementById(f.hiddenId);
        if (!el) {
          el = document.createElement('input');
          el.type = 'hidden';
          el.id = f.hiddenId;
          // name must match original field name
          el.name = f.hiddenId.replace('_hidden','');
          form.appendChild(el);
        }
        manualHiddenMap[f.hiddenId] = el;
      });

      // populate selected (from old values)
      const selected = [];
      if (serviceHidden.value) {
        serviceHidden.value.split(/\s*,\s*/).filter(Boolean).forEach(s => selected.push(s));
      }

      function getManualTotal() {
        let sum = 0;
        Object.values(manualHiddenMap).forEach(h => {
          const d = digitsOnly(h.value);
          if (d) sum += Number(d);
        });
        return sum;
      }

      function updateTotal() {
        let total = 0;
        selected.forEach(s => total += priceMap[s] || 0);
        total += getManualTotal();
        displayTotal.value = formatRp(total);
        hiddenTotal.value = total;
        serviceHidden.value = selected.join(', ');
      }

      function render() {
        listDiv.innerHTML = '';
        selected.forEach(svc => {
          const span = document.createElement('span');
          span.className = 'px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full flex gap-2 items-center';
          const priceText = priceMap[svc] ? `Rp ${formatRp(priceMap[svc])}` : 'Rp 0';
          span.innerHTML = `<span class="text-xs">${priceText}</span><span>${svc}</span><button type="button" data-svc="${svc}" class="ml-2 text-red-500">&times;</button>`;
          span.querySelector('button').onclick = () => {
            const i = selected.indexOf(svc);
            if (i !== -1) selected.splice(i,1);
            render();
            updateTotal();
          };
          // also create hidden input for form so backend still receives services[] on normal submit
          const hiddenInput = document.createElement('input');
          hiddenInput.type = 'hidden';
          hiddenInput.name = 'services[]';
          hiddenInput.value = svc;
          span.appendChild(hiddenInput);

          listDiv.appendChild(span);
        });
      }

      function removeGroupIfNeeded(svc) {
        Object.values(groups).forEach(group => {
          if (group.includes(svc)) {
            group.forEach(g => {
              const i = selected.indexOf(g);
              if (i !== -1) selected.splice(i,1);
            });
          }
        });
      }

      addBtn.onclick = () => {
        const svc = select.value;
        if (!svc) return;
        removeGroupIfNeeded(svc);
        if (!selected.includes(svc)) selected.push(svc);
        render();
        updateTotal();
        // reset select
        select.value = '';
      };

      // wire manual inputs
      manualFields.forEach(f => {
        const input = document.getElementById(f.inputId);
        const hidden = document.getElementById(f.hiddenId);
        if (!input || !hidden) return;
        // initialize display value from hidden if present
        if (hidden.value) input.value = formatRp(digitsOnly(hidden.value));
        input.addEventListener('input', () => {
          const d = digitsOnly(input.value);
          input.value = d ? formatRp(d) : '';
          hidden.value = d;
          updateTotal();
        });
      });

      // handle existing remove-service buttons (for blade-rendered old values)
      Array.from(document.querySelectorAll('.remove-service')).forEach(btn => {
        btn.addEventListener('click', function() {
          const parent = this.closest('span');
          const hid = parent.querySelector('input[name="services[]"]');
          if (hid) {
            const val = hid.value;
            const idx = selected.indexOf(val);
            if (idx !== -1) selected.splice(idx,1);
          }
          parent.remove();
          updateTotal();
        });
      });

      // ensure totals are correct before actual submit
      form.addEventListener('submit', function () {
        // normalize manual hidden fields to digits only
        Object.values(manualHiddenMap).forEach(h => h.value = digitsOnly(h.value));
        // ensure service hidden updated
        serviceHidden.value = selected.join(', ');
        updateTotal();
      });

      // initial render & total
      render();
      updateTotal();

      // SWEETALERT + submit behavior for updateBtn
      const updateBtn = document.getElementById('updateBtn');
      if (updateBtn) {
        updateBtn.addEventListener('click', function(e) {
          const level = this.dataset.level;
          // target hidden input to strip formatting before submit
          function stripFormatting() {
            // remove thousands separators in hidden total and manual hidden fields
            if (hiddenTotal) hiddenTotal.value = digitsOnly(hiddenTotal.value);
            Object.values(manualHiddenMap).forEach(h => h.value = digitsOnly(h.value));
          }

          if (level === 'kasir') {
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
            stripFormatting();
            form.submit();
          }
        });
      }
    });
  </script>
@endsection