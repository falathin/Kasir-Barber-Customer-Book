{{-- resources/views/kasirs/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Kasir')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" referrerpolicy="no-referrer" />

<div class="min-h-screen">
    <div class="mx-auto max-w-4xl animate__animated animate__fadeInUp">
        <div class="relative overflow-hidden rounded-[2rem] border border-[#e0a33a]/40 bg-white shadow-2xl">
            <div class="absolute inset-x-0 top-0 h-2 bg-gradient-to-r from-[#e0a33a] via-[#7a1422] to-[#203b5a]"></div>

            <div class="grid gap-0 lg:grid-cols-5">
                {{-- Panel kiri --}}
                <div class="relative hidden overflow-hidden bg-gradient-to-br from-[#4b0f16] via-[#6d1220] to-[#1f2633] px-8 py-10 text-white lg:col-span-2 lg:block">
                    <div class="absolute inset-0 opacity-20"
                        style="background-image: repeating-linear-gradient(135deg, rgba(224,163,58,0.18) 0 12px, transparent 12px 24px);">
                    </div>

                    <div class="absolute -right-8 top-6 h-24 w-24 rounded-full bg-[#e0a33a]/15 blur-2xl"></div>
                    <div class="absolute -bottom-10 -left-8 h-28 w-28 rounded-full bg-white/10 blur-3xl"></div>

                    <div class="relative z-10 flex h-full flex-col justify-between">
                        <div>
                            <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-[#e0a33a]/30 bg-white/10 px-4 py-2 text-xs font-semibold tracking-[0.2em] text-white/90">
                                <i class="fa-solid fa-scissors text-[#e0a33a]"></i>
                                BARBERSHOP
                            </div>

                            <h2 class="text-3xl font-black leading-tight tracking-tight">
                                Tambah <span class="text-[#e0a33a]">Kasir Baru</span>
                            </h2>

                            <p class="mt-4 max-w-sm text-sm leading-6 text-white/75">
                                Buat akun kasir dengan tampilan yang terinspirasi dari warna logo barbershop kamu.
                            </p>
                        </div>

                        <div class="mt-8 rounded-3xl border border-white/10 bg-white/5 p-4 backdrop-blur">
                            <div class="flex items-center gap-3">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-[#e0a33a] to-[#7a1422] text-xl text-white shadow-lg shadow-black/20">
                                    <i class="fa-solid fa-user-tie"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-white">Form Kasir</p>
                                    <p class="text-sm text-white/70">Emas · Maroon · Navy</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Form --}}
                <div class="px-5 py-8 sm:px-8 lg:col-span-3 lg:px-10 lg:py-10">
                    <div class="mb-8 flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-[#7a1422]">Form Kasir</p>
                            <h1 class="mt-2 text-2xl font-bold text-slate-900 sm:text-3xl">
                                <i class="fa-solid fa-user-plus mr-2 text-[#e0a33a]"></i>
                                Tambah Kasir Baru
                            </h1>
                            <p class="mt-2 text-sm text-slate-500">Isi data akun kasir di bawah ini.</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('kasirs.store') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label for="name" class="mb-1 block text-sm font-semibold text-slate-700">
                                <i class="fa-solid fa-id-card mr-2 text-[#7a1422]"></i>
                                Nama Lengkap
                            </label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                autocomplete="name"
                                placeholder="Masukkan nama kasir"
                                class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-[#7a1422] focus:ring-4 focus:ring-[#e0a33a]/15 @error('name') border-red-500 ring-4 ring-red-500/10 @enderror"
                            />
                            @error('name')
                                <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="mb-1 block text-sm font-semibold text-slate-700">
                                <i class="fa-solid fa-envelope mr-2 text-[#7a1422]"></i>
                                Alamat Email
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                                placeholder="kasir@example.com"
                                class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-[#7a1422] focus:ring-4 focus:ring-[#e0a33a]/15 @error('email') border-red-500 ring-4 ring-red-500/10 @enderror"
                            />
                            @error('email')
                                <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="password" class="mb-1 block text-sm font-semibold text-slate-700">
                                    <i class="fa-solid fa-lock mr-2 text-[#7a1422]"></i>
                                    Kata Sandi
                                </label>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    required
                                    autocomplete="new-password"
                                    placeholder="••••••••"
                                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-[#7a1422] focus:ring-4 focus:ring-[#e0a33a]/15 @error('password') border-red-500 ring-4 ring-red-500/10 @enderror"
                                />
                                @error('password')
                                    <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="mb-1 block text-sm font-semibold text-slate-700">
                                    <i class="fa-solid fa-shield-halved mr-2 text-[#203b5a]"></i>
                                    Konfirmasi Kata Sandi
                                </label>
                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    required
                                    autocomplete="new-password"
                                    placeholder="••••••••"
                                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-[#203b5a] focus:ring-4 focus:ring-[#e0a33a]/15 @error('password_confirmation') border-red-500 ring-4 ring-red-500/10 @enderror"
                                />
                                @error('password_confirmation')
                                    <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="rounded-2xl border border-dashed border-[#e0a33a]/40 bg-[#fdf8f0] px-4 py-4">
                            <div class="flex items-start gap-3">
                                <div class="mt-0.5 rounded-full bg-[#7a1422] px-2.5 py-1 text-xs font-bold text-white">TIP</div>
                                <p class="text-sm leading-6 text-slate-600">
                                    Gunakan email aktif dan kata sandi yang kuat agar akun kasir tetap aman dan mudah dikelola.
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3 pt-2 sm:flex-row sm:justify-end">
                            <a
                                href="{{ route('kasirs.index') }}"
                                class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-6 py-3 font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 hover:text-slate-900"
                            >
                                <i class="fa-solid fa-arrow-left mr-2 text-[#203b5a]"></i>
                                Batal
                            </a>

                            <button
                                type="submit"
                                class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-[#7a1422] via-[#a61d2b] to-[#203b5a] px-6 py-3 font-semibold text-white shadow-lg shadow-[#7a1422]/20 transition hover:scale-[1.01] hover:shadow-xl hover:shadow-[#7a1422]/25 active:scale-[0.99]"
                            >
                                <i class="fa-solid fa-floppy-disk mr-2 text-[#e0a33a]"></i>
                                Simpan Kasir
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection