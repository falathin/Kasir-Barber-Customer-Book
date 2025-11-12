@csrf

<div
    class="bg-[#faf8f4] bg-[url('https://wallpapercave.com/wp/wp5302087.jpg')] bg-cover bg-center p-5 sm:p-8 md:p-10 max-w-5xl mx-auto border border-gray-300 rounded-lg font-[Times_New_Roman] shadow-md">

    <h2 class="text-center text-2xl sm:text-3xl font-bold text-white drop-shadow-[0_2px_6px_rgba(0,0,0,0.6)] mb-1">
        {{ isset($capster) ? 'Edit Data Capster' : 'Formulir Pendaftaran Capster' }}
    </h2>
    <strong>
        <p class="text-center text-sm sm:text-base text-white drop-shadow-[0_1px_4px_rgba(0,0,0,0.5)] mb-6">
            Silakan isi data berikut dengan lengkap
        </p>
    </strong>

    <div class="bg-white p-5 sm:p-6 md:p-8 rounded-lg border border-gray-300 shadow-sm">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">

            {{-- Nama --}}
            <div class="flex flex-col">
                <label for="nama" class="text-sm text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="nama" id="nama"
                    value="{{ old('nama', $capster->nama ?? '') }}"
                    placeholder="Contoh: Budi Santoso" required
                    class="px-3 py-2 text-sm sm:text-base border border-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-600">
                @error('nama')
                    <div class="mt-1 text-xs sm:text-sm text-red-700">{{ $message }}</div>
                @enderror
            </div>

            {{-- Inisial --}}
            <div class="flex flex-col">
                <label for="inisial" class="text-sm text-gray-700 mb-1">Inisial</label>
                <input type="text" name="inisial" id="inisial"
                    value="{{ old('inisial', $capster->inisial ?? '') }}"
                    placeholder="Contoh: BS" required
                    class="px-3 py-2 text-sm sm:text-base border border-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-600">
                @error('inisial')
                    <div class="mt-1 text-xs sm:text-sm text-red-700">{{ $message }}</div>
                @enderror
            </div>

            {{-- Jenis Kelamin --}}
            <fieldset class="flex flex-col border border-gray-500 rounded-md px-3 py-3 md:col-span-2">
                <legend class="px-1 font-semibold text-gray-700 text-sm sm:text-base">Jenis Kelamin</legend>
                <div class="mt-1 flex flex-col sm:flex-row sm:items-center sm:space-x-6 space-y-2 sm:space-y-0">
                    <label class="flex items-center text-gray-800 text-sm sm:text-base">
                        <input type="radio" name="jenis_kelamin" value="L"
                            {{ old('jenis_kelamin', $capster->jenis_kelamin ?? '') == 'L' ? 'checked' : '' }}
                            class="mr-2 accent-gray-700">
                        Laki-laki
                    </label>
                    <label class="flex items-center text-gray-800 text-sm sm:text-base">
                        <input type="radio" name="jenis_kelamin" value="P"
                            {{ old('jenis_kelamin', $capster->jenis_kelamin ?? '') == 'P' ? 'checked' : '' }}
                            class="mr-2 accent-gray-700">
                        Perempuan
                    </label>
                </div>
                @error('jenis_kelamin')
                    <div class="mt-1 text-xs sm:text-sm text-red-700">{{ $message }}</div>
                @enderror
            </fieldset>

            {{-- No HP --}}
            <div class="flex flex-col">
                <label for="no_hp" class="text-sm text-gray-700 mb-1">No. HP</label>
                <input type="text" name="no_hp" id="no_hp"
                    class="phone-format px-3 py-2 text-sm sm:text-base border border-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-600"
                    value="{{ old('no_hp', $capster->no_hp ?? '') }}" placeholder="0809-123-4567" required>
                @error('no_hp')
                    <div class="mt-1 text-xs sm:text-sm text-red-700">{{ $message }}</div>
                @enderror
            </div>

            {{-- No HP Keluarga --}}
            <div class="flex flex-col">
                <label for="no_hp_keluarga" class="text-sm text-gray-700 mb-1">No. HP Keluarga (opsional)</label>
                <input type="text" name="no_hp_keluarga" id="no_hp_keluarga"
                    class="phone-format px-3 py-2 text-sm sm:text-base border border-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-600"
                    value="{{ old('no_hp_keluarga', $capster->no_hp_keluarga ?? '') }}" placeholder="0809-123-4567">
                @error('no_hp_keluarga')
                    <div class="mt-1 text-xs sm:text-sm text-red-700">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tanggal Lahir --}}
            <div class="flex flex-col">
                <label for="tgl_lahir" class="text-sm text-gray-700 mb-1">Tanggal Lahir</label>
                <input type="date" name="tgl_lahir" id="tgl_lahir"
                    value="{{ old('tgl_lahir', isset($capster) ? $capster->tgl_lahir->toDateString() : '') }}" required
                    class="px-3 py-2 text-sm sm:text-base border border-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-600">
                @error('tgl_lahir')
                    <div class="mt-1 text-xs sm:text-sm text-red-700">{{ $message }}</div>
                @enderror
            </div>

            {{-- Asal --}}
            <div class="flex flex-col md:col-span-2">
                <label for="asal" class="text-sm text-gray-700 mb-1">Asal / Alamat</label>
                <textarea name="asal" id="asal" rows="3" placeholder="Contoh: Jl. Merdeka No.123, Bandung" required
                    class="px-3 py-2 text-sm sm:text-base border border-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-600">{{ old('asal', $capster->asal ?? '') }}</textarea>
                @error('asal')
                    <div class="mt-1 text-xs sm:text-sm text-red-700">{{ $message }}</div>
                @enderror
            </div>

            {{-- Foto --}}
            <div class="flex flex-col md:col-span-2">
                <label for="foto" class="text-sm text-gray-700 mb-2">Foto (opsional) — seret & lepas atau klik</label>

                <div id="dropzone"
                    class="border-2 border-dashed border-gray-400 rounded-md p-4 sm:p-6 text-center cursor-pointer hover:border-gray-600 transition-colors duration-150">
                    <p id="dz-text" class="text-gray-600 text-sm sm:text-base">Seret & lepas gambar di sini, atau klik untuk pilih file</p>
                    <img id="dz-preview" src="" alt="Preview Foto"
                        class="mx-auto mt-4 hidden max-h-48 object-cover rounded-md shadow-sm">
                </div>

                <input type="file" name="foto" id="foto" accept="image/*" class="hidden">
                @error('foto')
                    <div class="mt-1 text-xs sm:text-sm text-red-700">{{ $message }}</div>
                @enderror

                @isset($capster)
                    <div class="mt-4 flex flex-col sm:flex-row items-start sm:items-center sm:space-x-3 space-y-2 sm:space-y-0">
                        <span class="text-sm text-gray-700">Preview tersimpan:</span>
                        <img src="{{ $capster->foto_url }}" alt="Avatar"
                            class="w-20 h-20 object-cover rounded-md border border-gray-300">
                    </div>
                @endisset
            </div>

            {{-- Status --}}
            <div class="flex flex-col md:col-span-2">
                <label for="status" class="text-sm text-gray-700 mb-1">Status</label>
                <select name="status" id="status" required
                    class="px-3 py-2 text-sm sm:text-base border border-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-600">
                    <option value="Aktif" {{ old('status', $capster->status ?? '') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="sudah keluar" {{ old('status', $capster->status ?? '') == 'sudah keluar' ? 'selected' : '' }}>Sudah Keluar</option>
                </select>
                @error('status')
                    <div class="mt-1 text-xs sm:text-sm text-red-700">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Auto-format nomor HP
        document.querySelectorAll('.phone-format').forEach(input => {
            input.addEventListener('input', e => {
                let digits = e.target.value.replace(/\D/g, '').slice(0, 16);
                let groups = [];
                for (let i = 0; i < digits.length; i += 4) {
                    groups.push(digits.substring(i, i + 4));
                }
                e.target.value = groups.join('-');
            });
        });

        // Dropzone logic
        const dropzone = document.getElementById('dropzone');
        const fileInput = document.getElementById('foto');
        const dzText = document.getElementById('dz-text');
        const dzPreview = document.getElementById('dz-preview');

        dropzone.addEventListener('click', () => fileInput.click());
        fileInput.addEventListener('change', () => {
            if (fileInput.files && fileInput.files[0]) showPreview(fileInput.files[0]);
        });

        ['dragenter', 'dragover'].forEach(evt =>
            dropzone.addEventListener(evt, e => {
                e.preventDefault();
                dropzone.classList.add('border-gray-600', 'bg-gray-50');
            })
        );
        ['dragleave', 'drop'].forEach(evt =>
            dropzone.addEventListener(evt, e => {
                e.preventDefault();
                dropzone.classList.remove('border-gray-600', 'bg-gray-50');
            })
        );
        dropzone.addEventListener('drop', e => {
            const dt = e.dataTransfer;
            if (dt.files && dt.files[0]) {
                fileInput.files = dt.files;
                showPreview(dt.files[0]);
            }
        });

        function showPreview(file) {
            const reader = new FileReader();
            reader.onload = ev => {
                dzPreview.src = ev.target.result;
                dzPreview.classList.remove('hidden');
                dzText.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }
    });
</script>