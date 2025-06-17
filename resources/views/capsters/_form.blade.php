@csrf

<div class="space-y-6 p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
            <input type="text" name="nama" id="nama"
                   value="{{ old('nama', $capster->nama ?? '') }}"
                   class="mt-1 block w-full border border-gray-300 rounded-lg form-input focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                   placeholder="Masukkan nama capster" required>
            @error('nama')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="inisial" class="block text-sm font-medium text-gray-700">Inisial</label>
            <input type="text" name="inisial" id="inisial"
                   value="{{ old('inisial', $capster->inisial ?? '') }}"
                   class="mt-1 block w-full border border-gray-300 rounded-lg form-input focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                   placeholder="Contoh: AB" required>
            @error('inisial')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div class="col-span-full">
            <span class="block text-sm font-medium text-gray-700">Jenis Kelamin</span>
            <div class="mt-2 flex items-center space-x-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="jenis_kelamin" value="L"
                           class="form-radio h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300"
                        {{ old('jenis_kelamin', $capster->jenis_kelamin ?? '') == 'L' ? 'checked' : '' }}>
                    <span class="ml-2 text-gray-700">Laki‑laki</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="jenis_kelamin" value="P"
                           class="form-radio h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300"
                        {{ old('jenis_kelamin', $capster->jenis_kelamin ?? '') == 'P' ? 'checked' : '' }}>
                    <span class="ml-2 text-gray-700">Perempuan</span>
                </label>
            </div>
            @error('jenis_kelamin')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="no_hp" class="block text-sm font-medium text-gray-700">No. HP</label>
            <input type="text" name="no_hp" id="no_hp"
                   value="{{ old('no_hp', $capster->no_hp ?? '') }}"
                   class="mt-1 block w-full border border-gray-300 rounded-lg form-input focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                   placeholder="08xxxxxxxxxx" required>
            @error('no_hp')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="tgl_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
            <input type="date" name="tgl_lahir" id="tgl_lahir"
                   value="{{ old('tgl_lahir', isset($capster) ? $capster->tgl_lahir->toDateString() : '') }}"
                   class="mt-1 block w-full border border-gray-300 rounded-lg form-input focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                   required>
            @error('tgl_lahir')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="asal" class="block text-sm font-medium text-gray-700">Asal</label>
            <input type="text" name="asal" id="asal"
                   value="{{ old('asal', $capster->asal ?? '') }}"
                   class="mt-1 block w-full border border-gray-300 rounded-lg form-input focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                   placeholder="Kota asal" required>
            @error('asal')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div class="col-span-full">
            <label for="foto" class="block text-sm font-medium text-gray-700">Foto</label>
<input
    type="file"
    name="foto"
    id="foto"
    class="mt-1 block w-full border border-gray-300 rounded-lg form-input focus:ring focus:ring-blue-500 focus:ring-opacity-50"
    accept="image/*"
>
@error('foto')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror  
            {{-- Preview jika edit --}}
            @isset($capster)
                <div class="mt-4">
                    <span class="text-sm text-gray-600">Preview saat ini:</span>
                    <img src="{{ $capster->foto_url }}" alt="Avatar" class="mt-2 h-24 w-24 object-cover rounded-full border">
                </div>
            @endisset
        </div>
    </div>
</div>
