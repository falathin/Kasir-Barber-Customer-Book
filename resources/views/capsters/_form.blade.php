@csrf

<div class="application-form">
    <h2 class="form-title">{{ isset($capster) ? 'Edit Data Capster' : 'Formulir Pendaftaran Capster' }}</h2>
    <p class="form-subtitle">Silakan isi data berikut dengan lengkap</p>

    <div class="form-card">
        <div class="form-grid">
            {{-- Nama --}}
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama', $capster->nama ?? '') }}"
                    placeholder="Contoh: Budi Santoso" required>
                @error('nama')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Inisial --}}
            <div class="form-group">
                <label for="inisial">Inisial</label>
                <input type="text" name="inisial" id="inisial"
                    value="{{ old('inisial', $capster->inisial ?? '') }}" placeholder="Contoh: BS" required>
                @error('inisial')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Jenis Kelamin --}}
            <fieldset class="form-group full-width">
                <legend>Jenis Kelamin</legend>
                <label class="radio-label">
                    <input type="radio" name="jenis_kelamin" value="L"
                        {{ old('jenis_kelamin', $capster->jenis_kelamin ?? '') == 'L' ? 'checked' : '' }}> Laki-laki
                </label>
                <label class="radio-label">
                    <input type="radio" name="jenis_kelamin" value="P"
                        {{ old('jenis_kelamin', $capster->jenis_kelamin ?? '') == 'P' ? 'checked' : '' }}> Perempuan
                </label>
                @error('jenis_kelamin')
                    <div class="error">{{ $message }}</div>
                @enderror
            </fieldset>

            {{-- No. HP --}}
            <div class="form-group">
                <label for="no_hp">No. HP</label>
                <input type="text" name="no_hp" id="no_hp" class="phone-format"
                    value="{{ old('no_hp', $capster->no_hp ?? '') }}" placeholder="0809-123-4567" required>
                @error('no_hp')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            {{-- No. HP Keluarga --}}
            <div class="form-group">
                <label for="no_hp_keluarga">No. HP Keluarga (opsional)</label>
                <input type="text" name="no_hp_keluarga" id="no_hp_keluarga" class="phone-format"
                    value="{{ old('no_hp_keluarga', $capster->no_hp_keluarga ?? '') }}" placeholder="0809-123-4567">
                @error('no_hp_keluarga')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tanggal Lahir --}}
            <div class="form-group">
                <label for="tgl_lahir">Tanggal Lahir</label>
                <input type="date" name="tgl_lahir" id="tgl_lahir"
                    value="{{ old('tgl_lahir', isset($capster) ? $capster->tgl_lahir->toDateString() : '') }}"
                    required>
                @error('tgl_lahir')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Asal / Alamat --}}
            <div class="form-group full-width">
                <label for="asal">Asal / Alamat</label>
                <textarea name="asal" id="asal" rows="3" placeholder="Contoh: Jl. Merdeka No.123, Bandung" required
                    class="px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('asal', $capster->asal ?? '') }}</textarea>
                @error('asal')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Foto (drag & drop) --}}
            <div class="form-group full-width">
                <label for="foto">Foto (opsional) — seret & lepas atau klik</label>

                {{-- Dropzone --}}
                <div id="dropzone"
                    class="border-2 border-dashed border-gray-400 rounded-md p-6 text-center cursor-pointer hover:border-indigo-500 transition">
                    <p id="dz-text" class="text-gray-600">Seret & lepas gambar di sini, atau klik untuk pilih file</p>
                    <img id="dz-preview" src="" alt="Preview Foto"
                        class="mx-auto mt-4 hidden max-h-48 object-cover rounded-md shadow-sm">
                </div>

                {{-- Hidden file input --}}
                <input type="file" name="foto" id="foto" accept="image/*" class="hidden">
                @error('foto')
                    <div class="error">{{ $message }}</div>
                @enderror

                {{-- Preview saat ini (edit mode) --}}
                @isset($capster)
                    <div class="photo-preview mt-4">
                        <span>Preview tersimpan:</span>
                        <img src="{{ $capster->foto_url }}" alt="Avatar"
                            class="h-20 w-20 object-cover rounded-md border">
                    </div>
                @endisset
            </div>

            {{-- Status --}}
            <div class="form-group full-width">
                <label for="status">Status</label>
                <select name="status" id="status" required>
                    <option value="Aktif" {{ old('status', $capster->status ?? '') == 'Aktif' ? 'selected' : '' }}>
                        Aktif</option>
                    <option value="sudah keluar"
                        {{ old('status', $capster->status ?? '') == 'sudah keluar' ? 'selected' : '' }}>Sudah Keluar
                    </option>
                </select>
                @error('status')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // auto-format every 4 digits with a hyphen
        document.querySelectorAll('.phone-format').forEach(input => {
            input.addEventListener('input', e => {
                // strip non‑digits and limit length (e.g. 16 digits max)
                let digits = e.target.value.replace(/\D/g, '').slice(0, 16);
                // split into chunks of 4
                let groups = [];
                for (let i = 0; i < digits.length; i += 4) {
                    groups.push(digits.substring(i, i + 4));
                }
                // join with hyphens
                e.target.value = groups.join('-');
            });
        });

        // existing dropzone logic...
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
                dropzone.classList.add('border-indigo-500', 'bg-indigo-50');
            })
        );
        ['dragleave', 'drop'].forEach(evt =>
            dropzone.addEventListener(evt, e => {
                e.preventDefault();
                dropzone.classList.remove('border-indigo-500', 'bg-indigo-50');
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

<style>
    /* Background like letterhead */
    .application-form {
        background: #faf8f4 url('data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="50" height="50"%3E%3Ctext x="0" y="40" font-family="serif" font-size="40" fill="%23eee" opacity="0.1"%3E✒️%3C/text%3E%3C/svg%3E') repeat;
        padding: 40px;
        max-width: 900px;
        margin: 0 auto;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-family: 'Times New Roman', serif;
    }

    .form-title {
        text-align: center;
        font-size: 2rem;
        margin-bottom: 0.2rem;
        color: #333;
        font-weight: bold;
    }

    .form-subtitle {
        text-align: center;
        font-size: 1rem;
        color: #555;
        margin-bottom: 1.5rem;
    }

    .form-card {
        background: #fff;
        padding: 24px;
        border-radius: 8px;
        border: 1px solid #ccc;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
    }

    @media (min-width: 768px) {
        .form-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .full-width {
            grid-column: span 2;
        }
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        font-size: 0.9rem;
        margin-bottom: 6px;
        color: #444;
    }

    .form-group input[type="text"],
    .form-group input[type="date"],
    .form-group select,
    .form-group input[type="file"],
    .form-group textarea {
        padding: 8px 10px;
        font-size: 1rem;
        border: 1px solid #999;
        border-radius: 4px;
        outline: none;
        transition: border-color .2s;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        border-color: #555;
    }

    fieldset.form-group {
        border: 1px solid #999;
        padding: 12px;
        border-radius: 4px;
    }

    fieldset.form-group legend {
        padding: 0 6px;
        font-weight: bold;
        color: #444;
    }

    .radio-label {
        margin-right: 16px;
        font-size: 1rem;
        color: #333;
    }

    .radio-label input {
        margin-right: 4px;
    }

    .photo-preview {
        margin-top: 12px;
        display: flex;
        align-items: center;
    }

    .photo-preview span {
        margin-right: 10px;
        font-size: 0.9rem;
        color: #555;
    }

    .photo-preview img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .error {
        margin-top: 4px;
        font-size: 0.85rem;
        color: #b00;
    }

    .application-form::-webkit-scrollbar {
        width: 8px;
    }

    .application-form::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 4px;
    }

    .application-form::-webkit-scrollbar-track {
        background: transparent;
    }
</style>