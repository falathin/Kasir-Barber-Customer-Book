@csrf

<div class="application-form">
  <h2 class="form-title">Formulir Pendaftaran Capster</h2>
  <p class="form-subtitle">Silakan isi data berikut dengan lengkap</p>

  <div class="form-card">
    <div class="form-grid">

      {{-- Nama --}}
      <div class="form-group">
        <label for="nama">Nama Lengkap</label>
        <input type="text" name="nama" id="nama"
               value="{{ old('nama', $capster->nama ?? '') }}"
               placeholder="Contoh: Budi Santoso" required>
        @error('nama')<div class="error">{{ $message }}</div>@enderror
      </div>

      {{-- Inisial --}}
      <div class="form-group">
        <label for="inisial">Inisial</label>
        <input type="text" name="inisial" id="inisial"
               value="{{ old('inisial', $capster->inisial ?? '') }}"
               placeholder="Contoh: BS" required>
        @error('inisial')<div class="error">{{ $message }}</div>@enderror
      </div>

      {{-- Jenis Kelamin --}}
      <fieldset class="form-group full-width">
        <legend>Jenis Kelamin</legend>
        <label class="radio-label"><input type="radio" name="jenis_kelamin" value="L"
          {{ old('jenis_kelamin', $capster->jenis_kelamin ?? '')=='L'?'checked':'' }}> Laki-laki</label>
        <label class="radio-label"><input type="radio" name="jenis_kelamin" value="P"
          {{ old('jenis_kelamin', $capster->jenis_kelamin ?? '')=='P'?'checked':'' }}> Perempuan</label>
        @error('jenis_kelamin')<div class="error">{{ $message }}</div>@enderror
      </fieldset>

      {{-- No. HP --}}
      <div class="form-group">
        <label for="no_hp">No. HP</label>
        <input type="text" name="no_hp" id="no_hp"
               value="{{ old('no_hp', $capster->no_hp ?? '') }}"
               placeholder="08xxxxxxxxxx" required>
        @error('no_hp')<div class="error">{{ $message }}</div>@enderror
      </div>

      {{-- Tanggal Lahir --}}
      <div class="form-group">
        <label for="tgl_lahir">Tanggal Lahir</label>
        <input type="date" name="tgl_lahir" id="tgl_lahir"
               value="{{ old('tgl_lahir', isset($capster)?$capster->tgl_lahir->toDateString():'') }}"
               required>
        @error('tgl_lahir')<div class="error">{{ $message }}</div>@enderror
      </div>

      {{-- Asal --}}
      <div class="form-group">
        <label for="asal">Asal</label>
        <input type="text" name="asal" id="asal"
               value="{{ old('asal', $capster->asal ?? '') }}"
               placeholder="Kota asal" required>
        @error('asal')<div class="error">{{ $message }}</div>@enderror
      </div>

      {{-- Foto --}}
      <div class="form-group full-width">
        <label for="foto">Foto (opsional)</label>
        <input type="file" name="foto" id="foto" accept="image/*">
        @error('foto')<div class="error">{{ $message }}</div>@enderror

        @isset($capster)
          <div class="photo-preview">
            <span>Preview saat ini:</span>
            <img src="{{ $capster->foto_url }}" alt="Avatar">
          </div>
        @endisset
      </div>

      {{-- Status --}}
      <div class="form-group full-width">
        <label for="status">Status</label>
        <select name="status" id="status" required>
          <option value="Aktif" {{ old('status',$capster->status??'')=='Aktif'?'selected':'' }}>Aktif</option>
          <option value="sudah keluar" {{ old('status',$capster->status??'')=='sudah keluar'?'selected':'' }}>Sudah Keluar</option>
        </select>
        @error('status')<div class="error">{{ $message }}</div>@enderror
      </div>

    </div>
  </div>
</div>

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

/* Form title */
.form-title {
  text-align: center;
  font-size: 2rem;
  margin-bottom: 0.2rem;
  color: #333;
  font-weight: bold;
}
/* Subtitle */
.form-subtitle {
  text-align: center;
  font-size: 1rem;
  color: #555;
  margin-bottom: 1.5rem;
}

/* Individual card */
.form-card {
  background: #fff;
  padding: 24px;
  border-radius: 8px;
  border: 1px solid #ccc;
}

/* Two-column grid */
.form-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 20px;
}
@media (min-width: 768px) {
  .form-grid { grid-template-columns: repeat(2,1fr); }
  .full-width { grid-column: span 2; }
}

/* Field styling */
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
.form-group input[type="file"] {
  padding: 8px 10px;
  font-size: 1rem;
  border: 1px solid #999;
  border-radius: 4px;
  outline: none;
  transition: border-color .2s;
}
.form-group input:focus,
.form-group select:focus {
  border-color: #555;
}

/* Fieldset */
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

/* Radios */
.radio-label {
  margin-right: 16px;
  font-size: 1rem;
  color: #333;
}
.radio-label input {
  margin-right: 4px;
}

/* Photo preview */
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

/* Error messages */
.error {
  margin-top: 4px;
  font-size: 0.85rem;
  color: #b00;
}

/* Scrollbar style for long forms */
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
