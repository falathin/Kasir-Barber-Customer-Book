{{-- resources/views/kasirs/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Akun Cabang Kasir')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
        referrerpolicy="no-referrer" />

    <div class="min-h-screen">
        <div class="mx-auto max-w-4xl animate__animated animate__fadeInUp">
            <div class="relative overflow-hidden rounded-[2rem] border border-[#e0a33a]/40 bg-white shadow-2xl">
                <div class="absolute inset-x-0 top-0 h-2 bg-gradient-to-r from-[#e0a33a] via-[#7a1422] to-[#203b5a]"></div>

                <div class="grid gap-0 lg:grid-cols-5">
                    {{-- Panel kiri --}}
                    <div
                        class="relative hidden overflow-hidden bg-gradient-to-br from-[#4b0f16] via-[#6d1220] to-[#1f2633] px-8 py-10 text-white lg:col-span-2 lg:block">
                        <div class="absolute inset-0 opacity-20"
                            style="background-image: repeating-linear-gradient(135deg, rgba(224,163,58,0.18) 0 12px, transparent 12px 24px);">
                        </div>

                        <div class="absolute -right-8 top-6 h-24 w-24 rounded-full bg-[#e0a33a]/15 blur-2xl"></div>
                        <div class="absolute -bottom-10 -left-8 h-28 w-28 rounded-full bg-white/10 blur-3xl"></div>

                        <div class="relative z-10 flex h-full flex-col justify-between">
                            <div>
                                <div
                                    class="mb-4 inline-flex items-center gap-2 rounded-full border border-[#e0a33a]/30 bg-white/10 px-4 py-2 text-xs font-semibold tracking-[0.2em] text-white/90">
                                    <i class="fa-solid fa-shop text-[#e0a33a]"></i>
                                    CABANG KASIR
                                </div>

                                <h2 class="text-3xl font-black leading-tight tracking-tight">
                                    Tambah <span class="text-[#e0a33a]">Akun Cabang</span>
                                </h2>

                                <p class="mt-4 max-w-sm text-sm leading-6 text-white/75">
                                    Buat akun kasir untuk cabang terbaru agar operasional dan transaksi dapat dikelola
                                    secara terpisah dan lebih rapi.
                                </p>
                            </div>

                            <div class="mt-8 rounded-3xl border border-white/10 bg-white/5 p-4 backdrop-blur">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-[#e0a33a] to-[#7a1422] text-xl text-white shadow-lg shadow-black/20">
                                        <i class="fa-solid fa-store"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-white">Akun Cabang Baru</p>
                                        <p class="text-sm text-white/70">Kelola kasir per cabang</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Form --}}
                    <div class="px-5 py-8 sm:px-8 lg:col-span-3 lg:px-10 lg:py-10">
                        <div class="mb-8 flex items-start justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-[#7a1422]">Manajemen Cabang
                                </p>
                                <h1 class="mt-2 text-2xl font-bold text-slate-900 sm:text-3xl">
                                    <i class="fa-solid fa-shop-circle-check mr-2 text-[#e0a33a]"></i>
                                    Buat Akun Cabang Kasir
                                </h1>
                                <p class="mt-2 text-sm text-slate-500">
                                    Masukkan data akun kasir untuk cabang terbaru di bawah ini.
                                </p>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('kasirs.store') }}" class="space-y-5">
                            @csrf

                            <div>
                                <label for="name" class="mb-1 block text-sm font-semibold text-slate-700">
                                    <i class="fa-solid fa-id-card mr-2 text-[#7a1422]"></i>
                                    Nama Kasir / Cabang
                                </label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                    placeholder="Contoh: Kasir Cabang Karawang"
                                    class="w-full rounded-2xl border border-slate-200 px-4 py-3" />
                            </div>

                            <div>
                                <label for="email" class="mb-1 block text-sm font-semibold text-slate-700">
                                    <i class="fa-solid fa-envelope mr-2 text-[#7a1422]"></i>
                                    Email Cabang
                                </label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                    placeholder="cabang@email.com"
                                    class="w-full rounded-2xl border border-slate-200 px-4 py-3" />
                            </div>

                            <div class="grid gap-5 sm:grid-cols-2">
                                <div>
                                    <label for="password" class="mb-1 block text-sm font-semibold text-slate-700">
                                        <i class="fa-solid fa-lock mr-2 text-[#7a1422]"></i>
                                        Password Cabang
                                    </label>
                                    <input type="password" id="password" name="password" required
                                        placeholder="Minimal 8 karakter"
                                        class="w-full rounded-2xl border border-slate-200 px-4 py-3" />
                                </div>

                                <div>
                                    <label for="password_confirmation"
                                        class="mb-1 block text-sm font-semibold text-slate-700">
                                        <i class="fa-solid fa-shield-halved mr-2 text-[#203b5a]"></i>
                                        Konfirmasi Password
                                    </label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" required
                                        placeholder="Ulangi password"
                                        class="w-full rounded-2xl border border-slate-200 px-4 py-3" />
                                </div>
                            </div>

                            <div class="rounded-2xl border border-dashed border-[#e0a33a]/40 bg-[#fdf8f0] px-4 py-4">
                                <div class="flex items-start gap-3">
                                    <div class="mt-0.5 rounded-full bg-[#7a1422] px-2.5 py-1 text-xs font-bold text-white">
                                        INFO</div>
                                    <p class="text-sm text-slate-600">
                                        Setiap cabang sebaiknya memiliki akun kasir sendiri untuk memudahkan monitoring
                                        transaksi dan laporan keuangan.
                                    </p>
                                </div>
                            </div>

                            <div class="flex flex-col gap-3 pt-2 sm:flex-row sm:justify-end">
                                <a href="{{ route('kasirs.index') }}" class="rounded-2xl border px-6 py-3">
                                    Kembali
                                </a>

                                <button type="submit" class="rounded-2xl bg-[#7a1422] px-6 py-3 text-white">
                                    Simpan Akun Cabang
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
