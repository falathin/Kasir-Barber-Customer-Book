{{-- resources/views/profile.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Profile | {{ config('app.name') }}</title>
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    :root {
      --burgundy: #5D0F0F;
      --gold:     #D69E2E;
    }
  </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

  {{-- Navbar --}}
  <nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
      <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
        <img src="{{ asset('images/bb-logo.png') }}" alt="Logo" class="h-10 w-auto">
        <span class="text-2xl font-extrabold text-[var(--burgundy)]">BB Men’s Haircut</span>
      </a>
    </div>
  </nav>

  <main class="max-w-7xl mx-auto px-6 py-12 flex-1">
    <header class="text-center mb-12">
      <h1 class="text-4xl font-extrabold text-[var(--burgundy)] inline-flex items-center space-x-3">
        <i class="bi bi-person-circle text-[var(--gold)] text-5xl"></i>
        <span>Profile</span>
        <span class="ml-4 px-4 py-1 rounded-full bg-[var(--gold)] text-[var(--burgundy)] font-semibold">
        {{ Str::title(Auth::user()->level) }}
        </span>
      </h1>
    </header>

    {{-- Grid: two columns on md+, single on sm --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

      {{-- Update Profile --}}
      <section class="bg-white rounded-3xl shadow-xl border-4 border-[var(--gold)] overflow-hidden">
        <div class="bg-[var(--burgundy)] text-white px-8 py-5 flex items-center space-x-3">
          <i class="bi bi-person-lines-fill text-2xl"></i>
          <h2 class="text-2xl font-semibold">Update Profile</h2>
        </div>
        <div class="p-8">
          <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
            @csrf @method('PATCH')

            <div>
              <label for="name" class="block text-sm font-medium text-[var(--burgundy)]">Nama</label>
              <input type="text" id="name" name="name" required autofocus
                     value="{{ old('name', auth()->user()->name) }}"
                     class="mt-2 w-full rounded-full border border-gray-300 px-5 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--gold)] focus:border-[var(--gold)] transition" />
              @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
              <label for="email" class="block text-sm font-medium text-[var(--burgundy)]">Email</label>
              <input type="email" id="email" name="email" required
                     value="{{ old('email', auth()->user()->email) }}"
                     class="mt-2 w-full rounded-full border border-gray-300 px-5 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--gold)] focus:border-[var(--gold)] transition" />
              @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <button type="submit"
                    class="w-full bg-[var(--burgundy)] text-white rounded-full py-3 font-bold hover:bg-opacity-90 transition">
              Simpan
            </button>
          </form>
        </div>
      </section>

      {{-- Update Password --}}
      <section class="bg-white rounded-3xl shadow-xl border-4 border-[var(--gold)] overflow-hidden">
        <div class="bg-[var(--burgundy)] text-white px-8 py-5 flex items-center space-x-3">
          <i class="bi bi-key-fill text-2xl"></i>
          <h2 class="text-2xl font-semibold">Ubah Password</h2>
        </div>
        <div class="p-8">
          <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
            @csrf @method('PUT')

            <div>
              <label for="current_password" class="block text-sm font-medium text-[var(--burgundy)]">Password Lama</label>
              <input type="password" id="current_password" name="current_password" required
                     class="mt-2 w-full rounded-full border border-gray-300 px-5 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--gold)] focus:border-[var(--gold)] transition" />
              @error('current_password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
              <label for="password" class="block text-sm font-medium text-[var(--burgundy)]">Password Baru</label>
              <input type="password" id="password" name="password" required
                     class="mt-2 w-full rounded-full border border-gray-300 px-5 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--gold)] focus:border-[var(--gold)] transition" />
              @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
              <label for="password_confirmation" class="block text-sm font-medium text-[var(--burgundy)]">Konfirmasi Password</label>
              <input type="password" id="password_confirmation" name="password_confirmation" required
                     class="mt-2 w-full rounded-full border border-gray-300 px-5 py-3 focus:outline-none focus:ring-2 focus:ring-[var(--gold)] focus:border-[var(--gold)] transition" />
              @error('password_confirmation')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <button type="submit"
                    class="w-full bg-[var(--gold)] text-[var(--burgundy)] rounded-full py-3 font-bold hover:bg-opacity-90 transition">
              Ganti Password
            </button>
          </form>
        </div>
      </section>

      {{-- Cashier Management (Admin) --}}
      @if(Auth::user()->level === 'admin')
      <section class="bg-white rounded-3xl shadow-xl border-4 border-[var(--gold)] overflow-hidden">
        <div class="bg-[var(--burgundy)] text-white px-8 py-5 flex items-center space-x-3">
          <i class="bi bi-people-fill text-2xl"></i>
          <h2 class="text-2xl font-semibold">Kelola Kasir</h2>
        </div>
        <div class="p-8 flex justify-center">
          <a href="{{ route('kasirs.index') }}"
             class="inline-flex items-center bg-[var(--gold)] text-[var(--burgundy)] px-8 py-3 rounded-full font-semibold hover:bg-opacity-90 transition">
            <i class="bi bi-gear-fill mr-2"></i> Buka Panel
          </a>
        </div>
      </section>
      @endif

      {{-- Delete Account --}}
      <section class="bg-white rounded-3xl shadow-xl border-4 border-[var(--gold)] overflow-hidden">
        <div class="bg-[var(--burgundy)] text-white px-8 py-5 flex items-center space-x-3">
          <i class="bi bi-trash-fill text-2xl"></i>
          <h2 class="text-2xl font-semibold">Hapus Akun</h2>
        </div>
        <div class="p-8 space-y-6">
          <p class="text-gray-700">Akun akan dihapus <strong>permanen</strong>. Tindakan ini tidak dapat dibatalkan.</p>
          <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-4">
            @csrf @method('DELETE')

            <div>
              <label for="password_confirm_delete" class="block text-sm font-medium text-[var(--burgundy)]">Konfirmasi Password</label>
              <input type="password" id="password_confirm_delete" name="password" required
                     class="mt-2 w-full rounded-full border border-gray-300 px-5 py-3 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition" />
              @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <button type="submit"
                    class="w-full bg-red-600 text-white rounded-full py-3 font-bold hover:bg-red-700 transition"
                    onclick="return confirm('Yakin ingin menghapus akun? Ini permanen.')">
              Hapus Akun
            </button>
          </form>
        </div>
      </section>

    </div>
  </main>

</body>
</html>