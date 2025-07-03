<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
                <i class="bi bi-house-door-fill"></i> Dashboard
            </a>
        </div>
    </nav>
    <div class="container py-5">
        <h2 class="mb-4">Profile level {{ Auth::user()->level }}</h2>

        {{-- Update Profile Information --}}
        <div class="card mb-4">
            <div class="card-header">Update Profile Information</div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" name="name" id="name"
                            value="{{ old('name', auth()->user()->name) }}" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input type="email" class="form-control" name="email" id="email"
                            value="{{ old('email', auth()->user()->email) }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>

        @if (Auth::user()->level === 'admin')
        {{-- Update Profile Information --}}
        <div class="card mb-4">
            <div class="card-header">Casier Account Management</div>
            <div class="card-body">
                <a href="{{ route('kasirs.index') }}" class="btn btn-primary">Kelola Akun Kasir</a>
            </div>
        </div>    
        @endif

        {{-- Update Password --}}
        <div class="card mb-4">
            <div class="card-header">Ubah Password</div>
            <div class="card-body">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Password Lama</label>
                        <input type="password" class="form-control" name="current_password" id="current_password" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
                    </div>

                    <button type="submit" class="btn btn-warning">Ganti Password</button>
                </form>
            </div>
        </div>

        {{-- Delete Account --}}
        <div class="card mb-4">
            <div class="card-header text-danger">Hapus Akun</div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')

                    <p class="mb-3">Akunmu akan dihapus permanen. Tindakan ini tidak bisa dibatalkan.</p>

                    <div class="mb-3">
                        <label for="password_confirm_delete" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" name="password" id="password_confirm_delete" required>
                    </div>

                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Yakin ingin menghapus akunmu? Ini permanen.')">Hapus Akun</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
